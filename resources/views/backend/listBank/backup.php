@extends('backend.layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table table-bordered data-table" style="width: 100% !important;" id="list-bank">
                        <thead>
                        <tr>
                            <th class="text-center">{{ __('Bank Name') }}</th>
                            <th class="text-center">{{ __('Account Number') }}</th>
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
    <script>
      

            $('#list-bank').DataTable({
                processing: false,
                serverSide: true,
                paging: true,
                searching: true,
                ajax : '{{route("admin.list-bank.json")}}',
                type : 'GET',
                columns: [
                    {className: 'text-center', data: 'bank_name', name: 'bank_name'},
                    {className: 'text-center', data: 'account_number', name: 'account_number'},
                    {className: 'text-center', data: 'created_at', name: 'created_at'},
                    {className:'cm-action', data: 'action', name: 'action', orderable: true, searcable: true},

                ]

            });


    </script>
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