@extends('backend.v_auth_layouts.app')
@section('content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                    </div>
                    @if (session()->has('Sukses'))
                    <div class="alert-success">
                        <p>{{ session('Sukses') }}</p>
                    </div>
                    @elseif (session()->has('gagal'))
                    <div class="alert-danger">
                        <p>{{ session('gagal') }}</p>
                    </div>
                    @endif
                    <form class="user" method="post" action="{{ route('backend.storeLogin') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-user"
                                id="email" aria-describedby="emailHelp"
                                placeholder="Masukkan Alamat Email...">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-user"
                                id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Ingat
                                    Saya</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>
                        <!-- <hr>
                        <a href="index.html" class="btn btn-google btn-user btn-block">
                            <i class="fab fa-google fa-fw"></i> Login dengan Google
                        </a>
                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                            <i class="fab fa-facebook-f fa-fw"></i> Login dengan Facebook
                        </a> -->
                    </form>
                    <!-- <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('backend.lupaPassword')}}">Lupa Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="{{ route('backend.registrasi') }}">Buat Akun Baru!</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection