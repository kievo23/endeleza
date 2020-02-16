<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Register</h3>
                </div>

                <div class="panel-body">
                    <form action="/register" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                                <input type="email" name="email" class="form-control" placeholder="example@example.com">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" name="first_name" class="form-control" placeholder="First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                <input type="text" name="location" class="form-control" placeholder="Location">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                                <input type="password" name="password" class="Password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                                <input type="password" name="password_confirmation" class="Password Confirmation" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Register" class="bt btn-success pull-right">  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>