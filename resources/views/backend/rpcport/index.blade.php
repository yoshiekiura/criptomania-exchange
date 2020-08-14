@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
    {!! $list['filters'] !!}
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width: 100% !important;">
                        <thead>
                        <tr>
                            <th class="all text-center">{{ __('Coin Name') }}</th>
                            <th class="text-center">{{ __('Scheme') }}</th>
                            <th class="text-center">{{ __('Host') }}</th>
                            <th class="text-center">{{ __('Port') }}</th>
                            <th class="text-center">{{ __('RPC User') }}</th>
                            <th class="text-center">{{ __('RPC Password') }}</th>
                            <th class="text-center">{{ __('Network Fee') }}</th>
                            <th class="text-center">{{ __('CA') }}</th>
                            <th class="text-center all no-sort">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list['query'] as $rpclist)
                            <tr>
                                <td class="text-center">{{ $rpclist->item }}</td>
                                <td class="text-center">{{ $rpclist->scheme }}</td>
                                <td class="text-center">{{ $rpclist->host }}</td>
                                <td class="text-center">{{ $rpclist->port }}</td>
                                <td class="text-center">{{ $rpclist->rpc_user }}</td>
                                <td class="text-center">{{ $rpclist->rpc_password }}</td>
                                <td class="text-center">{{ $rpclist->network_fee }}</td>
                                <td class="text-center">{{ $rpclist->cert_ca }}</td>
                                <td class="cm-action">
                                    <div class="btn-group pull-right">
                                        <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if(has_permission('rpcport.edit'))
                                                <li>
                                                    <a href="{{ route('rpcport.edit', $rpclist->id) }}"><i
                                                                class="fa fa-pencil"></i> {{ __('Edit') }}</a>
                                                </li>
                                            @endif

                                            @if(has_permission('rpcport.destroy'))
                                                <li>
                                                    <a data-form-id="delete-{{ $rpclist->id }}" data-form-method="DELETE"
                                                       href="{{ route('rpcport.destroy', $rpclist->id) }}" class="confirmation"
                                                       data-alert="{{__('Do you want to delete this RPC Port?')}}"><i
                                                                class="fa fa-trash-o"></i> {{ __('Delete') }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                             </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {!! $list['pagination'] !!}
@endsection

@section('script')
    <!-- for datatable and date picker -->
    <script src="{{ asset('common/vendors/datepicker/datepicker.js') }}"></script>
    <script src="{{asset('common/vendors/datatable_responsive/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('common/vendors/datatable_responsive/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"></script>
    <script src="{{asset('common/vendors/datatable_responsive/table-datatables-responsive.js')}}"></script>
    <script type="text/javascript">
        //Init jquery Date Picker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true,
        });
    </script>
@endsection