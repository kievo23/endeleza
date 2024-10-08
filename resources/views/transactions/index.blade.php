@extends('layouts.app')

@section('title')
Endeleza: Transactions
@endsection

@section('assets')

<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection

@section('content')

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">

    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
          <div class="d-flex align-items-end flex-wrap">
            <div class="mr-md-3 mr-xl-5">
              <h2>Welcome back,</h2>
              <p class="mb-md-0">Your analytics dashboard.</p>
            </div>
            <div class="d-flex">
              <i class="mdi mdi-home text-muted hover-cursor"></i>
              <!-- <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Analytics</p> -->
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-end flex-wrap">
            <!-- <button type="button" class="btn btn-light bg-white btn-icon mr-3 d-none d-md-block ">
                    <i class="mdi mdi-download text-muted"></i>
                  </button>
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-clock-outline text-muted"></i>
                  </button>
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-plus text-muted"></i>
                  </button> -->
            <!-- <button class="btn btn-primary mt-2 mt-xl-0">Generate report</button> -->
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body dashboard-tabs p-0">
            <ul class="nav nav-tabs px-4" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
              </li>

            </ul>
            <div class="tab-content py-0 px-0">
              <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <div class="d-flex flex-wrap justify-content-xl-between">

                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Total number of transactions</small>
                      <h5 class="mr-2 mb-0">{{count($transactions)}}</h5>
                    </div>
                  </div>
                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-eye mr-3 icon-lg text-success"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Total value of transactions</small>
                      <h5 class="mr-2 mb-0">Ksh. {{$valueOfAllTransactions}}</h5>
                    </div>
                  </div>
                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-download mr-3 icon-lg text-warning"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Hanging Transactions</small>
                      <h5 class="mr-2 mb-0">Ksh. {{$transactionsWithoutACustomer}}</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Transactions</p>
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
              <i class="fa fa-calendar"></i>&nbsp;
              <span></span> <i class="fa fa-caret-down"></i>
            </div>

            <div class="form-group text-right mt-2">
              <form>
                 <input type="hidden" name="start_date" id="start_date">
                 <input type="hidden" name="end_date" id="end_date">
                 <button type="submit" class="btn btn-primary">Filter</button>
                 <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Reset</a>
               </form>
            </div>
            <div class="table-responsive">
              <table id="transactions" class="table">
                <thead>
                  <tr>
                    <th>Transaction Reference</th>
                    <th>Customer Names</th>                    
                    <th>PhoneNo.</th>
                    <th>Paid By</th>
                    <th>Transaction Time</th>
                    <th>Transaction Amount</th>
                    <th>Transaction Type</th>
                    <th>Actions</th>
                    <!-- <th>Transaction ID</th> -->
                    <!-- <th>Loan Account ID</th> -->
                    <!-- <th>Paid By</th> -->
                    <!-- <th>Debit</th> -->
                    <!-- <th>Credit</th> -->
                    <!-- <th>Transaction Status</th> -->
                    <!-- <th>Transaction Type</th> -->
                    <!-- <th>Created By</th> -->
                    <!-- <th>Updated By</th> -->
                    <!-- <th>Date Updated</th> -->
                    <!-- <th>Deleted By</th> -->
                    <!-- <th>Date Deleted</th> -->
                    <!-- <th>Created At</th> -->
                    <!-- <th>Updated At</th> -->
                  </tr>
                </thead>
                <tbody>
                  @foreach($transactions as $transaction)
                  <tr>
                    <td>{{$transaction->transaction_reference}}</td>

                    @if(isset($transaction->customer->person))
                    <td>{{$transaction->customer->person->first_name}} {{$transaction->customer->person->surname}} ({{$transaction->customer->customer_account_msisdn}})</td>
                    @else
                    <td>Not Known</td>
                    @endif

                    <td>{{$transaction->paid_by}}</td>
                    <td>{{$transaction->payer_names}}</td>
                    <td>{{$transaction->transaction_time}}</td>
                    <td>{{$transaction->transaction_amount}}</td>
                    <td>{{$transaction->transaction_type}}</td>
                    <td>@if(!isset($transaction->customer->person))
                    <a href="{{ url('transactions/reconcile/'.$transaction->id) }}">
                                <i class="feather icon-edit"></i> Recon
                              </a>
                    @endif</td>

                    <!-- <td>{{$transaction->id}}</td> -->
                    <!-- <td>{{$transaction->loan_account_id}}</td> -->
                    <!-- <td>{{$transaction->paid_by}}</td>                     -->
                    <!-- <td>{{$transaction->debit}}</td> -->
                    <!-- <td>{{$transaction->credit}}</td> -->
                    <!-- <td>{{$transaction->transaction_status}}</td> -->
                    <!-- <td>{{$transaction->transaction_type}}</td> -->
                    <!-- <td>{{$transaction->created_by}}</td> -->
                    <!-- <td>{{$transaction->updated_by}}</td> -->
                    <!-- <td>{{$transaction->date_updated}}</td> -->
                    <!-- <td>{{$transaction->deleted_by}}</td> -->
                    <!-- <td>{{$transaction->date_deleted}}</td> -->
                    <!-- <td>{{$transaction->created_at}}</td> -->
                    <!-- <td>{{$transaction->updated_at}}</td> -->
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->

  @endsection

  @section('js')

  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#transactions').DataTable({
        order: [[ 4, "desc" ]],
        pageLength: 50,
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
  </script>

  <script type="text/javascript">
    $(function() {

      var start = moment().subtract(29, 'days');
      var end = moment();

      function cb(start, end) {
        console.log(start,end);
        var start_date = start.format('YYYY-MM-DD 00:00:00');
        var end_date = end.format('YYYY-MM-DD 23:59:59');
        $('#start_date').val(start_date);
        $('#end_date').val(end_date);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
      
      $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
      }, cb);

      cb(start, end);

    });
  </script>
  @endsection