@extends('backend.layouts.main_layout')
@section('content')
    <div class="card">
      <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-borderless">
                        <div class="box-body">
                            <table class="table datatable dt-responsive display nowrap dc-table" style="width: 100% !important;" id="api-service">
                                <thead>
                                <tr>
                                    <!-- <th class="all text-center">{{ __('Api Core') }}</th> -->
                                    <th class="text-center">{{ __('Api Name') }}</th>
                                    <th class="text-center">{{ __('Created At') }}</th>
                                    <!-- <th class="text-center all no-sort">{{ __('Action') }}</th> -->
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

    $('#api-service').DataTable({

    processing: true,

    serverSide: true,

    bInfo: false,


    language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
    ajax: "{{ route('admin.api-service-name-json') }}",

    columns: [
        {data: 'api_name', name: 'api_name', className:'text-center'},
        {data: 'created', name: 'created', className:'text-center'},
    ]



});


    </script>
@endsection
