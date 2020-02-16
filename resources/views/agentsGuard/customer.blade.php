@extends('layouts.agent')

@section('title')
M-Weza: {{$title}}
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
                    <h2>{{$title}}</h2>
                    <p class="mb-md-0">Your analytics dashboard.</p>
                  </div>
                  
                </div>
                
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                <!-- <button class="btn btn-warning mt-2 mt-xl-0"><a href="">Create Customer</a></button> -->
                  <p class="card-title">Statement</p>
                  <div class="table-responsive">
                    <table id="statement" class="table">
                      <thead>
                        <tr>
                            <th>Created At</th>
                            <th>Description</th>
                            <th>Transaction Charge</th>
                            <th>Interest</th>
                            <th>Penalty</th>
                            <th>Loan Principal</th>
                            <th>Receipt</th>
                            <th class='table-warning'>Debit</th>
                            <th class='table-success'>Credit</th>
                            <th>Balance</th>                            
                        </tr>
                      </thead>
                      <tbody>
                        @php 
                            $balance = 0;
                        @endphp
                        @foreach($results as $record)
                        <tr> 
                            @php
                                $total = 0;
                                $description = "";
                            @endphp 
                            @if($record->type == 1)
                                @php                                    
                                    $total = $record->trn_charge+$record->interest_charged+$record->loan_penalty+$record->loan_amount;
                                    $balance = $balance - $total;
                                    $description = "Loan";
                                @endphp
                            @else
                                @php                                    
                                    $balance = $balance + $record->amount;
                                    $description = "Payment";
                                @endphp
                            @endif
                            <td>{{$record->created_at}}</td>
                            <td>{{$description}}</td>
                            <td>{{$record->trn_charge}}</td>
                            <td>{{$record->interest_charged}}</td>
                            <td>{{$record->loan_penalty}}</td>
                            <td>{{$record->loan_amount}}</td>
                            <td>{{$record->receipt}}</td>
                            <td class='table-warning'>{{$total}}</td>
                            <td class='table-success'>{{$record->amount}}</td> 
                            <td>{{$balance}}</td>
                        </tr>
                        @endforeach                        
                      </tbody>
                      <tfooter>
                        <tr>
                            @if($balance < 1)
                                <td class="table-danger">Balance: {{$balance}}</td>
                            @else
                                <td class="table-success">Balance: {{$balance}}</td>
                            @endif
                        </tr>
                      </tfooter>
                    </table>
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
                  <div class="table-responsive">
                    <table id="loan_accounts" class="table">
                      <thead>
                        <tr>
                            <th>Loan Account ID</th>
                            <!-- <th>Loan Product ID</th> -->
                            <th>Customer Account</th>
                            <th>Customer Phone</th>
                            <th>Delivery ID</th>
                            <th>Till Number</th>
                            <th>Principal Amount</th>
                            <th>Trn Charge</th>
                            <th>Interest</th>
                            <th>Loan Penalty</th>
                            <th>Loan Amount</th>
                            <th>Loan Balance</th>                            
                            <th>Loan Status</th>
                            <th>Hours in Arrears</th>
                            <!-- <th>Deleted</th> -->
                            <!-- <th>Created By</th> -->
                            <!-- <th>Updated By</th> -->
                            <!-- <th>Deleted By</th> -->
                            <!-- <th>Date Deleted</th> -->
                            <th>Date Created</th>
                            <!-- <th>Date Updated</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($loans as $account)
                        <tr>
                            <td>{{$account->id}}</td>
                            <!-- <td>{{$account->loan_product_id}}</td> -->
                            <td>{{$account->customer ? $account->customer->person->full_name : ''}}</td>
                            <td> {{$account->customer ? $account->customer->customer_account_msisdn : ''}}</td>
                            <td>{{$account->delivery_id}}</td>
                            <td>{{$account->delivery->till_number}}</td>
                            <td>{{$account->principal_amount}}</td>
                            <td>{{$account->trn_charge}}</td>
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
                            <!-- <td>{{$account->deleted}}</td> -->
                            <!-- <td>{{$account->created_by}}</td> -->
                            <!-- <td>{{$account->updated_by}}</td> -->
                            <!-- <td>{{$account->deleted_by}}</td> -->
                            <!-- <td>{{$account->date_deleted}}</td> -->
                            <td>{{$account->created_at}}</td>
                            <!-- <td>{{$account->updated_at}}</td> -->
                        </tr>
                        @endforeach                        
                      </tbody>
                    </table>
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
                  <div class="table-responsive">
                  <table id="transactions" class="table">
                      <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer ID</th>
                            <th>Loan Account ID</th>
                            <th>MSISDN</th>
                            <th>Transaction Reference</th>
                            <th>Transaction Amount</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Transaction Time</th>
                            <th>Transaction Status</th>
                            <th>Transaction Type</th>
                            <!-- <th>Created By</th> -->
                            <!-- <th>Updated By</th> -->
                            <!-- <th>Date Updated</th> -->
                            <!-- <th>Deleted By</th> -->
                            <!-- <th>Date Deleted</th> -->
                            <th>Created At</th>
                            <!-- <th>Updated At</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->id}}</td>
                            @if(isset($transaction->customer->person))
                              <td>{{$transaction->customer->person->first_name}} {{$transaction->customer->person->surname}}</td>
                            @else
                            <td>Not Known</td>
                            @endif
                            
                            <td>{{$transaction->loan_account_id}}</td>
                            <td>{{$transaction->msisdn}}</td>
                            <td>{{$transaction->transaction_reference}}</td>
                            <td>{{$transaction->transaction_amount}}</td>
                            <td>{{$transaction->debit}}</td>
                            <td>{{$transaction->credit}}</td>
                            <td>{{$transaction->transaction_time}}</td>
                            <td>{{$transaction->transaction_status}}</td>
                            <td>{{$transaction->transaction_type}}</td>
                            <!-- <td>{{$transaction->created_by}}</td> -->
                            <!-- <td>{{$transaction->updated_by}}</td> -->
                            <!-- <td>{{$transaction->date_updated}}</td> -->
                            <!-- <td>{{$transaction->deleted_by}}</td> -->
                            <!-- <td>{{$transaction->date_deleted}}</td> -->
                            <td>{{$transaction->created_at}}</td>
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


          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Delivery Notifications</p>
                  <div class="table-responsive">
                    <table id="delivery_notifications" class="table">
                      <thead>
                        <tr>
                            <th>Notification ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Receipt Number</th>
                            <th>Amount</th>
                            <th>Delivery Date</th>
                            <th>Route Team ID</th>
                            <th>Till Number</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Created at</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($delivery_notifications as $notification)
                        <tr>
                            <td>{{$notification->id}}</td>
                            <td>{{$notification->customer->person->full_name }}</td>
                            <td>{{$notification->customer->customer_account_msisdn}}</td>
                            <td>{{$notification->receipt_number}}</td>
                            <td>{{$notification->amount}}</td>
                            <td>{{$notification->delivery_date}}</td>
                            <td>{{$notification->route_team_id}}</td>
                            <td>{{$notification->till_number}}</td>
                            <td>{{$notification->phone}}</td>
                            <td>
                              @if($notification->status == "0")
                              <label class="label label-danger">Not Active</label>
                              @else
                              <label class="label label-success">Active</label>
                              @endif
                            </td>
                            <td>{{$notification->created_at}}</td>
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

<script>

$(document).ready( function () {
    $('#loan_accounts').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#transactions').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#delivery_notifications').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
} );

</script>
@endsection