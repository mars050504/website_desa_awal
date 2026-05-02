@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h4>Verifikasi OTP</h4>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="/verify-otp" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Kode OTP</label>

                            <input type="text"
                                   name="otp"
                                   class="form-control"
                                   placeholder="Masukkan kode OTP"
                                   required>
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100">

                            Verifikasi OTP
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
