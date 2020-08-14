<input type="hidden" name="base_key" value="{{ base_key() }}">

{{--stock_item_id--}}
<div class="form-group {{ $errors->has('stock_item_id') ? 'has-error' : '' }}">
    <label for="{{ fake_field('stock_item_id') }}"
        class="col-md-4 control-label required">{{ __('Coin Name') }}</label>
    <div class="col-md-8">
        {{ Form::select(fake_field('stock_item_id'), $stockItems, old('stock_item_id', null), ['class' => 'form-control', 'id' => fake_field('stock_item_id'), 'placeholder' => __('Select Exchangeable Item'), 'data-cval-name' => 'The exchangable item field','data-cval-rules' => 'required']) }}

        <span class="validation-message cval-error"
            data-cval-error="{{ fake_field('stock_item_id') }}">{{ $errors->first('stock_item_id') }}</span>
    </div>
</div>

{{--scheme--}}
<div class="form-group {{ $errors->has('scheme') ? 'has-error' : '' }}">
    <label for="{{ fake_field('scheme') }}" class="col-md-4 control-label required">{{ __('Scheme') }}</label>
    <div class="col-md-8">
        

        <select class="form-control" id="scheme" data-cval-name="The scheme field" data-cval-rules="required|max:255" name="{{ fake_field('scheme') }}">
            <option selected="selected" value="">Select Scheme</option>
            <option value="http">http</option>
            <option value="https">https</option>
        </select>

        <span class="validation-message cval-error"
            data-cval-error="{{ fake_field('scheme') }}">{{ $errors->first('scheme') }}</span>
    </div>
</div>

{{--host--}}
<div class="form-group {{ $errors->has('host') ? 'has-error' : '' }}">
    <label for="{{ fake_field('host') }}" class="col-md-4 control-label required">{{ __('Host') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('host'),  old('host', null), ['class'=>'form-control', 'id' => fake_field('host'),'data-cval-name' => 'The host field','data-cval-rules' => 'required', 'placeholder' => __('ex: http://example.com or 127.0.0.1')]) }}
        <span class="validation-message cval-error"
            data-cval-error="{{ fake_field('host') }}">{{ $errors->first('host') }}</span>
    </div>
</div>

{{--port--}}
<div class="form-group {{ $errors->has('port') ? 'has-error' : '' }}">
    <label for="{{ fake_field('port') }}" class="col-md-4 control-label required">{{ __('Port') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('port'),  old('port', null), ['class'=>'form-control', 'id' => fake_field('port'),'data-cval-name' => 'The port field','data-cval-rules' => 'required|numeric', 'placeholder' => __('ex: 8332')]) }}
        <span class="validation-message cval-error"
            data-cval-error="{{ fake_field('port') }}">{{ $errors->first('port') }}</span>
    </div>
</div>

{{--rpc_user--}}
<div class="form-group {{ $errors->has('rpc_user') ? 'has-error' : '' }}">
    <label for="{{ fake_field('rpc_user') }}" class="col-md-4 control-label required">{{ __('RPC User') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('rpc_user'),  old('rpc_user', null), ['class'=>'form-control', 'id' => fake_field('rpc_user'),'data-cval-name' => 'The RPC User field','data-cval-rules' => 'required', 'placeholder' => __('ex: username')]) }}
        <span class="validation-message cval-error"
            data-cval-error="{{ fake_field('rpc_user') }}">{{ $errors->first('rpc_user') }}</span>
    </div>
</div>

{{--rpc_password--}}
<div class="form-group {{ $errors->has('rpc_password') ? 'has-error' : '' }}">
    <label for="{{ fake_field('rpc_password') }}" class="col-md-4 control-label required">{{ __('RPC Password') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('rpc_password'),  old('rpc_password', null), ['class'=>'form-control', 'id' => fake_field('rpc_password'),'data-cval-name' => 'The RPC Password field','data-cval-rules' => 'required', 'placeholder' => __('ex: password')]) }}
        <span class="validation-message cval-error"
            data-cval-error="{{ fake_field('rpc_password') }}">{{ $errors->first('rpc_password') }}</span>
    </div>
</div>

{{--network_fee--}}
<div class="form-group {{ $errors->has('network_fee') ? 'has-error' : '' }}">
    <label for="{{ fake_field('network_fee') }}" class="col-md-4 control-label required">{{ __('Network Fee') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('network_fee'),  old('network_fee', 0), ['class'=>'form-control', 'id' => fake_field('network_fee'),'data-cval-name' => 'The Network Fee field','data-cval-rules' => 'required|numeric|escapeInput|between:0, 99999999999.99999999', 'placeholder' => __('ex: 0.0001')]) }}
        <span class="validation-message cval-error"
            data-cval-error="{{ fake_field('network_fee') }}">{{ $errors->first('network_fee') }}</span>
    </div>
</div>

{{--cert_ca--}}
<div class="form-group {{ $errors->has('cert_ca') ? 'has-error' : '' }}">
    <label for="{{ fake_field('cert_ca') }}" class="col-md-4 control-label required">{{ __('Cert CA') }}</label>
    <div class="col-md-8">
        {{ Form::text(fake_field('cert_ca'),  old('cert_ca', null), ['class'=>'form-control', 'id' => fake_field('cert_ca'),'data-cval-name' => 'The Network Fee field','data-cval-rules' => 'nullable|escapeInput|max:255', 'placeholder' => __('OPTIONAL ex: /root/yourusername/directory/cert_ca.ssl')]) }}
        <span class="validation-message cval-error"
            data-cval-error="{{ fake_field('cert_ca') }}">{{ $errors->first('cert_ca') }}</span>
    </div>
</div>



{{--submit button--}}
<div class="form-group">
    <div class="col-md-offset-4 col-md-8">
        {{ Form::submit(__('Create'),['class'=>'btn btn-success form-submission-button']) }}
    </div>
</div>