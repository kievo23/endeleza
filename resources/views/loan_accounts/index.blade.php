@extends('layouts.app')

@section('title')
Endeleza: {{$title}}
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
              <h2>Endeleza Loans</h2>
              <p class="mb-md-0">Your analytics dashboard.</p>
            </div>
            <div class="d-flex">
              <i class="mdi mdi-home text-muted hover-cursor"></i>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-end flex-wrap">
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
                      <small class="mb-1 text-muted">Number of Loans</small>
                      <h5 class="mr-2 mb-0">{{count($loan_accounts)}}</h5>
                    </div>
                  </div>
                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-eye mr-3 icon-lg text-success"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Number of Cleared Loans</small>
                      <h5 class="mr-2 mb-0">{{$clearedLoans}}</h5>
                    </div>
                  </div>
                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-download mr-3 icon-lg text-warning"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Value of loans given</small>
                      <h5 class="mr-2 mb-0">Ksh. {{$valueOfLoans}}</h5>
                    </div>
                  </div>
                  <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Value of loans outstanding</small>
                      <h5 class="mr-2 mb-0">Ksh. {{$valueOfOutstandingLoans}}</h5>
                    </div>
                  </div>
                  <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Value of all Transactions</small>
                      <h5 class="mr-2 mb-0">Ksh. {{$repayable}}</h5>
                    </div>
                  </div>
                  <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Value of all Penalties</small>
                      <h5 class="mr-2 mb-0">Ksh. {{$valueOfLoanPenalty}}</h5>
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
            <p class="card-title">Loan Accounts</p>
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
              <i class="fa fa-calendar"></i>&nbsp;
              <span></span> <i class="fa fa-caret-down"></i>
            </div>
            <div class="form-group text-right mt-2">
              <form>
                 <input type="hidden" name="start_date" id="start_date">
                 <input type="hidden" name="end_date" id="end_date">
                 <button type="submit" class="btn btn-primary">Filter</button>
                 <a href="{{ route('loan_accounts.index') }}" class="btn btn-secondary">Reset</a>
               </form>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="loan_accounts" class="table">
                <thead>
                  <tr>
                    <th>Date Created</th>
                    <th>Customer</th>
                    <th>Customer Phone</th>
                    <th>Business</th>
                    <th>Principal</th>
                    <th>Repayable</th>
                    <th>Till</th>
                    <th>Paid Amount</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Penalty</th>
                    <th>Days</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($loan_accounts as $account)
                  <tr>
                    <td>{{$account->created_at}}</td>
                    <td>{{$account->customer ? $account->customer->person->full_name : ''}}</td>
                    <td>{{$account->customer ? $account->customer->customer_account_msisdn : ''}}</td>
                    <td>{{$account->customer ? $account->customer->person->business_name : ''}}</td>
                    <td>{{$account->principal_amount}}</td>
                    <td>{{$account->loan_amount}}</td>
                    <td>{{$account->delivery->till_number}}</td>
                    <td>{{($account->loan_amount +  $account->loan_penalty) - $account->loan_balance }}</td>
                    <td>{{ $account->loan_balance }}</td>
                    <td>@if($account->loan_status == "0")
                      <label class="label label-warning">Active</label>
                      @else
                      <label class="label label-success">Cleared</label>
                      @endif
                    </td>
                    <td>{{$account->loan_penalty}}</td>
                    <td>{{$account->days_in_arrears}} days</td>
                    <td>
                      @php
                      $link = $account->customer ? $account->customer->customer_account_msisdn : '';
                      @endphp
                      <a href="{{ url('/customer/searchByPhone/'.$link) }}">
                      <i class="feather icon-list"></i> Statement
                    </a>
                    @if((auth()->user()->can('delete-loan') || auth()->user()->hasRole('admin')))
                    <form action="{{ route('loan_accounts.destroy', [$account->id]) }}" class="col-sm-5 deleteForm" method="POST">
                      @csrf
                      {{method_field('DELETE')}}
                      <button type="button" class="deleteBtn btn btn-link">
                        <i class="feather icon-trash-2"></i>Drop
                      </button>
                    </form>
                    @endif
                  </td>
                  <!-- <td>{{$account->id}}</td> -->
                  <!-- <td>{{$account->loan_product_id}}</td> -->
                  <!-- <td> {{$account->customer->agent->person ? $account->customer->agent->person->two_name : ''}}</td> -->
                  <!-- <td>{{$account->delivery_id}}</td> -->
                  <!-- <td>{{$account->trn_charge}}</td> -->
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

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
      let table = $('#loan_accounts').DataTable({
        dom: 'Bfrtip',
        pageLength: 50,
        order: [[ 0, "desc" ]],
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

      $('a.toggle-vis').on('click', function(e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());
      });

      $(".deleteBtn").on('click', function(e) {
        //alert(this.form);
        validate(this.form);
      });
    });

    function validate(form) {
      //form.preventDefault();
      swal({
          title: "Are you sure?",
          text: "This will edit the details to the database",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("You have executed this check successfully ", {
              icon: "success",
            });
            setTimeout(function() {
              form.submit();
            }, 1000);
          } else {
            swal("Okay, You have stopped the check successfully");
          }
        });
    }
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