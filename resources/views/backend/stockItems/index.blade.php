@extends('backend.layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width: 100% !important;" id="stock-item">
                        <thead>
                        <tr>
                            <th class="text-center">{{ __('Emoji') }}</th>
                            <th class="all text-center">{{ __('Stock Item') }}</th>
                            <th class="text-center">{{ __('Stock Item Name') }}</th>
                            <th class="text-center">{{ __('Stock Item Type') }}</th>
                            <th class="text-center">{{ __('Active Status') }}</th>
                            <th class="text-center">{{ __('Created Date') }}</th>
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
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
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

    $('#stock-item').DataTable({

    processing: true,

    serverSide: true,

    bInfo: false,


    language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
    ajax: "{{ route('admin.stock-items.json') }}",

    columns: [
        {data: 'emoji', name: 'emoji', className:'text-center'},
        {data: 'item', name: 'item', className:'text-center'},
        {data: 'item_name', name: 'item_name', className:'text-center'},
        {data: 'item-type', name: 'item-type', className:'text-center'},
        {data: 'status', name: 'status', className:'text-center'},
        {data: 'create', name: 'create', className:'text-center'},
        {data: 'action', name: 'action', orderable: false, searchable: false, className:'cm-action'},
    ]



});


    </script>
@endsection