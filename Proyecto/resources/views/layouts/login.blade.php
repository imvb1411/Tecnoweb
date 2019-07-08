<link rel="stylesheet" href="/css/app.css">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            {!! Form::open(['route' => ['users.login'],'method'=>'POST']) !!}
            {{Form::token()}}
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="nick" placeholder="Nick">
                    <div class="input-group-append input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            {{Form::close()}}
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<script src="/js/app.js"></script>