@extends('frontend.layouts.app')

@section('title', __('Login'))

@push('before-styles')
<style>
    body {
        background-color: #e4e4e4;
        background-image: linear-gradient(to bottom, #3c4b64, #303c54 300px, #e4e4e4 300px, #e4e4e4) !important;
        background-size: cover !important;
        background-repeat: no-repeat !important;
    }

    html,
    body {
        margin: 0;
        height: 100%;
    }

    .user_card {
        height: 400px;
        width: 400px;
        margin-top: auto;
        margin-bottom: auto;
        background: #fff;
        position: relative;
        display: flex;
        justify-content: center;
        flex-direction: column;
        padding: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 5px;
    }

    .login_name_wrapper {
        height: 20% !important;
        min-height: 200px;
        margin-bottom: auto;
        margin-top: auto;
        position: relative;
        display: flex;
        justify-content: center;
        flex-direction: column;
        color: #FFF;
        font-size: 35px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .login_logo_container {
        position: absolute;
        height: 170px;
        width: 170px;
        top: -75px;
        border-radius: 50%;
        background: #233588;
        padding: 10px;
        text-align: center;
    }

    .login_logo {
        height: 150px;
        width: 150px;
        border-radius: 50%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .form_container {
        margin-top: 100px;
    }

    .login_btn {
        width: 100%;
        background: #303c54 !important;
        color: white !important;
    }

    .login_btn:hover {
        background: #3c4b64 !important;
    }

    .login_container {
        padding: 0 2rem;
    }

    .input-group-text {
        background: #233588 !important;
        color: white !important;
        border: 0 !important;
        border-radius: 0.25rem 0 0 0.25rem !important;
    }

    .input_user,
    .input_pass:focus {
        box-shadow: none !important;
        outline: 0px !important;
    }

    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #233588 !important;
    }

    .input-group-text {
        height: 38px;
    }
</style>
@endpush

@section('content')
<div class="container h-100">
    <div class="login_name_wrapper">
        <div class="d-flex justify-content-center">Bollore Logistics</div>
    </div>
    <div class="d-flex justify-content-center h-50">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="login_logo_container"> <img src="https://crezzur.com/img/projects/27-home_default.png"
                        class="login_logo" alt="Logo"> </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form style="width: 320px" action="{{ route('frontend.auth.login') }}" method="POST">
                    @csrf();
                    <div id="msgcont" class="d-flex justify-content-center" style="display:none!important">
                        <div id="msg" class="alert alert-danger py-1 px-2" role="alert"></div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append"> <span class="input-group-text"><i
                                    class="fas fa-user"></i></span> </div>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required
                            autofocus autocomplete="email" />
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-append"> <span class="input-group-text"><i
                                    class="fas fa-key"></i></span> </div>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="{{ __('Password') }}" maxlength="100" required
                            autocomplete="current-password" />
                    </div>

                    @if(config('boilerplate.access.captcha.login'))
                    <div class="row">
                        <div class="col">
                            @captcha
                            <input type="hidden" name="captcha_status" value="true" />
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    @endif

                    <div class="text-center">
                        @include('frontend.auth.includes.social')
                    </div>

                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" class="btn login_btn">Login</button>
                    </div>
                </form>

                {{-- <x-forms.post :action="route('frontend.auth.login')">
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">@lang('E-mail
                            Address')</label>

                        <div class="col-md-6">
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255"
                                required autofocus autocomplete="email" />
                        </div>
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">@lang('Password')</label>

                        <div class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="{{ __('Password') }}" maxlength="100" required
                                autocomplete="current-password" />
                        </div>
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input name="remember" id="remember" class="form-check-input" type="checkbox" {{
                                    old('remember') ? 'checked' : '' }} />

                                <label class="form-check-label" for="remember">
                                    @lang('Remember Me')
                                </label>
                            </div>
                            <!--form-check-->
                        </div>
                    </div>
                    <!--form-group-->

                    @if(config('boilerplate.access.captcha.login'))
                    <div class="row">
                        <div class="col">
                            @captcha
                            <input type="hidden" name="captcha_status" value="true" />
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    @endif

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button class="btn btn-primary" type="submit">@lang('Login')</button>

                            <x-utils.link :href="route('frontend.auth.password.request')" class="btn btn-link"
                                :text="__('Forgot Your Password?')" />
                        </div>
                    </div>
                    <!--form-group-->

                    <div class="text-center">
                        @include('frontend.auth.includes.social')
                    </div>
                </x-forms.post> --}}
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-center links"><a href="#">Forgot your password?</a> </div>
            </div>
        </div>
    </div>
</div>
@endsection