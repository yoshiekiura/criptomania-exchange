@extends('backend.layouts.main_layout')
@section('content')
<h3 class="box-title">{{ __('RPC List') }}</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width: 100% !important;" id="rpc-list">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- for datatable and date picker -->
    <script src="{{ asset('common/vendors/datepicker/datepicker.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript">
        //Init jquery Date Picker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true,
        });
    </script>
    <script>

      $('#rpc-list').DataTable({

        processing: true,
        serverSide: true,
        bInfo: false,
        language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},

        ajax: "{{route('rpcport.json')}}",
        columns: [
          {data: 'item', name: 'item', className:'text-center'},
          {data: 'scheme', name: 'scheme',className:'text-center'},
          {data: 'host', name: 'host',className:'text-center'},
          {data: 'port', name: 'port',className:'text-center'},
          {data: 'rpc_user', name: 'rpc_user',className:'text-center'},
          {data: 'rpc_password', name: 'rpc_password',className:'text-center'},
          {data: 'network_fee', name: 'network_fee',className:'text-center'},
          {data: 'cert_ca', name: 'cert_ca',className:'text-center'},
          {data: 'action', name: 'action', orderable: false, searchable: false,className:'cm-action'},
        ]

      })



    </script>
@endsection
