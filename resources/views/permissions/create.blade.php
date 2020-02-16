@extends('layouts.app')

@section('content')

<form class="well form-horizontal" method="post" action="{{ action('PermissionsController@store') }}">
    <fieldset>
        <div class="form-group row">
            {{ csrf_field() }}
            <label class="col-md-2 control-label">Permission Name</label>
            <div class="col-md-7 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-home"></i>
                    </span>
                    <input id="permission_name" name="permission_name" placeholder="Enter the name of the permission, for example 'edit customer details' or 'add agent'" class="form-control" required="true" value="" type="text">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-2 control-label">
                <i class="glyphicon glyphicon-user"></i>
                Guard Name </label>
            <div class="input-group col-md-7 inputGroupContainer">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                </span>
                <select name="guard_name" class="form-control">
                    <option value="web">web</option>
                    <!-- <option value=""></option> -->
                </select>
            </div>
        </div>

        <div class="form-group row">
            <input class="btn btn-primary form-control" style="float: right;" type="submit" value="Submit">
        </div>
    </fieldset>
</form>

@endsection