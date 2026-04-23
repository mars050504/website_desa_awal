@extends('layouts.admin')

@section('content')

<h3>Edit Surat</h3>

<form method="POST" action="/kelola-surat/{{ $surat->id }}/update-isi">
    @csrf

    <textarea name="isi" id="editor" style="width:100%; height:400px;">
{{ $isi }}
    </textarea>

    <br><br>

    <button type="submit" class="btn btn-primary">Simpan</button>

    <a href="/kelola-surat/{{ $surat->id }}/pdf" class="btn btn-success">
        Download PDF
    </a>

</form>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>

@endsection