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
        <div class="row border rounded-5 p-3 bg-white shadow box-area w-100" style="max-width: 900px;">
            
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
            
            <div class="animated slideInRight col-md-6 right-box d-flex justify-content-center align-items-center">
                <div class="w-100 px-3">
                    <div class="header-text mb-4 text-center">
                        <h2>Welcome Candidate!</h2>
                        <p>We're excited to see you!</p>
                    </div>
                    <form id="loginForm" wire:submit.prevent="login">
                        <div class="input-group mb-3">
                            <input type="text" wire:model="fullname" class="form-control form-control-lg rounded-3 bg-light fs-6 @error('code') is-invalid @enderror" placeholder="Enter Code" aria-label="Unique Code" required>
                            @error('fullname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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