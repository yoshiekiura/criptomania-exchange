@extends('backend.login._header')
@section('title', company_name())
@section('login')
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>

                    @if(admin_settings('company_logo'))

                    <a href="{{url('/') }}"><img src="{{ get_image(admin_settings('company_logo')) }}" alt="IMG" style="border-radius:50%;"></a>

                    @endif

                </div>
            {{ Form::open(['route'=>'forget-password.send-mail', 'medthod' => 'post','class'=>'login100-form validate-form']) }}
                <input type="hidden" value="{{base_key()}}" name="base_key">
                    <span class="login100-form-title">
                        {{ __('Reset password ') }}
                    </span>
                   
                    <div class="wrap-input100 validate-input {{ $errors->has('email') ? 'has-error' : '' }}">
                       <div>
                                {{ Form::email(fake_field('email'), null, ['class'=>'input100', 'placeholder' => __('Enter Email'),'data-cval-name' => 'The email field','data-cval-rules' => 'required|email']) }}
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </span>
                        </div>
                        <span class="validation-message cval-error" data-cval-error="{{ fake_field('email') }}">{{ $errors->first('email') }}</span>
                    </div>

                    @if( env('APP_ENV') != 'local' && admin_settings('display_google_captcha') == ACTIVE_STATUS_ACTIVE )
                        <div class="wrap-input100 validate-input { $errors->has('g-recaptcha-response') ? 'has-error' : '' }}">
                            <div>
                                {!! NoCaptcha::display() !!}
                            </div>
                            <span class="validation-message cval-error">{{ $errors->first('g-recaptcha-response') }}</span>
                        </div>
                    @endif
            
                    <div class="container-login100-form-btn">
                        <!-- /.col -->
                            {{ Form::submit(__('Get Password Reset Link'), ['class'=>'login100-form-btn form-submission-button']) }}
                        <!-- /.col -->
                    </div>

                    <div class="clearfix link-after-form">
                            <a href="{{ route('login') }}" class="pull-left link-underline">{{ __('Login') }}</a>
                        @if(admin_settings('require_email_verification'))
                            <a href="{{ route('verification.form') }}" class="text-center pull-right link-underline">{{ __('Get verification email') }}</a>
                        @endif
                    </div>
                {{ Form::close() }}
                
            </div>
@endsection

@section('script-login')
    <script src="{{ asset('common/vendors/cvalidator/cvalidator.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.validate-form').cValidate({});
        });
    </script>
@endsection