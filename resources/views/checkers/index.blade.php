@extends('layouts.app')

@section('title')
Endeleza: Checkers
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
                    <h2>M-Weza Checks</h2>
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
                            <small class="mb-1 text-muted">Number of Checkers</small>
                            <h5 class="mr-2 mb-0">{{count($checkers)}}</h5>
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
                  <p class="card-title">Checks</p>
                  <div class="table-responsive">
                    <table id="checkers" class="table">
                      <thead>
                        <tr>
                            <th>Id</th>
                            <th>User</th>
                            <th>Model</th>
                            <th>Operation</th>                            
                            <th>Changes</th>
                            <th>Is Approved</th>
                            <th>Approved By</th>
                            <th>Approval date</th>
                            <th>Date Created</th>
                            <th width="280px">Approve</th>
                            <th width="280px">Drop</th>
                            <th>Values</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($checkers as $checker)
                        <tr>              
                            <td>{{$checker->id}}</td>                
                            <td>{{$checker->user ? $checker->user->email : ''}}</td>                
                            <td>{{$checker->model}}</td>         
                            <td>{{$checker->operation}}</td>                                
                            <td>{{$checker->changes}}</td>                
                            <td>{{$checker->is_approved}}</td>  
                            <td>{{$checker->approver->email}}</td>              
                            <td>{{$checker->approved_date}}</td>                
                            <td>{{$checker->created_at}}</td>
                            <td class="p-0">
                              @if(((auth()->user()->can('checker') && (auth()->user()->id != $checker->user_id)) || auth()->user()->hasRole('admin')) && ($checker->is_approved == 'n'))                        
                                    <form action="{{ route('checker.approve', $checker->id) }}" method="POST" class="col-sm-5 approveForm" id={{"approve".$checker->id}}>
                                        @csrf
                                        @method('POST')
                                            <button type="button" class="approveSubmit btn btn-link">
                                                <i class="feather icon-check-square"></i>Approve
                                            </button>
                                    </form>
                              @endif
                          </td>
                          <td class="p-0">
                            @if(((auth()->user()->can('checker') && (auth()->user()->id != $checker->user_id)) || auth()->user()->hasRole('admin')) && ($checker->is_approved == 'n'))
                                    <form action="{{ route('checker.drop', $checker->id) }}" method="POST" class="col-sm-5 dropForm" >
                                        @csrf
                                        @method('POST')
                                            <button type="button" class="dropSubmit btn btn-link">
                                                <i class="feather icon-trash-2"></i>Drop
                                            </button>
                                    </form>
                            @endif
                            </td>
                            <td>{{$checker->values}}</td>                
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

window.addEventListener('wheel', { passive: false });

$(document).ready( function () {
    $('#checkers').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    $(".dropSubmit").on('click',function(e) {
        validate(this.form);
    });

    $(".approveSubmit").on('click',function(e) {
        //alert(this.form.id);
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