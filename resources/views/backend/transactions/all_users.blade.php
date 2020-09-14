@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<br>
    <h3 class="page-header">{{ $title }}</h3>
    <hr>
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="transactions-all">
                                <thead>
                                <tr>
                                    <th class="all">{{ __('Email') }}</th>
                                    <th class="none">{{ __('First Name') }}</th>
                                    <th class="none">{{ __('Last Name') }}</th>
                                    <th class="all">{{ __('Stock Item') }}</th>
                                    <th class="text-center all">{{ __('Transaction Type') }}</th>
                                    <th class="min-desktop">{{ __('Journal') }}</th>
                                    <th class="min-desktop">{{ __('Amount') }}</th>
                                    <th class="min-desktop">{{ __('Date') }}</th>
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

    <hr>
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            @php
                                $journal = array_flip(config('commonconfig.journal_type'));
                            @endphp
                            <div class="row">
                            @forelse($summary->groupBy(['item','journal']) as $coin => $coinSummary)
                                <div class="col-md-4 col-sm-6">
                                <table class="table table-striped table-bordered" style="font-size: 12px;" id="summary-coin">
                                    <thead>
                                    <tr>
                                        <th class="text-center bg-aqua-active" colspan="2">{{ __('Summary (:coin)',['coin'=>$coin]) }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($coinSummary as $transactionType => $transaction)
                                        <tr>
                                            <td><strong>{{ title_case(str_replace('-',' ',$journal[$transactionType])) }}</strong></td>
                                            <td class="text-right">{{ $transaction->first()->amount }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </div>
                            @empty
                                <p class="text-center">{{ __("No summary found.") }}</p>
                            @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<h3 class="page-header">Filter By Journal Type</h3>
<hr>
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row dc-clear">
            @php($parameters = ['journalType' => null])
                        @foreach(config('commonconfig.journal_type') as $key => $value)
                            @php($parameters['journalType'] = $key)
                                <div class="col-md-3 col-sm-6 cm-mb-5">
                                <input type="submit" data-title="{{ title_case(str_replace('-',' ', $key)) }}" value="{{ title_case(str_replace('-',' ', $key)) }}" class="btn btn-block btn-default journal" data-column="5" data-toggle="tooltip" style="text-overflow: ellipsis; overflow: hidden">
                                </div>
                        @endforeach
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
        // $('a').tooltip();
    </script>
    <script>

           var table =  $('#transactions-all').DataTable({

            processing: true,

            serverSide: true,

            bInfo: false,


            language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},

            ajax: "{{ route('reports.admin.transaction.user.json') }}",

            columns: [
                {data: 'email', name: 'email'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'item', name: 'item'},
                {data: 'transactions-type', name: 'transactions-type', className:'text-center'},
                {data: 'journal-type', name: 'journal-type'},
                {data: 'amount', name: 'amount'},
                {data: 'created_at', name: 'created_at'},
            ]





        });

            $('.journal').on('click',function(){
                 table.column([5])
                               .search( $(this).val() )
                               .draw();
            });

             


    </script>
@endsection