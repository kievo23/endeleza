@extends('layouts.app')
{{-- Web site Title --}}
@section('title')
@parent
Transaction Query
@stop

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
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-briefcase"></i>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                    <a href="#portlet-config" data-toggle="modal" class="config">
                    </a>
                    <a href="javascript:;" class="reload">
                    </a>
                    <a href="javascript:;" class="remove">
                    </a>
                </div>
            </div>

            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form method="POST" action="{{ url('transactionQuery') }}" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Mpesa Code</label>
                            <div class="col-md-4">
                                <input type="text" value="" name="mpesaCode" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>

                    <input name="_token" value="{{ csrf_token() }}" type="hidden">

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-4">
                                <button type="button" class="btn" onClick="location.href='{{ \URL::previous() }}'">Cancel</button>
                                <button type="submit" class="btn btn-success pull-right">Submit</button>
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