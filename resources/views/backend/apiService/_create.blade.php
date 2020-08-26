<input type="hidden" name="base_key" value="{{ base_key() }}">

{{--Api Value--}}
<div class="form-group {{ $errors->has('api_value') ? 'has-error' : '' }}">
    <label for="{{ fake_field('api_value') }}" class="col-md-4 control-label required">{{ __('Api Core') }}</label>
    <div class="col-md-8">                       
        <select class="form-control" id="{{fake_field('api_value')}}" data-cval-name="The Api Core field" data-cval-rules="required|numeric|escapeInput" name="{{fake_field('api_value')}}" placeholder="{{__('Select Api Core')}}">
               <!--  <option value="1">Payment Gateway</option> -->
                <option value="" selected="selected">Select Api Core</option>
                <option value="3">RPC Api (For Cryptocurrency Coin)</option>
                <option value="4">Transfer Bank Manual Payment (For Real Currency)</option>
        </select>
        <span class="validation-message cval-error" data-cval-error="{{ fake_field('api_value') }}">{{ $errors->first('api_value') }}</span>

                                   
    </div>
</div>

{{--Api Name--}}
<div class="form-group {{ $errors->has('api_name') ? 'has-error' : '' }}">
    <label for="{{ fake_field('api_name') }}" class="col-md-4 control-label required">{{ __('Api Name') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('api_name'),  old('api_name', null), ['class'=>'form-control', 'id' => fake_field('api_name'),'data-cval-name' => 'The Api Name field','data-cval-rules' => 'required|max:255|escapeInput', 'placeholder' => __('ex: BTC Api')]) }}
        <span class="validation-message cval-error" data-cval-error="{{ fake_field('api_name') }}">{{ $errors->first('api_name') }}</span>
    </div>
</div>

{{--submit button--}}
<div class="form-group">
    <div class="col-md-offset-4 col-md-8">
        {{ Form::submit(__('Create'),['class'=>'btn btn-success form-submission-button']) }}
        {{ Form::reset(__('Reset'),['class'=>'btn btn-danger']) }}
    </div>
</div>