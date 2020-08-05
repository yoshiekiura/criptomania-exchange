@extends('backend.login._header')
@section('title', company_name())
@section('login')
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>

                    @if(admin_settings('company_logo'))

                    <a href="{{url('/') }}"><img src="{{ get_image(admin_settings('company_logo')) }}" alt="IMG" style="border-radius:50%;"></a>

                    @endif

                </div>
                {{ Form::open(['route'=>'register.store', 'medthod' => 'post','class' => 'login100-form validate-form']) }}
                <input type="hidden" value="{{base_key()}}" name="base_key">
                  @if(request()->has('ref') && admin_settings('referral'))
                    <input type="hidden" name="referral_code" value="{{ request()->get('ref') }}">
                  @endif
                    <span class="login100-form-title">
                        Register
                    </span>

                    <!-- first_name -->
                    <div class="wrap-input100 validate-input {{ $errors->has('first_name') ? 'has-error' : '' }}">
                       <div>
                                 {{ Form::text(fake_field('first_name'), old('first_name', null), ['class'=>'input100', 'placeholder' => __('Enter first name'),'data-cval-name' => 'The first name field','data-cval-rules' => 'required|escapeInput|alphaSpace']) }}
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                        </div>
                        <span class="validation-message cval-error" data-cval-error="{{ fake_field('first_name') }}">{{ $errors->first('first_name') }}</span>
                    </div>
                    <!-- end firstname -->

                    <!-- last name -->
                    <div class="wrap-input100 validate-input {{ $errors->has('last_name') ? 'has-error' : '' }}">
                         <div>
                            {{ Form::text(fake_field('last_name'), old('last_name', null), ['class'=>'input100', 'placeholder' => __('Enter last name'),'data-cval-name' => 'The last name field','data-cval-rules' => 'required|escapeInput|alphaSpace']) }}
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <span class="validation-message cval-error" data-cval-error="{{ fake_field('last_name') }}">{{ $errors->first('last_name') }}</span>
                        
                    </div>
                    <!-- end last name -->

                    <!-- email -->
                    <div class="wrap-input100 validate-input {{ $errors->has('email') ? 'has-error' : '' }}">
                         <div>
                            {{ Form::email(fake_field('email'), old('email', null), ['class'=>'input100', 'placeholder' => __('Enter Email'),'data-cval-name' => 'The email field','data-cval-rules' => 'required|escapeInput|email']) }}
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>
                        <span class="validation-message cval-error" data-cval-error="{{ fake_field('email') }}">{{ $errors->first('email') }}</span>
                        
                    </div>
                    <!-- end email -->

                    <!-- username -->
                    <div class="wrap-input100 validate-input {{ $errors->has('username') ? 'has-error' : '' }}">
                        <div>
                            {{ Form::text(fake_field('username'), old('username', null), ['class'=>'input100', 'placeholder' => __('Enter username'),'data-cval-name' => 'The username field','data-cval-rules' => 'required|escapeInput']) }}
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <span class="validation-message cval-error"
                              data-cval-error="{{ fake_field('username') }}">{{ $errors->first('username') }}</span>
                    </div>
                    <!-- end username -->

                    <!-- password -->
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
                    <!-- end password -->

                    <!-- confirm password -->
                    <div class="wrap-input100 validate-input {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                         <div>
                            {{ Form::password(fake_field('password_confirmation'), ['class'=>'input100', 'placeholder' => __('Repeat password'),'data-cval-name' => 'The confirm password field','data-cval-rules' => 'required|escapeInput|between:6,32|follow:'.fake_field('password')]) }}
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>
                        <span class="validation-message cval-error" data-cval-error="{{ fake_field('password_confirmation') }}">{{ $errors->first('password_confirmation') }}</span>
                        
                    </div>
                    <!-- end confirm password -->

                    @if( env('APP_ENV') != 'local' && admin_settings('display_google_captcha') == ACTIVE_STATUS_ACTIVE )
                        <div class="wrap-input100 validate-input { $errors->has('g-recaptcha-response') ? 'has-error' : '' }}">
                            <div>
                                {!! NoCaptcha::display() !!}
                            </div>
                            <span class="validation-message cval-error">{{ $errors->first('g-recaptcha-response') }}</span>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input {{ $errors->has('check_agreement') ? 'has-error' : '' }}">
                        <div>
                            <label>
                                <input type="checkbox" name="check_agreement" value="1" data-cval-name='The agreement field'
                                       data-cval-rules='required'{{old('check_agreement') ? ' checked' : ''}}> {{  __('Accept our terms and conditions.') }}
                            </label>
                        </div>
                        <span class="validation-message cval-error"
                              data-cval-error="{{ 'check_agreement' }}">{{ $errors->first('check_agreement') }}</span>
                    </div>
            
                    <div class="container-login100-form-btn">
                            {{ Form::submit(__('Register'), ['class'=>'login100-form-btn form-submission-button']) }}
                    </div>

                     <div class="clearfix link-after-form">
                        <a href="{{ route('forget-password.index') }}"
                           class="pull-left link-underline">{{ __('Forget Password') }}</a>
                        <a href="{{ route('login') }}"
                           class="text-center pull-right link-underline">{{ __('Login to your account') }}</a>
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