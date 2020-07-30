<input type="hidden" name="base_key" value="{{ base_key() }}">

{{--Bank Name--}}
<div class="form-group {{ $errors->has('bank_name') ? 'has-error' : '' }}">
    <label for="{{ fake_field('bank_name') }}" class="col-md-4 control-label required">{{ __('Bank Name') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('bank_name'),  old('bank_name', null), ['class'=>'form-control', 'id' => fake_field('bank_name'),'data-cval-name' => 'The Bank name field','data-cval-rules' => 'required|escapeInput|max:255', 'placeholder' => __('ex: BCA')]) }}
        <span class="validation-message cval-error" data-cval-error="{{ fake_field('bank_name') }}">{{ $errors->first('bank_name') }}</span>
    </div>
</div>

{{--Account Number--}}
<div class="form-group {{ $errors->has('account_number') ? 'has-error' : '' }}">
    <label for="{{ fake_field('account_number') }}" class="col-md-4 control-label required">{{ __('Account Number') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('account_number'),  old('account_number', null), ['class'=>'form-control', 'id' => fake_field('account_number'),'data-cval-name' => 'The Account Number field','data-cval-rules' => 'required|numeric|escapeInput|between:0.00000001, 99999999999.99999999', 'placeholder' => __('ex: Your Account Number')]) }}
        <span class="validation-message cval-error" data-cval-error="{{ fake_field('account_number') }}">{{ $errors->first('account_number') }}</span>
    </div>
</div>

{{--submit button--}}
<div class="form-group">
    <div class="col-md-offset-4 col-md-8">
        {{ Form::submit(__('Create'),['class'=>'btn btn-success form-submission-button']) }}
        {{ Form::reset(__('Reset'),['class'=>'btn btn-danger']) }}
    </div>
</div>