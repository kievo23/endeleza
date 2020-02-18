@extends('layouts.app')

@section('title')
Endeleza: Edit Agent
@endsection

@section('content')
                   <form class="well form-horizontal" method="post" action="{{ route('agents.update', $agent->id) }}">
                        @csrf
                        @method('PUT')
                      <fieldset>
                        <div class="form-group row">
                            <label class="col-md-2 control-label">Agent Number</label>
                            <div class="col-md-7 inputGroupContainer">
                              <div class="input-group">
                                 <span class="input-group-addon">
                                     <i class="glyphicon glyphicon-home"></i>
                                 </span>
                                 <input id="addressLine1" name="phone" placeholder="+254710345130" class="form-control" required="true" value="{{$agent->agent_msisdn}}" type="text">
                              </div>
                            </div>
                         </div>
                         <div class="form-group row">
                           <input class="btn btn-primary form-control" style="float: right;" type="submit" value="Submit">
                         </div>                         
                      </fieldset>
                   </form>
@endsection