@extends('layouts.app')

@section('title')
M-Weza: Agents 
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
                    <h2>M-Weza Agents</h2>
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
                  </button>
                  <button class="btn btn-primary mt-2 mt-xl-0">Generate report</button> -->
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="row" id="proBanner">
            <div class="col-md-12 grid-margin">
              <div class="card bg-gradient-primary border-0">
                <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between flex-wrap">
                  <p class="mb-0 text-white font-weight-medium">Like what you see? Checkout our premium version for more.</p>
                  <div class="d-flex">
                    <a href="https://github.com/Urbanui/MajesticAdmin-Free-Bootstrap-Admin-Template" target="_blank" class="btn btn-outline-light mr-2">Download free version</a>
                    <a href="http://www.urbanui.com/majestic-admin-pro/template/" target="_blank" class="btn btn-outline-light mr-2 bg-gradient-danger border-0">Upgrade to Pro</a>
                    <button id="bannerClose" class="btn border-0 p-0">
                      <i class="mdi mdi-close text-white"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
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
                            <small class="mb-1 text-muted">Number of Agents</small>
                            <h5 class="mr-2 mb-0">{{count($agents)}}</h5>
                          </div>
                        </div>
                        
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
                  <p class="card-title">AGENTS</p>
                  <div class="table-responsive">
                    <table id="agents" class="table">
                      <thead>
                        <tr>
                            <th>Agent ID</th>
                            <th>Person ID</th>
                            <th>Agent MSISDN</th>
                            <th>Blocked</th>
                            <th>PIN Reset</th>
                            <th>Last PIN Change</th>
                            <th>Active</th>
                            <th>Deleted</th>
                            <th>Date Created</th>
                            <th width="280px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($agents as $agent)
                        <tr>              
                            <td>{{$agent->id}}</td>                
                            <td>{{$agent->person ? $agent->person->full_name : ''}}</td>                
                            <td>{{$agent->agent_msisdn}}</td>         
                            <td>{{$agent->blocked}}</td>                
                            <td>{{$agent->pin_reset}}</td>                
                            <td>{{$agent->last_pin_change}}</td>                
                            <td>{{$agent->active}}</td>                
                            <td>{{$agent->deleted}}</td>                
                            <td>{{$agent->date_created}}</td>
                            <td>
                              <a class="" href="{{ route('agentCustomerList', ['agentId' => $agent->id]) }}">
                                <i class="feather icon-activity"></i>
                                Customers
                              </a>
                              <a class="" href="{{ route('agents.edit', $agent->id) }}">
                                <i class="feather icon-edit"></i>
                                Edit
                              </a>
                              <!-- <form action="{{ route('agents.destroy', $agent->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <i class="feather icon-trash-2"></i>
                                <button type="submit" class="">Delete</button>
                              </form> -->
                            </td>                
                        </tr>
                        @endforeach                        
                      </tbody>
                    </table>
                    {{ $agents->links() }}
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
    $('#agents').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
} );

</script>
@endsection