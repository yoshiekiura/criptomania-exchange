@extends('backend.layouts.main_layout')
@section('content')
    <h3 class="page-header">{{ __('Deposits of :itemName', ['itemName' => $wallet->stockItem->item]) }}</h3>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary box-borderless">
          <div class="box-body">
            <div class="cm-filter clearfix">
                <div class="cm-order-filter">
                  <label for="filter-satuan"> Filter By Payment Status :</label>
                   <select data-column="2" class="form-control filter-payment" placeholder="Filter By Category" style="width:30%;" >
                     <option value=""> All </option>
                     <option value="{{payment_status(PAYMENT_COMPLETED)}}"> Completed </option>
                     <option value="{{payment_status(PAYMENT_REVIEWING)}}"> Reviewing </option>
                     <option value="{{payment_status(PAYMENT_PENDING)}}"> Pending </option>
                     <option value="{{payment_status(PAYMENT_FAILED)}}"> Failed </option>
                   </select>
                 </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="depositBank-trader">
                        <thead>
                        <tr>
                            <th class="min-desktop">{{ __('Ref ID') }}</th>
                            <th class="all">{{ __('Amount') }}</th>
                            <th class="all">{{ __('Status') }}</th>
                            <th class="none">{{ __('Bank Name') }}</th>
                            <th class="none">{{ __('Account Number') }}</th>
                            <th class="none">{{ __('Struck Upload') }}</th>
                            <th class="min-desktop">{{ __('Date') }}</th>
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
    //Init jquery Date Picker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true,
        });
    </script>

     <script>
        var table = $('#depositBank-trader').DataTable({
            processing: true,
            serverSide: true,
            language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
            ajax: "{{ route('reports.admin.deposits-bank.json',$walletId) }}",
            order : [6, 'desc'],
            columns:[

            {data:'ref_id', name:'ref_id'},
            {data:'amount', name:'amount'},
            {data:'status', name:'status'},
            {data:'bank-admin', name:'bank-admin'},
            {data:'account_number', name:'account-number'},
            {data:'payment-prove', name:'payment-prove'},
            {data:'created_at', name:'created_at'},
            

            ]


        });

         $('.filter-payment').change(function () {
         table.column( $(this).data('column'))
         .search( $(this).val() )
         .draw();
     });

     //      $('.filter-coin').change(function () {
     //     table.column( $(this).data('column'))
     //     .search( $(this).val() )
     //     .draw();
     // });
    </script>
@endsection