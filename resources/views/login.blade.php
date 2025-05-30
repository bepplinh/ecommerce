@extends('layout.clientApp')
@push('styles')
{{--
<link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/header.css') }}">
@endpush
@push('styles')
<style>
  button {
    background-color: #222222;
    color: white;
    height: 65px;
  }

  .social-login-btn {
    width: 48px;
    height: 48px;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center;
    justify-content: center;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.15s, box-shadow 0.15s;
    font-size: 22px;
  }

  .social-login-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    opacity: 0.92;
  }

  .social-login-btn.facebook {
    background: #3b5998;
  }

  .social-login-btn.google {
    background: #DB4437;
  }
</style>
@endpush
@section('content')
<main class="pt-90 d-flex justify-content-center">
  <div class="mb-4 pb-4"></div>
  <section class="login-register container" style="width: 33.33%; margin: auto;">
    <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
          role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
      </li>
    </ul>
    <div class="tab-content pt-2" id="login_register_tab_content">
      <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
        <div class="login-form">
          <form method="POST" action="{{ route('actionLogin') }}" name="login-form" class="needs-validation" novalidate>
            @csrf
            <div class="form-floating mb-3">
              <input class="form-control form-control_gray" id="username" name="username" type="text" required
                autocomplete="username" autofocus>
              <label for="email">Username *</label>
            </div>

            <div class="pb-3"></div>

            <div class="form-floating mb-3">
              <input id="password" type="password" class="form-control form-control_gray" name="password" required
                autocomplete="current-password">
              <label for="password">Password *</label>
            </div>

            <button class="w-100 text-uppercase" type="submit">Log In</button>

            <div class="d-flex align-items-center my-3">
              <hr class="flex-grow-1">
              <span class="mx-3 text-secondary">or with</span>
              <hr class="flex-grow-1">
            </div>

            <div class="text-center d-flex justify-content-center gap-3">
              <a href="#" class="social-login-btn facebook">
                <i class="fa-brands fa-facebook-f text-white"></i>
              </a>
              <a href="{{ route('login.google') }}" class="social-login-btn google">
                <i class="fa-brands fa-google text-white"></i>
              </a>
            </div>

            <div class="customer-option mt-4 text-center">
              <span class="text-secondary">No account yet?</span>
              <a href="{{ route('registerForm') }}" class="btn-text js-show-register">Create Account</a> | <a
                href="my-account.html" class="btn-text js-show-register">My Account</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection