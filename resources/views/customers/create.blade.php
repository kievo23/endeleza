@extends('layouts.app')

@section('title')
Endeleza: Create Customer
@endsection

@section('content')

<form class="well form-horizontal" method="post" action="{{ action('CustomersController@store') }}">
    <fieldset>
        <div class="form-group row">
            {{ csrf_field() }}
            <label class="col-md-2 control-label">
                <i class="glyphicon glyphicon-user"></i>
                Person </label>
            <div class="input-group col-md-7 inputGroupContainer">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                </span>
                <select name="person" class="form-control">
                    @foreach($persons as $person)
                    <option value="{{$person->id}}">{{$person->first_name}} (ID:{{$person->id_number}})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- <div class="form-group row">
            <label class="col-md-2 control-label">
                <i class="glyphicon glyphicon-user"></i>
                Agent </label>
            <div class="input-group col-md-7 inputGroupContainer">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                </span>
                <select name="agent" class="form-control">
                    @foreach($agents as $agent)
                    <option value="{{$agent->id}}">{{$agent->person->first_name}} (ID:{{$agent->person->id_number}})</option>
                    @endforeach
                </select>
            </div>
        </div> -->

        <div class="form-group row">
            <label class="col-md-2 control-label">Customer Number</label>
            <div class="col-md-7 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-home"></i>
                    </span>
                    <input id="phone" name="phone" placeholder="For example +254710345130" class="form-control" required="true" value="" type="text">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-2 control-label">Interest</label>
            <div class="col-md-7 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-home"></i>
                    </span>
                    <input id="interest" name="interest" placeholder="For example 20 for 20%" class="form-control" required="true" value="" type="text" >
                </div>
            </div>
        </div>

        <div class="form-group row">
            <input class="btn btn-primary form-control" style="float: right;" type="submit" value="Submit">
        </div>
    </fieldset>
</form>

@endsection