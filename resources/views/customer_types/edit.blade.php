@extends('layouts.app')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Customer Type</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('customer_types.index') }}"> Back</a>
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
  
    <form action="{{ route('customer_types.update', $customertype->CUSTOMER_TYPE_ID) }}" method="POST">
        @csrf
        @method('PUT')   
         
            <div class="form-group">
                <label class="col-md-4 control-label">Customer Type</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="customer_type" name="customer_type" placeholder="Customer Type" class="form-control" required="true" value="{{$customertype->CUSTOMER_TYPE}}" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Description</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="description" name="description" placeholder="Description" class="form-control" required="true" value="{{$customertype->DESCRIPTION}}" type="text">
                    </div>
                </div>
            </div>
            
            <input class="btn btn-primary" style="float: right;" type="submit" value="Submit">
   
    </form>

@endsection