@extends('layouts.app')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Setting</h2>
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
  
    <form action="{{ action('SettingsController@update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
         
            <div class="form-group">
                <label class="col-md-4 control-label">Name</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="name" name="name" placeholder="Customer Type" class="form-control" required="true" value="{{$data->name}}" type="text" disabled>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Description</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="description" name="description" placeholder="Description" class="form-control" required="true" value="{{$data->description}}" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Value</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="description" name="value" placeholder="Value" class="form-control" required="true" value="{{$data->value}}" type="text">
                    </div>
                </div>
            </div>
            
            <input class="btn btn-primary" style="float: right;" type="submit" value="Update">
   
    </form>

@endsection