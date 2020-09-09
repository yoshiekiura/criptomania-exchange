@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-primary box-borderless">
                        <div class="box-header text-center with-border">
                            <h3 class="box-title">Your Invoice</h3>

                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('Ref ID')}}</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{ $depoBank->ref_id }}</th>
                                        <th scope="col">{{ $depoBank->id }}</th>

                                    </tr>
                                    <tr>
                                        <th scope="col">{{ __('Your Email') }}</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{$depoBank->email}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">{{ __('On Wallet') }}</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{$depoBank->wallet_id}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Amount</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{ $depoBank->amount }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Coin Name</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{ $depoBank->item_name }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Admin Bank</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{ $depoBank->bank_name }} {{$depoBank->account_number}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Create At</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{ $depoBank->created_at }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Struck Upload</th>
                                        <th scope="col">:</th>
                                        @if($depoBank->payment_prove == NULL)
                                        <th scope="col">
                                            @if(has_permission('trader.wallets.deposit.struckUpload'))

                                            {{ Form::open(['route'=>['trader.wallets.deposit.struckUpload', $depoBank->id], 'class'=>'validator', 'enctype'=>'multipart/form-data']) }}

                                            {{ Form::file(fake_field('payment_prove'), ['class' => '','id' => fake_field('payment_prove'),'data-cval-name' => 'The Payment Prove','data-cval-rules' => 'files:jpg,png,jpeg|max:2048']) }}

                                            <input type="submit" value="submit" class="btn btn-primary">

                                            {{ Form::close() }}</th>
                                        @endif
                                        @else

                                        <th scope="col"><a href="#" data-id="{{$depoBank->id}}"
                                                data-struck="{{ get_struck($depoBank->payment_prove) }}"
                                                data-toggle="modal" data-target="#modal-insert"
                                                class="show-struck">{{ $depoBank->payment_prove }}
                                            </a>
                                        </th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <a href="{{ route('reports.trader.deposits-bank', $depoBank->wallet_id) }}"
                                class="btn btn-danger" style="margin-left: 45%; margin-top:10px">Back</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-insert">
    <div class="modal-dialog" role="document">
        <div class="form-group">
            <img src="{{ get_struck($depoBank->payment_prove) }}" id="struck" class="img-responsive cm-center">

        </div>



        <script>
            $(document).ready(function(){
     // Upload
     $(document).on('click', '.show-struck', function() {
     // this part
     $('#struck').attr('src',$(this).data('struck'));
   });

});
        </script>



        @endsection