@extends('backend.layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width: 100% !important;" id="wallet-trader">
                        <thead>
                            <tr>
                                <th class="all text-center">{{ __('Wallet') }}</th>
                                <th class="text-center">{{ __('Wallet Name') }}</th>
                                <th class="text-center">{{ __('Total Balance') }}</th>
                                <th class="text-center">{{ __('On Order') }}</th>
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
    <script src="{{ asset('common/vendors/datatable_responsive/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('common/vendors/datatable_responsive/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('common/vendors/datatable_responsive/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('common/vendors/datatable_responsive/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //Init jquery Date Picker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                orientation: 'bottom',
                todayHighlight: true
            });
        });
    </script>
    <script>
        $('#wallet-trader').DataTable({
            processing: true,
            serverSide: true,
            language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
            ajax: "{{ route('trader.wallets.json') }}",
            columns:[
                {data:'item', name:'item', className:'text-center'},
                {data:'item_name', name:'item_name', className:'text-center'},
                {data:'primary_balance', name:'primary_balance', className:'text-center'},
                {data:'on_order_balance', name:'on_order_balance', className:'text-center'},
                {data: 'action', name: 'action', orderable: false, searchable: false,className:'cm-action'},

            ]


        });
    </script>
@endsection