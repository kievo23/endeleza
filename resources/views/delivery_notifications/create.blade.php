@extends('layouts.app')

@section('title')
Endeleza: SMS 
@endsection

@section('assets')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

@endsection

@section('content')

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Create Loan Request</p>
                  <form class="form-horizontal" method="post" action="{{ action('DeliveryNotificationsController@store') }}" id="sendForm">
                   {{ csrf_field() }}                   
                   <legend>Loan Information</legend>

                    <div class="form-group row" id="customers" >
                        <label class="col-md-4 control-label">Customer</label>
                        <div class="col-sm-12">
                            <select name="customer" data-dropup-auto="false" class="form-control hidden dropdown" data-live-search="true" id="customerSelect" required>
                                <option value="" selected>-- Select Customers--</option>
                                @foreach($customers as $customer)
                                  <option value="{{$customer->customer_account_msisdn}}">{{$customer->person->full_name}} Phone({{$customer->customer_account_msisdn}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="amount" >
                        <label class="col-md-4 control-label">Amount</label>
                        <div class="col-sm-12">
                        <input id="amount" name="amount" placeholder="Amount e.g. 55000" class="form-control" required="true" value="" type="text">
                        </div>
                    </div>
                    <div class="form-group row" id="till" >
                        <label class="col-md-4 control-label">Till Number</label>
                        <div class="col-sm-12">
                        <input id="till" name="till" placeholder="Till Number" class="form-control" required="true" value="" type="text">
                        </div>
                    </div>
                    <div class="form-group row" id="phone" >
                        <label class="col-md-4 control-label">Customer's Phone No</label>
                        <div class="col-sm-12">
                        <input id="phone" name="phone" placeholder="Customer Phone" class="form-control" required="true" value="" type="text">
                        </div>
                    </div>                   
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="submit" value="Create Loan Request" class="btn btn-primary form-control" >
                              <i class="icofont icofont-user-alt-3"></i>
                            </input>
                        </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

@endsection

@section('js')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>

<script>

$(document).ready( function () {

    //$('#customers').hide( "slow");

    $('#customerSelect').selectpicker({
        dropupAuto: false
    });

    $('#category').change(function() {
      // Check input( $( this ).val() ) for validity here
      //alert($(this).val());
      if($(this).val() == "custom"){
        $('#sendForm').find('#phones').attr("type","text");
      }else{
        $('#sendForm').find('#phones').attr("type","hidden");
      }

      if($(this).val() == "select_customers"){
        $('#customers').show("slow");
      }else{
        $('#customers').hide("slow");
      }
    });
});

// function validate(){
//   swal({
//     title: "Are you sure?",
//     text: "Once Sent, the text message goes to the users and can not be undone",
//     icon: "warning",
//     buttons: true,
//     dangerMode: true,
//   })
//   .then((willDelete) => {
//     if (willDelete) {
//       swal("You have successfully queued your sms for sending", {
//         icon: "success",
//       });
//       setTimeout(function(){ 
//         $('#sendForm').submit();
//       }, 1000);
      
//     } else {
//       swal("Okay, You have stopped the sending of the text message successfully");
//     }
//   });
// }

</script>
@endsection