@extends('backend.layouts.main_layout')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-borderless">
                        <div class="box-body">
                            <table class="table datatable dt-responsive display nowrap dc-table" style="width: 100% !important;" id="stock-pair">
                                <thead>
                                <tr>
                                    <th class="text-center min-desktop">{{ __('Stock Pair') }}</th>
                                    <th class="text-center">{{ __('Exchangeable Item') }}</th>
                                    <th class="text-center">{{ __('Base Item') }}</th>
                                    <th class="text-center">{{ __('Last Price') }}</th>
                                    <th class="text-center no-sort">{{ __('Active Status') }}</th>
                                    <th class="text-center no-sort">{{ __('Default Status') }}</th>
                                    <th class="text-center">{{ __('Created Date') }}</th>
                                    <th class="text-center all no-sort">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
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
    //Init jquery Date Picker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true,
        });
    </script>
    <script>

    $('#stock-pair').DataTable({

    processing: true,

    serverSide: true,

    bInfo: false,


    language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
    ajax: "{{ route('admin.stock-pairs.json') }}",

    columns: [
        {data: 'coin-pair', name: 'coin-pair', className:'text-center'},
        {data: 'stock_item_abbr', name: 'stock_item.item',className:'text-center'},
        {data: 'base_item_name', name: 'base_item.item',className:'text-center'},
        {data: 'last_price', name: 'last_price',className:'text-center'},
        {data: 'is_active', name: 'is_active',className:'text-center'},
        {data: 'is_default', name: 'is_default',className:'text-center'},
        {data: 'created_at', name: 'stock_pairs.created_at',className:'text-center'},
        {data: 'action', name: 'action', orderable: false, searchable: false,className:'cm-action'},
    ]



});


    </script>
@endsection
