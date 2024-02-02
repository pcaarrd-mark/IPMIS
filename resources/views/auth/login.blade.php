
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

body{
    background-color:#043e60!important;
    background-image: url('{{ asset("img/network.jpg") }}');
    background-repeat: no-repeat;
    background-size: 100% 100%;
}

</style>    
<body class="hold-transition login-page">
   
<canvas id="canvas" class="background"></canvas>

<script src="{{ asset('js/particles.min.js') }}"></script>
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
<script>
var cnvs = document.getElementById("canvas");
cnvs.width = window.innerWidth;
cnvs.height = window.innerHeight;
var c = cnvs.getContext('2d');
var dots_num = 70;
var r = 1;
var mx, my;
var mouse_ol = 150;
var dots_ol = 170;
var max_speed = 0.2;
var max_ms_opac = 1;
var max_dots_opac = 1;
var uni_divs = 30;  // ensures that dots are evenly spread across the canvas initially

window.addEventListener('mousemove', updtMouse);

var dots = new Array();

var Dot = function(x, y, dx, dy) {
  this.x = x;
  this.y = y;
  this.dx = dx;
  this.dy = dy;
}

function updtMouse(e) {
  mx = e.x;
  my = e.y;
  console.log(mx + " " + my);
}

function init() {

  for(let i=0; i<dots_num; i++) {
    let x = Math.floor((Math.random()*innerWidth/uni_divs)+(parseInt(i/(dots_num/uni_divs))*(innerWidth/uni_divs)));
    let y = Math.floor(Math.random()*innerHeight);
    let dx = Math.random()*max_speed+0.1;
    let dy = Math.random()*max_speed+0.1;
    if(i%2==0) {
      dx*=-1;
      dy*=-1;
    }
    let temp = new Dot(x, y, dx, dy);
    dots.push(temp);
  }

}

function update() {

  c.clearRect(0, 0, innerWidth, innerHeight);

  for(let i=0; i<dots_num; i++) {

    let dy = dots[i].dy;
    let dx = dots[i].dx;

    dots[i].x += dx;
    dots[i].y += dy;

    // rebounce form walls
    if(dots[i].x>innerWidth || dots[i].x<0) {
      dots[i].dx *= -1;
    }
    if(dots[i].y>innerHeight || dots[i].y<0) {
      dots[i].dy *= -1;
    }

    let x = dots[i].x;
    let y = dots[i].y;


    // draw updated circle

    c.beginPath();
    c.arc(x, y, r, 10, Math.PI*2, true);
    c.stroke();


    // draw its line to mouse
    let d = Math.sqrt((x-mx)*(x-mx)+(y-my)*(y-my));
    if(d<mouse_ol) {
      c.strokeStyle = `rgba(100, 180, 255, ${max_ms_opac*(mouse_ol-d)/mouse_ol})`;
      c.lineWidth = 2;
      c.beginPath();
      c.moveTo(x, y);
      c.lineTo(mx, my);
      c.stroke();
    }

    // draw lines with other dots
    // for(let i=0; i<dots_num; i++) {
      for(let j=i+1; j<dots_num; j++) {
        let x1 = dots[j].x;
        let y1 = dots[j].y;
        let d = Math.sqrt((x1-x)*(x1-x)+(y1-y)*(y1-y));
        if(d<dots_ol) {
          c.strokeStyle = `rgba(157, 210, 255, ${max_dots_opac*(dots_ol-d)/dots_ol})`;
          c.lineWidth = 1;
          c.beginPath();
          c.moveTo(x1, y1);
          c.lineTo(x, y);
          c.stroke();
        // }
      }
    }
  }
  requestAnimationFrame(update);
}

init();

requestAnimationFrame(update);
</script>
</body>
</html>
