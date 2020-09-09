@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Create Stock Pair') }}</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('admin.stock-pairs.index') }}"
                            class="btn btn-primary back-button">{{ __('Back to list') }}</a>
                    </div>
                </div>
                <div class="box-body">
                    <button class="btn btn-primary add-btn">Add More Form</button>

                    <div class="row">
                        <div class="col-sm-8">
                            <!-- {{-- <h4>Create Multiple Coin Pair</h4> --}} -->
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            {!! Form::open(['route'=>'admin.stock-pairs.multiStore', 'method'=>'post',
                            'class'=>'form-horizontal
                            validator', 'id'=>'form2']) !!}

                            <input type="hidden" name="base_key" value="{{ base_key() }}">

                            <div id="dynamic-field" class="form-horizontal validator">

                                <!-- {{--stock_item_id--}} -->

                                <div class="form-group {{ $errors->has('stock_item_name[]') ? 'has-error' : '' }}">
                                    <label for="{{ fake_field('stock_item_id') }}"
                                        class="col-md-4 control-label required">{{ __('Exchangeable Item') }}</label>
                                    <div class="col-md-8">
                                        {{ Form::select('stock_item_name[]', $stockItems, old('stock_item_id', null), ['class' => 'form-control input-stock', 'id' => fake_field('stock_item_id'), 'placeholder' => __('Select Exchangeable Item'), 'data-cval-name' => 'The exchangable item field','data-cval-rules' => 'required|in:' . array_to_string($stockItems)]) }}
                                        <span class="validation-message cval-error"
                                            data-cval-error="stock_item_name[]">{{ $errors->first('stock_item_name[]') }}</span>
                                    </div>
                                </div>


                                <!-- {{--base_item_id--}} -->
                                <div class="form-group {{ $errors->has('base_item_name[]') ? 'has-error' : '' }}">
                                    <label for="{{ fake_field('base_item_id') }}"
                                        class="col-md-4 control-label required">{{ __('Base Item') }}</label>
                                    <div class="col-md-8">
                                        {{ Form::select('base_item_name[]', $stockItems, old('base_item_id', null),['class' => 'form-control input-base','id' => fake_field('base_item_id'), 'placeholder' => __('Select Base Item'), 'data-cval-name' => 'The base item field','data-cval-rules' => 'required|in:'.array_to_string($stockItems)]) }}
                                        <span class="validation-message cval-error"
                                            data-cval-error="base_item_name[]">{{ $errors->first('base_item_name[]') }}</span>
                                    </div>
                                </div>

                                <!-- {{--last_price--}} -->

                                <div class="form-group {{ $errors->has('price_item_name[]') ? 'has-error' : '' }}">
                                    <label for="{{ fake_field('last_price') }}"
                                        class="col-md-4 control-label required">{{ __('Last Price') }}</label>
                                    <div class="col-md-8">

                                        {{ Form::text('price_item_name[]',  old('last_price', null), ['class'=>'form-control input-price', 'id' =>'price_item_name[]','data-cval-name' => 'The last price field','data-cval-rules' => 'required|numeric|escapeInput|between:0.00000001, 99999999999.99999999', 'placeholder' => __('ex: 0.00150000')]) }}

                                        <span class="validation-message cval-error"
                                            data-cval-error="price_item_name[]">{{ $errors->first('price_item_name[]') }}</span>

                                    </div>
                                </div>

                                <!-- {{--is_active--}} -->
                                <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                    <label for="{{ fake_field('is_active') }}"
                                        class="col-md-4 control-label required">{{ __('Active Status') }}</label>
                                    <div class="col-md-8">
                                        <div class="cm-switch">
                                            <input class="cm-switch-input input-active" id="0-active"
                                                name="is_active[0]" value="1" checked="checked" type="radio"></input>
                                            <label for="0-active" class="cm-switch-label">{{ __('Active') }}</label>

                                            <input class="cm-switch-input input-active" id="0-inactive"
                                                name="is_active[0]" value="0" type="radio"></input>
                                            <label for="0-inactive" class="cm-switch-label">{{ __('Inactive') }}</label>

                                        </div>
                                        <span class="validation-message cval-error"
                                            data-cval-error="{{ fake_field('is_active') }}">{{ $errors->first('is_active') }}</span>
                                    </div>
                                </div>

                                <!-- {{--is_default--}} -->
                                <div class="form-group {{ $errors->has('is_default') ? 'has-error' : '' }}">

                                    <label for="{{ fake_field('is_default') }}"
                                        class="col-md-4 control-label required">{{ __('Is Default') }}</label>
                                    @if(DB::table('stock_pairs')->where('is_default', '1')->exists())
                                    <span>You Have Default Pairs</span>
                                    @else

                                    <div class="col-md-8">
                                        <div class="cm-switch">

                                            <input class="cm-switch-input input-default" id="0-default"
                                                name="is_default[0]" type="radio" value="1"
                                                {{ACTIVE_STATUS_ACTIVE, null}}
                                                data-cval-rules="required|integer|in:1,0"></input>'+

                                            <label for="0-default" class="cm-switch-label">{{ __('Yes') }}</label>

                                            <input class="cm-switch-input input-default" id="0-indefault"
                                                name="is_default[0]" type="radio" value="0" checked="checked"></input>'+

                                            <label for="0-indefault" class="cm-switch-label">{{ __('No') }}</label>'+


                                        </div>
                                        <span class="validation-message cval-error"
                                            data-cval-error="is_default[]">{{ $errors->first('is_default') }}</span>
                                    </div>
                                </div>
                                @endif




                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-8">
                                {{ Form::submit(__('Create'),['class'=>'btn btn-success form-submission-button']) }}
                            </div>
                        </div>
                        {!! Form::close() !!}


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
            $('.validator').cValidate({});
        });
</script>

<script>
    $(document).ready(function (){

        var index = 0;
        $('.add-btn').click(function(){
        
            index += 1;

            // form stock item id
            const stock_item = '<hr><div class="form-group {{ $errors->has('stock_item_name[]') ? 'has-error' : '' }}"><label for="{{ fake_field('stock_item_id') }}'+index+'"class="col-md-4 control-label required">{{ __('Exchangeable Item') }}</label><div class="col-md-8">{{ Form::select('stock_item_name[]', $stockItems, old('stock_item_id', null), ['class' => 'form-control input-stock', 'id' => fake_field('stock_item_id'), 'placeholder' => __('Select Exchangeable Item'), 'data-cval-name' => 'The exchangable item field','data-cval-rules' => 'required|in:' . array_to_string($stockItems)]) }}<span class="validation-message cval-error"data-cval-error="stock_item_name[]">{{ $errors->first('stock_item_name[]') }}</span></div></div>';
            
            //form base item id
            const base_item = '<div class="form-group {{ $errors->has('base_item_name[]') ? 'has-error' : '' }}"><label for="{{ fake_field('base_item_id') }}" class="col-md-4 control-label required">{{ __('Base Item') }}</label><div class="col-md-8">{{ Form::select(fake_field('base_item_id').'[]', $stockItems, old('base_item_id', null),['class' => 'form-control input-base','id' => fake_field('base_item_id'), 'placeholder' => __('Select Base Item'), 'data-cval-name' => 'The base item field','data-cval-rules' => 'required|in:'.array_to_string($stockItems)]) }}<span class="validation-message cval-error" data-cval-error="{{ fake_field('base_item_id[]') }}">{{ $errors->first('base_item_id[]') }}</span></div></div>';

            //form last price
            const last_price = '<div class="form-group {{ $errors->has('price_item_name[]') ? 'has-error' : '' }}">'+
                                '<label for="{{ fake_field('last_price') }}" class="col-md-4 control-label required">{{ __('Last Price') }}</label>'+
                                '<div class="col-md-8">'+

                                '{{ Form::text('price_item_name[]' ,  old('last_price', null), ['class'=>'form-control input-price', 'id' =>'price_item_name[]','data-cval-name' => 'The last price field','data-cval-rules' => 'required|numeric|escapeInput|between:0.00000001, 99999999999.99999999', 'placeholder' => __('ex: 0.00150000')]) }}'+

                                '<span class="validation-message cval-error" data-cval-error="price_item_name[]">{{ $errors->first('price_item_name[]') }}</span>'+
                                '</div></div>';

            // form is active
            const active = '<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}"><label for="{{ fake_field('is_active') }}" class="col-md-4 control-label required">{{ __('Active Status') }}</label><div class="col-md-8"><div class="cm-switch"><input class="cm-switch-input input-active" id="'+index+'-active" name="is_active['+index+']" value="1" checked="checked" type="radio" {{ACTIVE_STATUS_ACTIVE, true}}></input><label for="'+index+'-active" class="cm-switch-label">{{ __('Active') }}</label><input class="cm-switch-input input-active" id="'+index+'-inactive" name="is_active['+index+']" value="0" type="radio" {{ACTIVE_STATUS_INACTIVE, false}} ></input><label for="'+index+'-inactive" class="cm-switch-label">{{ __('Inactive') }}</label></div><span class="validation-message cval-error" data-cval-error="{{ fake_field('is_active') }}">{{ $errors->first('is_active') }}</span></div></div>';

            // form default
            const dflt = '<div class="form-group {{ $errors->has('is_default') ? 'has-error' : '' }}">'+

                                '<label for="{{ fake_field('is_default') }}" class="col-md-4 control-label required">{{ __('Is Default') }}</label>'+
                                '@if(DB::table('stock_pairs')->where('is_default',  '1')->exists())'+
                                '<span>You Have Default Pairs</span>'+
                                '@else'+

                                '<div class="col-md-8"><div class="cm-switch">'+

                                '<input class="cm-switch-input input-default"  id="'+index+'-default" name="is_default['+index+']" type="radio" value="1" {{ACTIVE_STATUS_ACTIVE, null}} data-cval-rules="required|integer|in:{{array_to_string(active_status())}}"></input>'+

                                '<label for="'+index+'-default" class="cm-switch-label">{{ __('Yes') }}</label>'+

                                '<input class="cm-switch-input input-default" id="'+index+'-indefault" name="is_default['+index+']" type="radio" value="0" checked="checked" {{ACTIVE_STATUS_INACTIVE, true}}></input>'+

                                '<label for="'+index+'-indefault" class="cm-switch-label">{{ __('No') }}</label>'+


                                '</div>'+
                                '<span class="validation-message cval-error" data-cval-error="is_default['+index+']">{{ $errors->first('is_default[+index+]') }}</span>'+
                                '</div></div>'+
                                '@endif';
 
            const test = '<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}"><label for="{{ fake_field('is_active') }}" class="col-md-4 control-label required">{{ __('Active Status') }}</label><div class="col-md-8"><div class="cm-switch">{{ Form::radio(fake_field('is_active'), ACTIVE_STATUS_ACTIVE, true, ['id' => '+index+'.'-active' . '-active', 'class' => 'cm-switch-input is-active active', 'data-cval-name' => 'The active status field', 'data-cval-rules' => 'required|integer|in:' . array_to_string(active_status())]) }}<label for="{{ fake_field('is_active') }}-active" class="cm-switch-label label-active">{{ __('Active') }}</label>{{ Form::radio(fake_field('is_active'), ACTIVE_STATUS_INACTIVE, false, ['id' => '+index+ ' . '-inactive', 'class' => 'cm-switch-input is-active inactive']) }}<label for="{{ fake_field('is_active') }}-inactive" class="cm-switch-label label-inactive">{{ __('Inactive') }}</label></div><span class="validation-message cval-error" data-cval-error="{{ fake_field('is_active') }}">{{ $errors->first('is_active') }}</span></div></div>'

            $('#dynamic-field').append(stock_item+base_item+last_price+active+dflt);

            var stock = $('.input-stock').attr('name', 'stock_item_name[]');
            var base = $('.input-base').attr('name', 'base_item_name[]');
            var price = $('.input-price').attr('name', 'price_item_name[]');
            
             $('.is-active').attr('name', 'name-aktif['+index+']');
             $('.active').attr('id', 'is_active['+index+']');
             $('.label-active').attr('for', 'is_active['+index+']');
             $('.inactive').attr('id', 'inactive['+index+']');
             $('.label-inactive').attr('for', 'inactive['+index+']');


        });

    });
</script>
@endsection