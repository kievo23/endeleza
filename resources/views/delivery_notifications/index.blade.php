@extends('layouts.app')

@section('title')
Endeleza: Loan Requests
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

                </div>
              </div>
            </div>
          </div>

          <!-- <div class="row">
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

                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item"> -->

                          <!-- <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i> -->

                          <!-- <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Number of Deliveries</small>
                            <h5 class="mr-2 mb-0">{{count($delivery_notifications)}}</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item"> -->

                          <!-- <i class="mdi mdi-eye mr-3 icon-lg text-success"></i> -->

                          <!-- <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Number of Deliveries with Loans</small>
                            <h5 class="mr-2 mb-0">{{$deliveriesWithLoans}}</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item"> -->

                          <!-- <i class="mdi mdi-download mr-3 icon-lg text-warning"></i> -->

                          <!-- <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Value of all Deliveries</small>
                            <h5 class="mr-2 mb-0">KES: {{$valueOfAllDeliveries}}</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item"> -->

                          <!-- <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i> -->
                          
                          <!-- <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Value of deliveries with loans</small>
                            <h5 class="mr-2 mb-0">KES: {{$valueOfDeliveriesWithLoans}}</h5>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div> -->

          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">

                  <hr>
                  <div class="table-responsive">
                    <table id="delivery_notifications" class="table display">
                      <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Till Number</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($delivery_notifications as $notification)
                        <tr>
                            <td>{{$notification->id}}</td>
                            <td>{{$notification->customer->person->full_name }}</td>
                            <td>{{$notification->customer->customer_account_msisdn}}</td>
                            <td>{{$notification->till_number}}</td>
                            <td>{{$notification->amount}}</td>
                            <td>
                              @if($notification->status == "0")
                              <label class="label label-danger">Not Active</label>
                              @else
                              <label class="label label-success">Active</label>
                              @endif
                            </td>
                            <td>{{$notification->created_at}}</td>
                            <td>
                              <a href="{{ url('loan_requests/'.$notification->id.'/convert') }}">
                                <i class="feather icon-check-circle"></i> Convert to Loan
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
    let table = $('#delivery_notifications').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "order": [[ 6, "desc" ]]
    });

    $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();

      // Get the column API object
      var column = table.column( $(this).attr('data-column') );

      // Toggle the visibility
      column.visible( ! column.visible() );
    });
});

</script>
@endsection
