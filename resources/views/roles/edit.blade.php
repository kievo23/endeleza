@extends('layouts.app')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
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
  
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <!-- <div class="container"> -->
            
            <div class="form-group">
                <label class="col-md-4 control-label">Role Name</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="role_name" name="role_name" placeholder="" class="form-control" required="true" value="{{$role->name}}" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Guard Name</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" name="guard_name">
                            <option value="{{$role->guard_name}}">{{$role->guard_name}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-8 inputGroupContainer">
                    <input class="btn btn-primary form-control" type="submit" value="Update">
                </div>
            </div>

        <!-- </div> -->
   
    </form>
@endsection