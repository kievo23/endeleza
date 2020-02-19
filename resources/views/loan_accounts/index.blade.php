@extends('layouts.app')

@section('title')
Endeleza: {{$title}}
@endsection

@section('assets')

<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

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
                            <h5 class="mr-2 mb-0">Ksh. {{$valueOfTransactions}}</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <!-- <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i> -->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Value of all Interests</small>
                            <h5 class="mr-2 mb-0">Ksh. {{$valueOfInterests}}</h5>
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
                  <!-- <div>
					          Toggle column: 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="0">Loan Id</a> -
                    <a class="toggle-vis badge badge-pill badge-info" data-column="1">Customer</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="2">Phone</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="3">Delivery Id</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="5">Principal Amount</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="6">Trn Charge</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="7">Interest</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="8">Penalty</a> -
                    <a class="toggle-vis badge badge-pill badge-info" data-column="9">Loan Amount</a> -  
                    <a class="toggle-vis badge badge-pill badge-info" data-column="10">Balance</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="11">Status</a>
                    <a class="toggle-vis badge badge-pill badge-info" data-column="12">Hours</a>
                    <a class="toggle-vis badge badge-pill badge-info" data-column="13">Created At</a>
				          </div> -->
                  <hr>
                  <div class="table-responsive">
                    <table id="loan_accounts" class="table">
                      <thead>
                        <tr>
                            <th>Loan Account ID</th>
                            <!-- <th>Loan Product ID</th> -->
                            <th>Customer Account</th>
                            <th>Customer Phone</th>
                            <!-- <th>Agent </th> -->
                            <!-- <th>Delivery ID</th> -->
                            <th>Till Number</th>
                            <th>Principal Amount</th>
                            <!-- <th>Trn Charge</th> -->
                            <th>Interest</th>
                            <th>Loan Penalty</th>
                            <th>Loan Amount</th>
                            <th>Loan Balance</th>                            
                            <th>Loan Status</th>
                            <th>Hours in Arrears</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($loan_accounts as $account)
                        <tr>
                            <td>{{$account->id}}</td>
                            <!-- <td>{{$account->loan_product_id}}</td> -->
                            <td>{{$account->customer->person ? $account->customer->person->full_name : ''}}</td>
                            <td> {{$account->customer ? $account->customer->customer_account_msisdn : ''}}</td>
                            <!-- <td> {{$account->customer->agent->person ? $account->customer->agent->person->two_name : ''}}</td> -->
                            <!-- <td>{{$account->delivery_id}}</td> -->
                            <td>{{$account->delivery->till_number}}</td>
                            <td>{{$account->principal_amount}}</td>
                            <!-- <td>{{$account->trn_charge}}</td> -->
                            <td>{{$account->interest_charged}}</td>
                            <td>{{$account->loan_penalty}}</td>  
                            <td>{{$account->loan_amount}}</td>
                            <td>{{$account->loan_balance}}</td>                                                      
                            <td>@if($account->loan_status == "0")
                            <label class="label label-danger">Not cleared</label>
                            @else
                            <label class="label label-success">Cleared</label>
                            @endif
                            </td>
                            <td>{{$account->hours_in_arrears}} ({{$account->days_in_arrears}} days)</td>
                            <td>{{$account->created_at}}</td>
                            <td>
                              @php
                              $link = $account->customer ? $account->customer->customer_account_msisdn : '';
                              @endphp
                              <a href="{{ url('/customer/searchByPhone/'.$link) }}">
                                <i class="feather icon-list"></i> Statement
                              </a>
                              @if((auth()->user()->can('delete-loan') || auth()->user()->hasRole('admin')))
                                <form action="{{ route('loan_accounts.destroy', [$account->id]) }}" class="col-sm-5 deleteForm" method="POST" >
                                  @csrf
                                  {{method_field('DELETE')}}
                                    <button type="button" class="deleteBtn btn btn-link">
                                      <i class="feather icon-trash-2"></i>Drop
                                    </button>
                                </form>
                              @endif
                            </td>
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

<script>

$(document).ready( function () {
    let table = $('#loan_accounts').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
    
            // Get the column API object
            var column = table.column( $(this).attr('data-column') );
    
            // Toggle the visibility
            column.visible( ! column.visible() );
    });

    $(".deleteBtn").on('click',function(e) {
        //alert(this.form);
        validate(this.form);
    });
} );

function validate(form){
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
          setTimeout(function(){ 
              form.submit();
          }, 1000);        
        } else {
          swal("Okay, You have stopped the check successfully");
        }
    });
}

</script>
@endsection