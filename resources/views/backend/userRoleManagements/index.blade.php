@extends('backend.layouts.main_layout')
@section('content')
<br>
<h3 class="page-header">{{ __('User Role List') }}</h3>
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-borderless">
                        <div class="box-body">
                            <table class="table table-striped table-bordered" style="width:100% !important;" id="user-role">
                                <thead>
                                <tr>
                                    <th class="all">{{ __('Role Name') }}</th>
                                    <th class="min-phone-l">{{ __('Status') }}</th>
                                    <th class="min-phone-l">{{ __('Created Date') }}</th>
                                    <th class="all no-sort">Action</th>
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
    var table = $('#user-role').DataTable({

        processing: true,

        serverSide: true,

        bInfo: false,

        dom: 'l<"toolbar">frtip',

        language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
        ajax: "{{ route('user-role-managements.json') }}",

        columns: [
            {data: 'role_name', name: 'role_name', className:'text-center'},
            {data: 'is_active', name: 'is_active', className:'text-center'},
            {data: 'created_at', name: 'created_at',className:'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false,className:'text-center cm-action'},
        ]
    });
</script>
@endsection

