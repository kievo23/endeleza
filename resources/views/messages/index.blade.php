@extends('layouts.app')

@section('title')
M-Weza: SMS 
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
                  <p class="card-title">Create SMS</p>
                  <form class="form-horizontal" method="post" action="{{ action('SMSController@send') }}" id="sendForm">
                   {{ csrf_field() }}                   
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <textarea rows="5" cols="5" class="form-control" placeholder="Am a lumberjack, I work all day, sleep all night and thats okay" name="sms"></textarea>
                            <div id="the-count">
                              <span id="current">0</span>
                              <span id="maximum">/ 160</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select name="category" class="form-control form-control-primary" id="category">
                                <option value="" selected>-- Select Category--</option>
                                <option value="all">All Customers (Active and Inactive)</option>
                                <option value="active">Active Customers</option>
                                <option value="customers_with_loans">Customers With Loans</option>
                                <option value="select_customers">Select Customers</option>
                                <option value="custom">Enter Phone Numbers</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="customers" >
                        <div class="col-sm-12">
                            <select name="customers[]" data-dropup-auto="false" class="form-control hidden dropdown" data-live-search="true" multiple id="customerSelect">
                                <option value="">-- Select Customers--</option>
                                @foreach($customers as $customer)
                                  <option value="{{$customer->customer_account_msisdn}}">{{$customer->person->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input class="form-control" placeholder="0710345130,0723212121" name="phones" id="phones" type="hidden"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="button" value="Send" class="btn btn-primary form-control" onclick="javascript: validate()">
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

    $('#customers').hide( "slow");

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

    $('textarea').keyup(function() {    
      var characterCount = $(this).val().length,
          current = $('#current'),
          maximum = $('#maximum'),
          theCount = $('#the-count');
        
      current.text(characterCount);    
      
      /*This isn't entirely necessary, just playin around*/
      if (characterCount < 70) {
        current.css('color', '#666');
      }
      if (characterCount > 70 && characterCount < 90) {
        current.css('color', '#6d5555');
      }
      if (characterCount > 90 && characterCount < 100) {
        current.css('color', '#793535');
      }
      if (characterCount > 100 && characterCount < 120) {
        current.css('color', '#841c1c');
      }
      if (characterCount > 120 && characterCount < 139) {
        current.css('color', '#8f0001');
      }
      
      if (characterCount >= 140) {
        maximum.css('color', '#8f0001');
        current.css('color', '#8f0001');
        theCount.css('font-weight','bold');
      } else {
        maximum.css('color','#666');
        theCount.css('font-weight','normal');
      }
      
          
    });
});

function validate(){
  swal({
    title: "Are you sure?",
    text: "Once Sent, the text message goes to the users and can not be undone",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("You have successfully queued your sms for sending", {
        icon: "success",
      });
      setTimeout(function(){ 
        $('#sendForm').submit();
      }, 1000);
      
    } else {
      swal("Okay, You have stopped the sending of the text message successfully");
    }
  });
}

</script>
@endsection