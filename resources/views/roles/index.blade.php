@extends('layouts.app')

@section('title')
Endeleza: Roles
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
              <h2>List of roles</h2>
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
            <button class="btn btn-warning mt-2 mt-xl-0"><a href="{{ route('roles.create') }}">Create Role</a></button>
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
                  
                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <!-- <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i> -->
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Number of Roles</small>
                      <h5 class="mr-2 mb-0">{{count($roles)}}</h5>
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
            <p class="card-title">ROLES</p>
            <div class="table-responsive">
              <table id="customers" class="table">
                <thead>
                  <tr>
                    <th>Role ID</th>
                    <th>Role Name</th>
                    <th>Guard Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($roles as $role)
                  <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->guard_name}}</td>
                    <td>
                      <a href="{{ url('roles/'.$role->id.'/edit') }}">
                        <i class="feather icon-edit"></i> Edit
                      </a>

                      <form method="POST" action="/roles/{{$role->id}}">
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