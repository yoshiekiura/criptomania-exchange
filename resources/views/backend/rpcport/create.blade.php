@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
@php
    $schema = ["http","https"];
@endphp
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('Create Stock Pair') }}</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('admin.stock-pairs.index') }}"
                class="btn btn-primary back-button">{{ __('Back to list') }}</a>
        </div>
    </div>
    <div class="box-body">

        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
        
        <div class="row">
            <div class="col-sm-8">
                {!! Form::open(['route'=>'rpcport.store', 'method' => 'post', 'class'=>'form-horizontal
                validator']) !!}
                @include('backend.rpcport._create')
                {!! Form::close() !!}
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


@endsection