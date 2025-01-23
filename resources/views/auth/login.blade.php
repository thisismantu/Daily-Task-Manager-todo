@extends('theme.layouts.app')
@section('content')
<div class="row g-0">

    <div class="col-lg-6">
        <div class="card-body p-4 p-sm-5">
            <h5 class="card-title">Sign In</h5>
            <p class="card-text mb-5">Manage IT Daily Task System!</p>
            <form class="form-body" method="post" action="{{ Route('login') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <div class="ms-auto position-relative">
                            <div
                                class="position-absolute top-50 translate-middle-y search-icon px-3">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <input type="email" class="form-control radius-30 ps-5"
                                id="login-username" name="email" value="{{old('email')}}" required
                                placeholder="Login Username *">
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div class="ms-auto position-relative">
                            <div
                                class="position-absolute top-50 translate-middle-y search-icon px-3">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                            <input type="password" class="form-control radius-30 ps-5" required
                                id="login-password" name="password" placeholder="Login Password *">
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="remember"
                                value="1" {{ old('remember') ? 'checked' : '' }}
                                id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary radius-30">Sign
                                In</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
