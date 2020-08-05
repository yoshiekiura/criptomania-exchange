@extends('backend.login._header')
@section('title', company_name())
@section('login')
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>

                    @if(admin_settings('company_logo'))

                    <a href="{{url('/') }}"><img src="{{ get_image(admin_settings('company_logo')) }}" alt="IMG" style="border-radius:50%;"></a>

                    @endif

                </div>
                {{ Form::open(['route'=>'login', 'medthod' => 'post','class' => 'login100-form validate-form']) }}
                <input type="hidden" value="{{base_key()}}" name="base_key">
                    <span class="login100-form-title">
                        Login
                    </span>
                    <span class="login100-form-title"><a href="{{ route('register.index') }}" class="link-underline">{{ __('I need a new account') }}</a></span>

                    <div class="wrap-input100 validate-input {{ $errors->has('username') ? 'has-error' : '' }}">
                       <div>
                                {{ Form::text(fake_field('username'), null, ['class'=>'input100', 'placeholder' => __('Username'),'data-cval-name' => 'Username','data-cval-rules' => 'required']) }}
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                        </div>
                        <span class="validation-message cval-error" data-cval-error="{{ fake_field('username') }}">{{ $errors->first('username') }}</span>
                    </div>

                    <div class="wrap-input100 validate-input {{ $errors->has('password') ? 'has-error' : '' }}">
                         <div>
                            {{ Form::input('password',fake_field('password'), null,['class'=>'input100', 'placeholder' => __('Password'),'data-cval-name' => 'Password','data-cval-rules' => 'required']) }}
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>
                        <span class="validation-message cval-error" data-cval-error="{{ fake_field('password') }}">{{ $errors->first('password') }}</span>
                        
                    </div>

                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox(fake_field('remember_me'), 1, false) }}
                            {{ __('Remember Me') }}
                        </label>
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
                        
                            {{ Form::submit(__('Sign In'), ['class'=>'login100-form-btn form-submission-button']) }}
                        
                        <!-- /.col -->
                    </div>

                    <div class="clearfix link-after-form">
                        <a href="{{ route('forget-password.index') }}" class="pull-left link-underline">{{ __('Forget Password') }}</a>
                        @if(admin_settings('require_email_verification') == ACTIVE_STATUS_ACTIVE)
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