@extends('layouts.app')

@section('content')
<!-- Login Section Start -->
<div id="loginSection" class="loginbackground">
    <div class="boxes">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!----------------------- Login Container ---------------------------> 
        <div class="row border rounded-5 p-3 bg-white shadow box-area w-100" style="max-width: 900px;">
            
            <!--------------------------- Left Box -----------------------------> 
            
            <div class="animated slideInLeft col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background:rgb(18, 96, 148);">
            <div class="featured-image mb-3">
                    <img src="{{ asset('img/logo.png') }}" class="img-fluid" style="height: 110px;" alt="Login Illustration">
                </div>
                <div class="featured-image mb-3">
                    <img src="{{ asset('img/login.webp') }}" class="img-fluid" style="width: 290px;" alt="Login Illustration">
                </div>
                <p class="text-white fs-2" style="font-family: 'Poppins', sans-serif; font-weight: 700; letter-spacing: 0.5px;">
                    Find The Talents With Ease
                </p>
                <small class="text-white text-wrap text-center mb-4" style="width: 17rem; font-family: 'Poppins', sans-serif; line-height: 1.5;">
                    Start your journey
                </small>
            </div>
            
            <!--------------------------- Right Box -----------------------------> 
            <div class="animated slideInRight col-md-6 right-box d-flex justify-content-center align-items-center">
                <div class="w-100 px-3">
                    <div class="header-text mb-4 text-center">
                        <h2>Welcome Back!</h2>
                        <p>We're excited to see you again. Let’s pick up where we left off!</p>
                    </div>
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control form-control-lg rounded-3 bg-light fs-6 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email address" aria-label="Email address" required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-1 position-relative">
                        <div class="input-group mb-1 position-relative">
                            <input type="password" id="password" class="form-control form-control-lg bg-light rounded-3 fs-6 @error('password') is-invalid @enderror" name="password" placeholder="Password" aria-label="Password" required>
                            <i id="togglePassword" class="bi bi-eye" aria-label="Toggle password visibility" role="button" tabindex="0" aria-hidden="true"></i>
                        </div>

                            @error('password')
                            <div class="invalid-feedback" role="alert">
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck" name="remember">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                            </div>
                            
                        </div>
                        <div class="input-group mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-lg btn-primary w-50 fs-6">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Section End -->

<!-- Footer Start -->
<div class="container wow fadeIn" data-wow-delay="0.1s">
    <div class="copyright">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-3 mb-md-0 text">
                &copy; <a class="border-bottom" href="#">CMSID-ACMS</a>, All Rights Reserved 2025.
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

@endsection
