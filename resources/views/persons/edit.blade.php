@extends('layouts.app')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Person</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('persons.index') }}"> Back</a>
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
  
    <form action="{{ route('persons.update', $person->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <!-- <div class="container"> -->
            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $person->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail">{{ $person->detail }}</textarea>
                </div>
            </div> -->
            
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div> -->

            <div class="form-group">
                <label class="col-md-4 control-label">Surname</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="surname" name="surname" placeholder="Surname" class="form-control" required="true" value="{{$person->surname}}" type="text">
                    </div>
                </div>
            </div>
            <!-- <div class="form-group">
                    <strong>Surname:</strong>
                    <input type="text" name="surname" value="{{ $person->surname }}" class="form-control" placeholder="Surname">
            </div> -->
            <div class="form-group">
                <label class="col-md-4 control-label">First Name</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="firstName" name="first_name" placeholder="First Name" class="form-control" required="true" value="{{$person->first_name}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Other Names</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="otherNames" name="other_names" placeholder="Other Names" class="form-control" required="true" value="{{$person->other_names}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Gender</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" name="gender">
                            <option value="{{$person->gender}}">{{ $person->gender == "M" ? "Male" : "Female"}}</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Date of Birth</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="dateOfBirth" name="date_of_birth" placeholder="yyyy-mm-dd" class="form-control" required="true" value="{{$person->date_of_birth}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">ID Number</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="idNumber" name="id_number" placeholder="ID Number" class="form-control" required="true" value="{{$person->id_number}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Primary Mobile Number</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="primaryMobileNumber" name="primary_msisdn" placeholder="2547..." class="form-control" required="true" value="{{$person->primary_msisdn}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Alternate Mobile Number</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="alternateMobileNumber" name="alternate_msisdn" placeholder="2547..." class="form-control" required="true" value="{{$person->alternate_msisdn}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Postal Address</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postalAddress" name="postal_address" placeholder="Postal Address Number" class="form-control" required="true" value="{{$person->postal_address}}" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Physical Location</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="physicalLocation" name="physical_location" placeholder="Physical Location" class="form-control" required="true" value="{{$person->physical_location}}" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Business Name</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span><input id="biz" name="business_name" placeholder="Business Name" class="form-control" value="{{$person->business_name}}" type="text">
                    </div>
                </div>
            </div>

            <input class="btn btn-primary" style="float: right;" type="submit" value="Submit">

        <!-- </div> -->
   
    </form>
@endsection