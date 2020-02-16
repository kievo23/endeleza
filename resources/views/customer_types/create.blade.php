@extends('layouts.app')

@section('content')


<table class="table table-striped">
          <tbody>
             <tr>
                <td colspan="1">

                   <form class="well form-horizontal" method="post" action="{{ action('CustomerTypesController@store') }}">
                   {{ csrf_field() }}
                      <fieldset>

                      <legend>Customer Type Information</legend>
                      
                         <div class="form-group">
                            <label class="col-md-4 control-label">Customer Type</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="customer_type" name="customer_type" placeholder="Customer Type" class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-4 control-label">Description</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="description" name="description" placeholder="Description" class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-4 control-label">Minimum Account Balance</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="minimum_account_balance" name="minimum_account_balance" placeholder="Minimum Account Balance" class="form-control" required="true" value="" type="number"></div>
                            </div>
                         </div>

                         <input class="btn btn-primary" style="float: right;" type="submit" value="Submit">
                         
                      </fieldset>
                   </form>

               

                </td>                
             </tr>
          </tbody>
       </table>


@endsection