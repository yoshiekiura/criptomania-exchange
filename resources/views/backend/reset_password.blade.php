@extends('backend.login._header')
@section('title', company_name())
@section('login')
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>

                    @if(admin_settings('company_logo'))

                    <a href="{{url('/') }}"><img src="{{ get_image(admin_settings('company_logo')) }}" alt="IMG" style="border-radius:50%;"></a>

                    @endif

                </div>
            <!-- form start here -->
            <form action="{{ $passwordResetLink }}" method="post" class="login100-form validate-form">
                {{ csrf_field() }}
                <span class="login100-form-title">
                        {{ __('Reset password ') }}
                    </span>

            <!-- new password -->
            <div class="wrap-input100 validate-input {{ $errors->has('new_password') ? 'has-error' : '' }}">
                    <div>
                        {{ Form::password('new_password', ['class'=>'input100', 'placeholder' => __('Enter new password'),'data-cval-name' => 'The new password field','data-cval-rules' => 'required|escapeInput|followedBy:new_password_confirmation|between:6,32']) }}
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                </span>
                    </div>
                    <span class="validation-message cval-error" data-cval-error="new_password">{{ $errors->first('new_password') }}</span>
                </div>
                <!-- end new password -->

                <!-- repeat password -->
                   <div class="wrap-input100 validate-input {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
                    <div>
                        
                        {{ Form::password('new_password_confirmation', ['class'=>'input100', 'placeholder' => __('Repeat new password'),'data-cval-name' => 'The confirm password field','data-cval-rules' => 'required|escapeInput|follow:new_password']) }}
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                </span>
                    </div>
                    <span class="validation-message cval-error" data-cval-error="new_password_confirmation">{{ $errors->first('new_password_confirmation') }}</span>
                </div>
                <!-- end repeat password -->

            @if( env('APP_ENV') != 'local' && admin_settings('display_google_captcha') == ACTIVE_STATUS_ACTIVE )
                <div class="form-group has-feedback {{ $errors->has('g-recaptcha-response') ? 'has-error' : '' }}">
                    <div>
                        {!! NoCaptcha::display() !!}
                    </div>
                    <span class="validation-message cval-error">{{ $errors->first('g-recaptcha-response') }}</span>
                </div>
            @endif

            <div class="container-login100-form-btn">
                        <!-- /.col -->
                            {{ Form::submit(__('Reset Password'), ['class'=>'login100-form-btn form-submission-button']) }}
                        <!-- /.col -->
            </div>

            <div class="clearfix link-after-form">
                    <a href="{{ route('login') }}" class="pull-left link-underline">{{ __('Login') }}</a>
                    <a href="{{route('register.index')}}" class="text-center pull-right link-underline">{{ __('Create an account') }}</a>
            </div>



           </form>
            <!-- end form -->
                
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