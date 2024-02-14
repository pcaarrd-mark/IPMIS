
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IPMIS</title>
  <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}"  type='image/x-icon'>
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('admintemplate/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admintemplate/dist/css/adminlte.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/login_bg.css') }}">
</head>
<style>
.form-control{
  border-radius:30px;
  background-color: #ffffff;
  opacity: 0.8;
}

body 
{
    font-family: 'Roboto';font-size: 14px;
}

.input-group-text
{
  border-radius:30px;
}

html, body {
  
  margin
  : 0;
    
  padding
  : 0;
  }
  .background {
    
  position
  :
   absolute
  ;
    
  display
  :
   block
  ;
    
  top
  : 0;
    
  left
  : 0;
    
  z-index
  : 0;
  }
</style>    
<body class="hold-transition login-page">
   
<div id="particles-js"></div><script src="{{ asset('js/particles.js') }}"></script>
  
<div class="login-box" style="width:490px;">
  <!-- /.login-logo -->
 
    <div class="card-header text-center" style="border:none;">
      <div class="login-logo">     
          <img src="{{ asset('img/pcaarrd.png') }}" width="18%"/>                                  
          <p style="color:white;font-weight: bold;margin-bottom: 0px;"><small><strong>DOST-PCAARRD</strong></small></p>
          <h1 style="font-weight: bold;color: #a5d5f5;margin-bottom: 0px;text-shadow: 1px 1px 3px rgb(0,0,0,0.3)">
              Integrated Project Management Information System
           <span style="font-weight: bold;color: #fff;text-shadow: 1px 1px 3px rgb(0,0,0,0.3);">
           <small><strong></strong></small>
          </span></h1>
       </div>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('login') }}">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name='username' id='username' placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name='password' id='password' placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="">
              <input type="checkbox" id="remember">
              <label for="remember" class="text-white">
               &nbsp;Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" style="background-color:#2684c3;" class="btn btn-primary btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a class="text-white" href="#">Forgot password?</a>
      </p>
      <br/>

      <!-- Plans & Accomplishments Description -->
      <p>
        {{-- <a class="text-white" href="#"><strong>The Plans & Accomplishments System</strong> lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book.</a> --}}
      </p>
    </div>
    <!-- /.card-body -->

  <!-- /.card -->
</div>
<!-- /.login-box -->
<footer class="text-white">
Copyright © 2023. PCAARRD IPMIS. All Rights Reserved.
</footer>

<!-- jQuery -->
<script src="{{ asset('admintemplate/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admintemplate/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admintemplate/dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('js/particles-param.js') }}"></script>
</body>
</html>
