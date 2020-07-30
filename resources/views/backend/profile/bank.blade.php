@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            @include('backend.profile.avatar', ['profileRouteInfo' => profileRoutes('user', $user->id)])
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                @include('backend.profile.profile_nav')
                <div class="box box-solid">
                    <div class="box-body">
                        {{ Form::open(['route'=>['profile.store.bank'],'class'=>'form-inline validator','method'=>'post']) }}
                        <input type="hidden" value="{{base_key()}}" name="base_key">

                        <input type="hidden" value="{{Auth::user()->id}}" name="users_id"> 

                      
                        <div class="form-group mb-2 {{ $errors->has('bank_name') ? 'has-error' : '' }}">
                        <label for="{{ fake_field('bank_name') }}" class="sr-only control-label">{{ __('Bank Name') }}</label>
                               {{ Form::text(fake_field('bank_name'),  old('bank_name', null), ['class'=>'form-control', 'id' => fake_field('bank_name'),'data-cval-name' => 'The Bank name field','data-cval-rules' => 'required|escapeInput|max:255', 'placeholder' => __('ex: BCA')]) }}
                                <span class="validation-message cval-error" data-cval-error="{{ fake_field('bank_name') }}">{{ $errors->first('bank_name') }}</span>
                      </div>

                       
                      <div class="form-group mx-sm-3 mb-2">
                        <!-- <label for="inputPassword2" class="sr-only">Password</label> -->
                        <label for="{{ fake_field('account_number') }}"
                                   class="sr-only control-label required">{{ __('Account Number') }}</label>
                                    {{ Form::text(fake_field('account_number'),  old('account_number', null), ['class'=>'form-control', 'id' => fake_field('account_number'),'data-cval-name' => 'The Account Number field','data-cval-rules' => 'required|numeric|escapeInput|between:0.00000001, 99999999999.99999999', 'placeholder' => __('ex: Your Account Number')]) }}
                                    <span class="validation-message cval-error" data-cval-error="{{ fake_field('account_number') }}">{{ $errors->first('account_number') }}</span>

                      </div>
                      
                        {{--submit button--}}
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                {{ Form::submit(__('Store'),['class'=>'btn btn-info btn-sm btn-left btn-sm-block form-submission-button']) }}
                            </div>
                        </div>

                        
                        {{ Form::close() }}
                    </div>
                    <div class="box-footer clearfix">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('profile.index') }}"
                                   class="btn btn-sm btn-info btn-flat btn-sm-block">{{ __('View Profile') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('common/vendors/cvalidator/cvalidator.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.validator').cValidate();
        });
    </script>
@endsection