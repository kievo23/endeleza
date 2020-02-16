@extends('layouts.app')

@section('assets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz"
        crossorigin="anonymous">
@endsection
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard') }}"> Back</a>
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
  
    <form action="{{ action('UsersController@update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
         
            <div class="form-group">
                <label class="col-md-4 control-label">Email</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="name" name="email" placeholder="User Email" class="form-control" required="true" value="{{$data->email}}" type="text" disabled>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Active</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" name="status" required>
                            @if(isset($data->active))
                                <option value="{{$data->active}}">{{ $data->active == 1 ? "Activated" : "Not Active" }}</option>
                            @else
                            <option value="">-- Select Status --</option>
                            @endif
                            
                            <option value="1">Activate</option>
                            <option value="0">Deactivate</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Roles</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" name="role" required>
                            @if(isset($data->roles[0]))
                                <option value="{{$data->roles[0]->name}}">{{$data->roles[0]->name}}</option>
                            @else
                            <option value="">-- Select Role --</option>
                            @endif
                            
                            @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Permissions</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group row"> 
                        <ul class="ks-cboxtags">                     
                            @foreach($permissions as $p)
                            <li>
                                <input type="checkbox" <?php if (in_array($p, $userPerms)) echo 'checked="checked"'; ?> id={{$p}} name="permissions[]" value='{{$p}}' >
                                <label class="form-check-label" for={{$p}}>{{$p}}</label>
                            </li> 
                            @endforeach 
                        </ul>                       
                    </div>
                </div>
            </div>
            <input class="btn btn-primary" style="float: right;" type="submit" value="Update">
   
    </form>

@endsection