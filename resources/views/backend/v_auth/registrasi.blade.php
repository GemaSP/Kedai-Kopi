@extends('backend.v_auth_layouts.app')
@section('content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                        @if (session()->has('Sukses'))
                        <div class="alert-danger">
                            <p>{{ session('Sukses') }}</p>
                        </div>
                        @endif
                    </div>
                    <form class="user" action="{{ route('backend.storeRegistrasi') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="nama" class="form-control form-control-user" id="nama"
                                placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-user" id="email"
                                placeholder="Email Address">
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" name="password" class="form-control form-control-user"
                                    id="password" placeholder="Password">
                            </div>
                            <div class="col-sm-6">
                                <input type="password" name="ulangiPassword" class="form-control form-control-user"
                                    id="ulangiPassword" placeholder="Ulangi Password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Daftarkan Akun
                        </button>
                        <hr>
                        <a href="index.html" class="btn btn-google btn-user btn-block">
                            <i class="fab fa-google fa-fw"></i> Daftar dengan Google
                        </a>
                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                            <i class="fab fa-facebook-f fa-fw"></i> Daftar dengan Facebook
                        </a>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('backend.lupaPassword') }}">Lupa Password?</a>
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