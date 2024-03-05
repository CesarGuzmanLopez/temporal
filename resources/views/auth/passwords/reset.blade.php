@extends('layouts.app')

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            @if (session('notification'))
                <div class="alert alert-success p-1">
                {{ session('notification') }}
                </div>
            @endif
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8  p-0">
                      <div class="w-100 d-lg-flex justify-content-center p-0">
                          <img class="img-fluid" src="{{ secure_asset('app-assets/images/pages/forgot-password-v2.png') }}" alt="Recupera V2" />
                          {{-- <img class="img-fluid" src="{{ secure_asset('app-assets/images/pages/login-v2.png') }}" alt="Login V2" /> --}}
                      </div>
                  </div>
                    <!-- /Left Text-->
                 <!-- Reset password-->
          <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-2">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
              <div class="shadow p-2 mb-1 bg-white rounded">
                  <div class="col-6 col-sm-6 col-md-4">
                    <svg id="Capa_1" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 99.1 90"><defs><style>.cls-1{fill:none;}.cls-2{clip-path:url(#clip-path);}.cls-3{fill:url(#Degradado_sin_nombre_2);}.cls-4{clip-path:url(#clip-path-2);}.cls-5{fill:url(#Degradado_sin_nombre_2-2);}</style><clipPath id="clip-path"><path id="SVGID" class="cls-1" d="M8,59.08,8,81.5c16-20.76,40.21-31.45,40.21-7.25,0,10.24,9.28-.52,16.52-6.44,10.32-8.45,23.61-7.55,26,8.37h.37V59c0-20.94-15-23-26.35-13.68C57.51,51.27,48.23,62,48.23,51.81c0-9.82-4-13.9-9.77-13.9C30,37.91,17.52,46.71,8,59.08"/></clipPath><linearGradient id="Degradado_sin_nombre_2" x1="670.11" y1="-4217.15" x2="672.78" y2="-4217.15" gradientTransform="matrix(31.14, 0, 0, -31.14, -20858.48, -131256.9)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#c01525"/><stop offset="0.09" stop-color="#c81727"/><stop offset="0.2" stop-color="#da1b2c"/><stop offset="0.38" stop-color="#e2554e"/><stop offset="0.49" stop-color="#e67561"/><stop offset="0.49" stop-color="#e36c5c"/><stop offset="0.51" stop-color="#d8514b"/><stop offset="0.52" stop-color="#cf3b3d"/><stop offset="0.54" stop-color="#c82a32"/><stop offset="0.56" stop-color="#c41e2b"/><stop offset="0.59" stop-color="#c11726"/><stop offset="0.66" stop-color="#c01525"/><stop offset="0.72" stop-color="#ca2e35"/><stop offset="0.84" stop-color="#e46f5d"/><stop offset="0.85" stop-color="#e67561"/><stop offset="0.92" stop-color="#d54a46"/><stop offset="1" stop-color="#c01525"/></linearGradient><clipPath id="clip-path-2"><path id="SVGID-2" data-name="SVGID" class="cls-1" d="M8,29.64v21.3c16.35-19.53,40.21-30.3,40.21-6.08,0,10.22,9.28-.55,16.52-6.45,10.32-8.47,23.61-7.55,26,8.33h.37V29.61c0-20.94-15-23-26.35-13.67-7.24,5.92-16.52,16.68-16.52,6.46,0-9.82-4-13.9-9.77-13.9C30,8.5,17.54,17.29,8,29.64"/></clipPath><linearGradient id="Degradado_sin_nombre_2-2" x1="670.1" y1="-4216.59" x2="672.77" y2="-4216.59" gradientTransform="matrix(31.13, 0, 0, -31.13, -20854.3, -131244.07)" xlink:href="#Degradado_sin_nombre_2"/></defs><g class="cls-2"><rect class="cls-3" x="8" y="36.05" width="83.1" height="48.44"/></g><g class="cls-4"><rect class="cls-5" x="8.02" y="6.62" width="83.08" height="48.46"/></g></svg>
                  </div>
                  <h2 class="card-title fw-bold mb-1">{{ __('Reset Password') }}<img src="{{ secure_asset('app-assets/images/icons/ico_candado.png')}}" alt="candado" class="img_icon"></h2>
                  <p class="card-text mb-2">{{ __('Remember! Your new password must be different those you previously registered.') }}</p>
                  <form class="auth-reset-password-form mt-2" action="{{ route('save.password') }}" method="POST">
                    @csrf
                      <input type="hidden" name="code" value={{$code}}>
                    <div class="mb-1">
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                      <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">{{ __('New Password') }}</label>
                      </div>
                      <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                        <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="password" type="password" name="password" aria-describedby="password" autofocus="" tabindex="1"/><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                      </div> 
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="mb-1">
                      <div class="d-flex justify-content-between">
                      </div>
                      <div class="input-group input-group-merge form-password-toggle @error('password_confirmation') is-invalid @enderror">
                        <input class="form-control form-control-merge @error('password_confirmation') is-invalid @enderror" id="password-confirmation" type="password" name="password_confirmation" aria-describedby="password-confirm" tabindex="2"/><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        @error('password_confirmation')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    @if (session('success'))
                      <div class="alert alert-success p-1" role="alert">
                          {{ session('success') }}
                      </div>
                      @endif
                      @if (session('fail'))
                          <div class="alert alert-danger p-1" role="alert">
                              {{ session(__('fail')) }}
                      </div>
                    @endif
                    <div align="right">
                      <button class="btn btn-primary w-50" tabindex="3" type="submit">{{ __('Reset Password') }}</button>
                    </div>
                    
                  </form>
              </div>
              <p class="mt-2"><a href="{{ route('login')}}"><i data-feather="chevron-left"></i> {{ __('Back to login') }}</a></p>
            </div>
          </div>
          <!-- /Reset password-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection