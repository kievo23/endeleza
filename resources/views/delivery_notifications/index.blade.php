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
                    <h2>Welcome back, {{$title}}</h2>
                    <p class="mb-md-0">Your analytics dashboard</p>
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
                      @if($delivery_notifications)
                        @foreach($delivery_notifications as $notification)
                        <tr>
                            <td>{{$notification->id}}</td>
                            <td>{{$notification->customer->person->full_name }}</td>
                            <td>{{$notification->customer->customer_account_msisdn}}</td>
                            <td>{{$notification->till_number}}</td>
                            <td>{{$notification->amount}}</td>
                            <td>
                              @if($notification->status == "0")
                              <label class="label label-danger">Denied</label>
                              @elseif($notification->status == "1")
                              <label class="label label-success">Active</label>
                              @else
                              <label class="label label-info">Not Attended</label>
                              @endif
                            </td>
                            <td>{{$notification->created_at}}</td>
                            <td>
                              @if($notification->status == null)
                                <a class="dropdown-item" href="#"
                                  onclick="javascript: validate({{$notification->id}})">
                                      <i class="feather icon-check-circle"></i> Convert to loan
                                </a>
                                <form id="convert-intoloan{{$notification->id}}" action="{{ url('loan_request/'.$notification->id.'/convert') }}" method="POST">
                                    @csrf
                                    <input type="button" value="" class="btn btn-link p-0 m-0 d-inline align-baseline">
                                      <input type="hidden" value="" name="status" id="convert{{$notification->id}}">
                                    </input>
                                </form>
                              @endif
                            </td> 
                        </tr>
                        @endforeach
                      @endif
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>


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

function validate(id){
  swal({
    title: "Are you sure?",
    text: "You want to convert this loan request into a loan??",
    icon: "warning",
    buttons: {
      cancel: "close",
      ok: "convert",
      denay: "denay",
    },
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      console.log(willDelete);
      
      if(willDelete == "ok"){
          swal("You have successfully converted a loan request into a loan", {
          icon: "success",
        });
        
        setTimeout(function(){ 
          $('#convert-intoloan'+id).submit();
          //document.getElementById('convert-intoloan').submit();
        }, 1000);

        $("#convert"+id).val("give");
      } else{
        swal("You have successfully rejected the loan request", {
          icon: "warning",
        });

        setTimeout(function(){ 
          $('#convert-intoloan'+id).submit();
          //document.getElementById('convert-intoloan').submit();
        }, 1000);

        $("#convert"+id).val("denay");
      }     
    } else {
      //swal("Okay, You have stopped the conversion of a request successfully");
    }
  });
}

</script>
@endsection
