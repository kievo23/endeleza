@extends('layouts.app')

@section('title')
Endeleza: Customers
@endsection

@section('assets')

<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
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
                  <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                  <button class="btn btn-warning mt-2 mt-xl-0"><a href="{{ route('customers.create') }}">Create Customer</a></button>
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
                            <small class="mb-1 text-muted">Number of Customers</small>
                            <h5 class="mr-2 mb-0">{{count($customers)}}</h5>
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
                <!-- <button class="btn btn-warning mt-2 mt-xl-0"><a href="">Create Customer</a></button> -->
                  <p class="card-title">CUSTOMERS</p>


                  <!-- <div>
					          Toggle column: 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="0">Customer Id</a> -
                    <a class="toggle-vis badge badge-pill badge-info" data-column="1">Person Id</a> -
                    <a class="toggle-vis badge badge-pill badge-info" data-column="2">Agent</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="3">Customer MSISDN</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="4">Blocked</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="5">Reset</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="6">Active</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="7">Pin Change</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="8">Account Limit</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="9">Created At</a> - 
                    <a class="toggle-vis badge badge-pill badge-info" data-column="10">Actions</a>
				          </div>
                  <hr> -->

                  <div class="table-responsive">
                    <table id="customers" class="table display">
                      <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Person</th>
                            <th>Agent</th>
                            <th>Business</th>
                            <th>Customer Account MSISDN</th>
                            <th>Blocked</th>
                            <th>Active</th>
                            <th>Account Limit</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{$customer->id}}</td>
                            <td>{{$customer->person->first_name ." ".$customer->person->surname}}</td>
                            <td>
                            @if($customer->agent->person)
                            {{$customer->agent->person->full_name}}
                            @endif
                            </td>
                            <td>
                            @if($customer->person->business_name)
                            {{$customer->person->business_name}}
                            @endif
                            </td>
                            <td>{{$customer->customer_account_msisdn}}</td>
                            <td>{{$customer->blocked}}</td>
                            
                            <td>@if($customer->active == "0")
                              <label class="label label-danger">Not Active</label>
                              @else
                              <label class="label label-success">Active</label>
                              @endif
                            </td> 
                            <td>{{$customer->account_limit}}</td>
                            <td>{{$customer->created_at}}</td>
                            <td>
                              <a href="{{ url('customers/'.$customer->id.'/edit') }}">
                                <i class="feather icon-edit"></i> Edit
                              </a>
                              <a href="{{ url('customer/searchByPhone/'.$customer->customer_account_msisdn) }}">
                                <i class="feather icon-align-justify"></i> Statement
                              </a>
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

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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
    let table = $('#customers').DataTable({
      dom: 'Bfrtip',
      pageLength: 50,
      order: [[ 8, "asc" ]]
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
} );

</script>
@endsection