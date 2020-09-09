@extends('backend.layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="id-management">
                        <thead>
                        <tr>
                            <th class="all">{{ __('Email') }}</th>
                            <th  class="min-phone-l">{{ __('ID Type') }}</th>
                            <th  class="min-phone-l">{{ __('Verification Status') }}</th>
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
        <!-- //Init jquery Date Picker -->
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

    $('#id-management').DataTable({

        processing: true,

        serverSide: true,

        bInfo: false,


        language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
        ajax: "{{ route('admin.id-management-json') }}",

        columns: [
            {data: 'email', name: 'email'},
            {data: 'id-type', name: 'id-type'},
            {data: 'status', name: 'status', className:'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className:'cm-action'},
        ]



    });
    </script>
@endsection