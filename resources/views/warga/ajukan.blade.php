@extends('layouts.warga')

@section('content')

<div class="container-warga">

    <div class="step-wrapper">
        <div class="step active"><span>1</span>
            <p>Pilih Jenis</p>
        </div>
        <div class="line"></div>
        <div class="step"><span>2</span>
            <p>Isi Data</p>
        </div>
        <div class="line"></div>
        <div class="step"><span>3</span>
            <p>Konfirmasi</p>
        </div>
    </div>

    <div class="card-warga modern-card">

        <div class="alert-info">
            <i class="fa-solid fa-circle-info"></i>
            Mohon isi data dengan benar dan sesuai template yang telah disediakan.
            Kesalahan atau ketidaksesuaian data dapat menyebabkan pengajuan ditolak
            atau memperlambat proses penerbitan surat.
        </div>

        <form method="POST" action="/ajukan-surat" enctype="multipart/form-data">
            @csrf

            <div class="step-content active" id="step-1">
                <h3>Pilih Jenis Surat</h3>

                <div class="jenis-grid">
                    @foreach($jenisSurat as $j)
                    <label class="jenis-card">
                        <input type="radio" name="jenis" value="{{ $j->id }}" required>
                        <i class="fas fa-file-alt"></i>
                        <span>{{ $j->nama_jenis }}</span>
                    </label>
                    @endforeach
                </div>

                <div class="form-action">
                    <button type="button" class="btn-primary" onclick="nextStep(1)">Lanjut</button>
                </div>
            </div>

            <div class="step-content" id="step-2">
                <h3>Isi Data</h3>

                <div id="templateSurat"></div>

                <div class="form-group">
                    <label>Nama Pemohon</label>
                    <input type="text" name="nama" value="{{ auth()->user()->name }}">
                </div>

                <div id="dynamicForm"></div>

                <div class="file-grid">
                    <div class="file-card">
                        <label>KTP</label>
                        <input type="file" name="dok_ktp">
                    </div>
                    <div class="file-card">
                        <label>KK</label>
                        <input type="file" name="dok_kk">
                    </div>
                    <div class="file-card">
                        <label>Dokumen Pendukung</label>
                        <input type="file" name="dok_pengantar">
                    </div>
                </div>

                <div class="form-action">
                    <button type="button" class="btn-warning" onclick="prevStep(2)">Kembali</button>
                    <button type="button" class="btn-primary" onclick="nextStep(2)">Lanjut</button>
                </div>
            </div>

            <div class="step-content" id="step-3">
                <h3>Konfirmasi Data</h3>
                <div id="confirmData"></div>

                <div class="form-action">
                    <button type="button" class="btn-warning" onclick="prevStep(3)">Kembali</button>
                    <button type="submit" class="btn-primary">Kirim</button>
                </div>
            </div>

        </form>

    </div>
</div>

@endsection


<script>
    function loadForm(jenisId) {

        let templateDiv = document.getElementById('templateSurat');

        let templates = {
            1: 'template_domisili.pdf',
            2: 'template_sku.pdf',
            3: 'template_sktm.pdf',
            4: 'template_kelahiran.pdf',
            5: 'template_kehilangan.pdf',
            6: 'template_kematian.pdf',
            7: 'template_skck.pdf',
            8: 'template_tanah.pdf'
        };

        let panduan = {
            1: "KTP, KK, alamat domisili",
            2: "KTP, KK, foto usaha, surat pengantar",
            3: "KTP, KK, surat tidak mampu",
            4: "KTP orang tua, KK, surat kelahiran",
            5: "KTP, surat kehilangan dari polisi",
            6: "KTP almarhum, KK, surat kematian",
            7: "KTP, KK, surat pengantar",
            8: "KTP, KK, SPPT / PBB, bukti tanah"
        };

        if (templates[jenisId]) {

            let file = templates[jenisId];

            let nama = file
                .replace('template_', '')
                .replace('.pdf', '')
                .toUpperCase();

            templateDiv.innerHTML = `
            <div class="template-wrapper">
    <div class="template-box">
        <a href="/template/${file}" target="_blank">
            <i class="fa-solid fa-file-pdf"></i>
            Contoh Surat ${nama}
        </a>
        <small>Gunakan sebagai acuan</small>
    </div>

    <div class="panduan-box">
        <i class="fas fa-circle-info"></i>
        <span><b>Dokumen:</b> ${panduan[jenisId]}</span>
    </div>

</div>
        `;
        }

        fetch('/form-surat/' + jenisId)
            .then(res => res.text())
            .then(html => {
                document.getElementById('dynamicForm').innerHTML = html;
            });
    }

    function updateStepIndicator(currentStep) {
        let steps = document.querySelectorAll('.step');
        let lines = document.querySelectorAll('.line');

        steps.forEach((step, index) => {
            step.classList.toggle('active', index < currentStep);
        });

        lines.forEach((line, index) => {
            line.classList.toggle('active', index < currentStep - 1);
        });
    }

    function generateConfirmation() {
        let confirmDiv = document.getElementById('confirmData');
        confirmDiv.innerHTML = '';

        let elements = document.querySelectorAll('#step-2 input, #step-2 select, #step-2 textarea');

        elements.forEach(el => {

            if (!el.name || el.type === 'hidden') return;

            if (el.type === 'file' && el.files.length === 0) return;

            let label = el.name.replace(/_/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase());

            let value = '';

            if (el.type === 'text' || el.tagName === 'TEXTAREA') {
                value = el.value;
            } else if (el.tagName === 'SELECT') {
                value = el.options[el.selectedIndex]?.text;
            } else if (el.type === 'radio') {
                if (!el.checked) return;
                let span = el.closest('label')?.querySelector('span');
                value = span ? span.innerText : el.value;
            } else if (el.type === 'file') {
                value = el.files[0].name;
            }

            if (!value) return;

            confirmDiv.innerHTML += `
        <div style="margin-bottom:10px;padding:8px;border-bottom:1px solid #eee">
            <b>${label}:</b> ${value}
        </div>
        `;
        });
    }

    function nextStep(step) {

        if (step === 1) {
            let jenis = document.querySelector('[name=jenis]:checked');

            if (!jenis) {
                alert('Pilih jenis surat dulu!');
                return;
            }

            loadForm(jenis.value);
        }

        document.getElementById('step-' + step).classList.remove('active');
        document.getElementById('step-' + (step + 1)).classList.add('active');

        updateStepIndicator(step + 1);

        if (step === 2) {
            setTimeout(() => generateConfirmation(), 100);
        }
    }

    function prevStep(step) {
        document.getElementById('step-' + step).classList.remove('active');
        document.getElementById('step-' + (step - 1)).classList.add('active');

        updateStepIndicator(step - 1);
    }
</script>