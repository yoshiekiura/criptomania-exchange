@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
@php
    $data = DB::table('api_stock_item')->get();
@endphp
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('Create Stock Item') }}</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('admin.stock-items.index') }}" class="btn btn-primary back-button">{{ __('Back to list') }}</a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-8">
                    {!! Form::open(['route'=>'admin.stock-items.store', 'method' => 'post', 'class'=>'form-horizontal validator', 'enctype'=>'multipart/form-data']) !!}
                        @include('backend.stockItems._create_form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('before-style')
    <link rel="stylesheet" href="{{ asset('common/vendors/bootstrap-fileinput/css/jasny-bootstrap.css') }}">
@endsection

@section('after-style')
    <style>
        .thumbnail {
            width: 100px; height: 100px; line-height:100px;
        }

        .thumbnail i{
            font-size: 50px;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('common/vendors/cvalidator/cvalidator.js') }}"></script>
    <script src="{{ asset('common/vendors/bootstrap-fileinput/js/jasny-bootstrap.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.validator').cValidate({});
        });

        const url = "{{route('api.stockItem')}}";

        // new Vue({
        //     el: '#app',
        //     data: {
        //         showOptionalFields : true,
        //         hideIcoOptionFields: 0,
        //         itemTypes: @json(config('commonconfig.currency_transferable')),
              
        //         cryptoApis: @json(crypto_currency_api_services()),
        //         realApis: @json(real_currency_api_services()),
                
        //         apis: @json(api_services())
        //     },
          
        //     methods: {
        //         changeItemType: function (event) {
        //             let itemTypeValue = parseInt(event.target.value);

        //             if(itemTypeValue == {{ CURRENCY_CRYPTO }})
        //             {

        //                 axios.get(url).then(response =>{
        //                     var result = response.data;

        //                     console.log(response.data.length);

        //                                   var html = ' <select class="form-control" id="api-services" data-cval-name="{{ __('The API service        field') }}" data-cval-rules="require" name="{{ fake_field('api_service') }}">'+
        //                                 '<option value="">{{ __('Select API Service') }}</option>'+
        //                                 '<option value='+response.data[3]+'>'+response.data[3]+'</option>'+
        //                                 '</select>';
                            

                    

        //                     $('.api-one').remove();
        //                      $('#api-name').append(html);

        //                     // this.apis = html;
        //                 });

                      


        //                 // this.apis = this.cryptoApis;
        //             }
        //             else if(itemTypeValue == {{ CURRENCY_REAL }})
        //             {
        //                 // $('#api-name-services2').remove();
        //                 this.apis = this.realApis;
        //             }
        //             else
        //             {
        //                 $('#api-name').empty();
        //             }

        //             this.showOptionalFields = this.itemTypes.indexOf(itemTypeValue) > -1 ? true : false;
        //         },
             
        //     }
        // });
    </script>
@endsection