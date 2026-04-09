@extends('layouts.app')
@section('content')
<div class="main-wrapper">
    <div class="account-content">
        <a href="{{ route('form/job/list') }}" class="btn btn-primary apply-btn">Apply Job</a>

        <div class="container">
            <!-- Account Logo -->
            <div class="account-logo">
                <a href="index.html">
                    <img src="{{ URL::to('assets/img/logo2.png') }}" alt="Soeng Souy">
                </a>
            </div>
            <!-- /Account Logo -->

            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Login</h3>
                    <p class="account-subtitle">Access to our dashboard</p>

                    <!-- Account Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="Enter Email">

                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Password</label>
                                </div>
                            </div>

                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="Enter Password">

                            @error('password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Forgot -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col"></div>
                                <div class="col-auto">
                                    <a class="text-muted" href="{{ route('forget-password') }}">
                                        Forgot password?
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" type="submit">
                                Login
                            </button>
                        </div>

                        <!-- Social Login -->
                        <div class="text-center mt-3">
                            <!-- Social Login -->

<div class="text-center mt-3">

<p style="margin-bottom:12px; color:#777;">Or login with</p>

<div style="display:flex; justify-content:center; gap:8px; flex-wrap:wrap;">

    <!-- Github -->
    <a href="{{ route('github.login') }}" 
       style="display:flex; align-items:center; gap:6px; padding:6px 12px; 
              background:#24292e; color:#fff; border-radius:6px; 
              font-size:13px; text-decoration:none; transition:0.3s;">
        <i class="fa fa-github" style="font-size:14px;"></i>
        GitHub
    </a>

    <!-- Google -->
    <a href="{{ route('google.login') }}" 
       style="display:flex; align-items:center; gap:6px; padding:6px 12px; 
              background:#fff; color:#444; border:1px solid #ddd; 
              border-radius:6px; font-size:13px; text-decoration:none; transition:0.3s;">
        <i class="fa fa-google" style="font-size:14px; color:#db4437;"></i>
        Google
    </a>

    <!-- Facebook -->
    <a href="#" 
       style="display:flex; align-items:center; gap:6px; padding:6px 12px; 
              background:#1877f2; color:#fff; border-radius:6px; 
              font-size:13px; text-decoration:none; transition:0.3s;">
        <i class="fa fa-facebook" style="font-size:14px;"></i>
        Facebook
    </a>

</div>

</div>


                            
                        </div>

                        <!-- Register -->
                        <div class="account-footer mt-3">
                            <p>
                                Don't have an account yet?
                                <a href="{{ route('register') }}">Register</a>
                            </p>
                        </div>

                    </form>
                    <!-- /Account Form -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection