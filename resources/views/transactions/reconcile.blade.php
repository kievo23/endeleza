@extends('layouts.app')
{{-- Web site Title --}}
@section('title')
@parent
Orphan Transaction Reconciliation.
@stop

@section('assets')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

@endsection

@section('content')
<br>
<h3 class="page-title">

</h3>
<!-- END PAGE HEADER-->

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="card blue">
            <div class="card-header row">
                <div class="caption">
                    <i class="fa fa-wrench"></i>
                    Are you sure you want to offset one of the customers with this loan from {{$transaction->payer_names}} of amount
                    {{$transaction->transaction_amount}} that was paid on {{$transaction->created_at}}
                </div>
                <div class="tools">
                    
                </div>
            </div>

            <div class="card-block form">
                <!-- BEGIN FORM-->
                <form method="POST" action="{{ route('transactions.store') }}" class="form-horizontal">
                    <div class="form-group row" id="customers" >
                        <label for="customerSelect">
                            <div class="caption">
                                <i class="fa fa-users"></i>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <select name="customer" data-dropup-auto="false" class="form-control hidden dropdown" data-live-search="true" id="customerSelect">
                                <option value="">-- Select Customers--</option>
                                @foreach($customers as $customer)
                                  <option value="{{$customer->customer_account_msisdn}}">{{$customer->person->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input name="_token" value="{{ csrf_token() }}" type="hidden">

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-4">
                                <button type="button" class="btn" onClick="location.href='{{ \URL::previous() }}'">Cancel</button>
                                <button type="submit" class="btn btn-success pull-right">Reconcile</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>

@endsection

@section('js')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>

    <script>

        $(document).ready( function () {

            $('#customerSelect').selectpicker({
                dropupAuto: false
            });
        });
    </script>
@endsection