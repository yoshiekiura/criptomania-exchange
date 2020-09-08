@extends('backend.layouts.main_layout')
@section('content')
<!-- Crypto Currency Review -->
    <h3 class="page-header">Crypto Coin Withdrawals for Reviewing</h3>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary box-borderless">
          <div class="box-body">
            <div class="cm-filter clearfix">
                <div class="cm-order-filter">
                  <label for="filter-satuan"> Filter By Coin Name :</label>
                   <select data-column="1" class="form-control crypto-coin-name" placeholder="Filter By Coin Name" style="width:30%;">
                     <option value=""> All </option>
                     @foreach($cryptoCurrency as $crypto)
                     <option value="{{$crypto->item}}"> {{$crypto->item}} </option>
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
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="review-wd-cryptocurrency">
                        <thead>
                        <tr>
                            <th class="min-desktop">{{ __('Ref ID') }}</th>
                            <th class="all">{{ __('Stock Item Name') }}</th>
                            <th class="all">{{ __('Amount') }}</th>
                            <th class="min-desktop">{{ __('Address') }}</th>
                            <th class="none">{{ __('Status') }}</th>
                            <th class="none">{{ __('Withdrawn by') }}</th>
                            <th class="none">{{ __('Txn Id') }}</th>
                            <th class="min-desktop">{{ __('Date') }}</th>
                            <th class="text-center all no-sort">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Real Currency Review -->
    <h3 class="page-header">Real Currency Withdrawals for Reviewing</h3>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary box-borderless">
          <div class="box-body">
            <div class="cm-filter clearfix">
               <div class="cm-order-filter">
                  <label for="filter-satuan"> Filter By Category :</label>
                   <select data-column="4" class="form-control filter-payment" placeholder="Filter By Category" style="width:30%;">
                     <option value=""> All </option>
                     <option value="{{payment_status(PAYMENT_COMPLETED)}}"> Completed </option>
                     <option value="{{payment_status(PAYMENT_PENDING)}}"> Pending </option>
                     <option value="{{payment_status(PAYMENT_FAILED)}}"> Failed </option>
                   </select>
                 </div>
                <div class="cm-order-filter">
                  <label for="filter-satuan"> Filter By Coin Name :</label>
                   <select data-column="1" class="form-control real-coin-name" placeholder="Filter By Coin Name" style="width:30%;">
                     <option value=""> All </option>
                     @foreach($realCurrency as $real)
                     <option value="{{$real->item}}"> {{$real->item}} </option>
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
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="review-wd-realcurrency">
                        <thead>
                        <tr>
                            <th class="min-desktop">{{ __('Ref ID') }}</th>
                            <th class="all">{{ __('Stock Item Name') }}</th>
                            <th class="all">{{ __('Amount') }}</th>
                            <th class="min-desktop">{{ __('Address') }}</th>
                            <th class="none">{{ __('Status') }}</th>
                            <th class="none">{{ __('Withdrawn by') }}</th>
                            <th class="none">{{ __('Txn Id') }}</th>
                            <th class="min-desktop">{{ __('Date') }}</th>
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

    <!-- Crypto Currency Review -->
    <script>
    var tableCrypto = $('#review-wd-cryptocurrency').DataTable({
                        processing: true,
                        serverSide: true,
                        language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
                        ajax: "{{ route('admin.review-withdrawals-cryptocurrency.json')}}",
                        order : [8, 'desc'],
                        columns: [
                          {data:'ref_id', name:'ref_id'},
                          {data:'stock-name', name:'stock-name'},
                          {data:'amount', name:'amount'},
                          {data:'address', name:'address'},
                          {data:'status', name:'status'},
                          {data:'email', name:'email'},
                          {data:'txn_id', name:'txn_id'},
                          {data:'created_at', name:'created_at'},
                          {data: 'action', name: 'action', orderable: false, searchable: false, className:'cm-action'},

                        ]
                      });

                      $('.crypto-coin-name').change(function () {
                         tableCrypto.column( $(this).data('column'))
                         .search( $(this).val() )
                         .draw();
                     });
    </script>

    <!-- Real Currency Review -->
    <script>
    var tableReal = $('#review-wd-realcurrency').DataTable({
                        processing: true,
                        serverSide: true,
                        language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
                        ajax: "{{ route('admin.review-withdrawals-bank.json')}}",
                        order : [8, 'desc'],
                        columns: [
                          {data:'ref_id', name:'ref_id'},
                          {data:'stock-name', name:'stock-name'},
                          {data:'amount', name:'amount'},
                          {data:'address', name:'address'},
                          {data:'status', name:'status'},
                          {data:'email', name:'email'},
                          {data:'txn_id', name:'txn_id'},
                          {data:'created_at', name:'created_at'},
                          {data: 'action', name: 'action', orderable: false, searchable: false, className:'cm-action'},

                        ]
                      });

                     $('.filter-payment').change(function () {
                       tableReal.column( $(this).data('column'))
                       .search( $(this).val() )
                       .draw();
                   });

                      $('.real-coin-name').change(function () {
                         tableReal.column( $(this).data('column'))
                         .search( $(this).val() )
                         .draw();
                     });


    </script>
@endsection
