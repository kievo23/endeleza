@extends('layouts.app')

@section('title')
M-Weza: Permissions
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
              <h2>List of permissions</h2>
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
            <button class="btn btn-warning mt-2 mt-xl-0"><a href="{{ route('permissions.create') }}">Create Permission</a></button>
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
              <!-- <li class="nav-item">
                      <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Sales</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="purchases-tab" data-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Purchases</a>
                    </li> -->
            </ul>
            <div class="tab-content py-0 px-0">
              <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <div class="d-flex flex-wrap justify-content-xl-between">
                  <!-- <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-calendar-heart icon-lg mr-3 text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Start date</small>
                            <div class="dropdown">
                              <a class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium" href="#" role="button" id="dropdownMenuLinkA" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="mb-0 d-inline-block">26 Jul 2018</h5>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkA">
                                <a class="dropdown-item" href="#">12 Aug 2018</a>
                                <a class="dropdown-item" href="#">22 Sep 2018</a>
                                <a class="dropdown-item" href="#">21 Oct 2018</a>
                              </div>
                            </div>
                          </div>
                        </div> -->
                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Number of Permissions</small>
                      <h5 class="mr-2 mb-0">{{count($permissions)}}</h5>
                    </div>
                  </div>
                  <!-- <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-eye mr-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Number of loans given</small>
                            <h5 class="mr-2 mb-0"></h5>
                          </div>
                        </div> -->
                  <!-- <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item"> -->
                  <!-- <i class="mdi mdi-download mr-3 icon-lg text-warning"></i> -->
                  <!-- <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Value of loans given</small>
                            <h5 class="mr-2 mb-0">Ksh. 22,533,783</h5>
                          </div>
                        </div> -->
                  <!-- <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item"> -->
                  <!-- <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i> -->
                  <!-- <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Value of loans outstanding</small>
                            <h5 class="mr-2 mb-0">Ksh. 10,497,843</h5>
                          </div>
                        </div> -->
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Cash deposits</p>
                  <p class="mb-4">To start a blog, think of a topic about and first brainstorm party is ways to write details</p>
                  <div id="cash-deposits-chart-legend" class="d-flex justify-content-center pt-3"></div>
                  <canvas id="cash-deposits-chart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Total sales</p>
                  <h1>$ 28835</h1>
                  <h4>Gross sales over the years</h4>
                  <p class="text-muted">Today, many people rely on computers to do homework, work, and create or store useful information. Therefore, it is important </p>
                  <div id="total-sales-chart-legend"></div>                  
                </div>
                <canvas id="total-sales-chart"></canvas>
              </div>
            </div>
          </div> -->
    <div class="row">
      <div class="col-md-12 stretch-card">
        <div class="card">
          <div class="card-body">
            <!-- <button class="btn btn-warning mt-2 mt-xl-0"><a href="">Create Customer</a></button> -->
            <p class="card-title">PERMISSIONS</p>
            <div class="table-responsive">
              <table id="customers" class="table">
                <thead>
                  <tr>
                    <th>Permission ID</th>
                    <th>Permission Name</th>
                    <th>Guard Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($permissions as $permission)
                  <tr>
                    <td>{{$permission->id}}</td>
                    <td>{{$permission->name}}</td>
                    <td>{{$permission->guard_name}}</td>
                    <td>
                      <a href="{{ url('permissions/'.$permission->id.'/edit') }}">
                        <i class="feather icon-edit"></i> Edit
                      </a>

                      <form method="POST" action="/permissions/{{$permission->id}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="feather icon-delete"></i>Delete</button>
                      </form>
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
    $(document).ready(function() {
      $('#customers').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
  </script>
  @endsection