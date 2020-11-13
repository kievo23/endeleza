@extends('layouts.app')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit {{$customer->person->first_name}} {{$customer->person->surname}}</h2>
            </div>
            
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <!-- <div class="container"> -->
            
            <div class="form-group">
                <label class="col-md-4 control-label">Primary Mobile Number</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="primaryMobileNumber" name="primaryMobileNumber" placeholder="2547..." class="form-control" required="true" value="{{$customer->customer_account_msisdn}}" type="text" disabled>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Account Limit</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-money"></i></span>
                    <input id="primaryMobileNumber" name="account_limit" placeholder="5000" class="form-control" required="true" value="{{$customer->account_limit}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Interest</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-home"></i>
                        </span>
                        <input id="interest" name="interest" placeholder="For example 20 for 20%" class="form-control" required="true" value="{{$customer->interest}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Blocked</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" name="blocked">
                            <option value="{{$customer->blocked}}">{!! ($customer->blocked == '1') ? "Blocked" : "Not Blocked" !!}</option>
                            <option value="1">Block</option>
                            <option value="0" >Unblock</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Active</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" name="active">
                            <option value="{{$customer->active}}">{!! ($customer->active == '1') ? "Active" : "Not Activated" !!}</option>
                            <option value="1">Active</option>
                            <option value="0">Deactivate</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Rollover</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" name="rollover">
                            <option value="{{$customer->rollover}}">{!! ($customer->rollover == '1') ? "Stopped" : "Rollover Active" !!}</option>
                            <option value="1">Stop Rollover</option>
                            <option value="0">Rollover Active</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Add Agent to Customer</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" name="agent">
                            @if($customer->agent_id && $customer->agent_id != 0)
                                <option value="{{$customer->agent_id}}">
                                    {!! isset($customer->agent_id) ? $customer->agent->person->fullName : "Not Set" !!}
                                </option>
                            @endif
                            @foreach($agents as $agent)
                                <option value="{{$agent->id}}">{{$agent->person->fullName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-8 inputGroupContainer">
                    <input class="btn btn-primary form-control" type="submit" value="Update Customer">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Twiga Activation response</label>
                <div class="col-md-8 inputGroupContainer">
                {{$customer->twiga_response}}
                </div>
            </div>

        <!-- </div> -->
   
    </form>
@endsection