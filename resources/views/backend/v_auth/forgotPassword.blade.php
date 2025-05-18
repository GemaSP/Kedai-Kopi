@extends('backend.v_auth_layouts.app')
@section('content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-2">Lupa Password Kamu?</h1>
                        <p class="mb-4">Kita mengerti, sesuatu terjadi. Cukup masukkan alamat emailmu dibawah ini
                            dan kita akan mengirim mu link untuk mereset passwordmu!</p>
                    </div>
                    <form class="user">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-user"
                                id="email" aria-describedby="emailHelp"
                                placeholder="Masukkan Alamat Email...">
                        </div>
                        <a href="login.html" class="btn btn-primary btn-user btn-block">
                            Reset Password
                        </a>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('backend.registrasi') }}">Buat Akun!</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="{{ route('backend.login') }}">Sudah punya akun? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection