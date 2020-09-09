@extends('backend.layouts.main_layout')
@php
    $stockItem = App\Models\Backend\StockItem::all();
@endphp
@section('content')
    <h3 class="page-header">{{ __('List of Withdrawals') }}</h3>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary box-borderless">
          <div class="box-body">
            <div class="cm-filter clearfix">
                <div class="cm-order-filter">
                  <label for="filter-satuan"> Filter By Category :</label>
                   <select data-column="3" class="form-control filter-payment" placeholder="Filter By Category" style="width:30%;">
                     <option value=""> All </option>
                     <option value="{{payment_status(PAYMENT_COMPLETED)}}"> Completed </option>
                     <option value="{{payment_status(PAYMENT_PENDING)}}"> Pending </option>
                     <option value="{{payment_status(PAYMENT_FAILED)}}"> Failed </option>
                   </select>
                 </div>

                 <div class="cm-order-filter">
                  <label for="filter-satuan"> Filter By Coin :</label>
                   <select data-column="1" class="form-control filter-coin" placeholder="Filter By Category" style="width:30%;">
                     <option value="" selected="selected"> All </option>
                     @foreach($stockItem as $stock)
                     <option value="{{$stock->item}}"> {{$stock->item}} </option>
                     @endforeach
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
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="all-withdraw-trader">
                        <thead>
                        <tr>
                            <th class="min-desktop">{{ __('Ref ID') }}</th>
                            <th class="all">{{ __('Stock Name') }}</th>
                            <th class="all">{{ __('Amount') }}</th>
                            <th class="all">{{ __('Status') }}</th>
                            <th class="all">{{ __('User') }}</th>
                            <th class="none">{{ __('Address') }}</th>
                            <th class="none">{{ __('Txn Id') }}</th>
                            <th class="min-desktop">{{ __('Date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
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
        var table = $('#all-withdraw-trader').DataTable({
            processing: true,
            serverSide: true,
            language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
            ajax: "{{ route('reports.admin.all-withdrawals.json') }}",
            order : [7, 'desc'],
            columns:[

            {data:'ref_id', name:'ref_id'},
            {data:'item', name:'item'},
            {data:'amount', name:'amount'},
            {data:'status', name:'status'},
            {data:'email', name:'email'},
            {data:'address', name:'address'},
            {data:'txn_id', name:'txn_id'},
            {data:'created_at', name:'created_at'},

            

            ]


        });

         $('.filter-payment').change(function () {
         table.column( $(this).data('column'))
         .search( $(this).val() )
         .draw();
     });

          $('.filter-coin').change(function () {
         table.column( $(this).data('column'))
         .search( $(this).val() )
         .draw();
     });
    </script>
@endsection