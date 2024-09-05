<?php
@include('vendor/autoload.php');
use App\MyPackage\alert;
if(!isset($_SESSION)) session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css"
    rel="stylesheet"
    />
    <title>LOGIN</title>

    
  </head>
  <body>
    <form>
      <form>
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
          <input type="email" id="form2Example1" class="form-control" />
          <label class="form-label" for="form2Example1">Email address</label>
        </div>
      
        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
          <input type="password" id="form2Example2" class="form-control" />
          <label class="form-label" for="form2Example2">Password</label>
        </div>
      
        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">
          <div class="col d-flex justify-content-center">
            <!-- Checkbox -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="form2Example34" checked />
              <label class="form-check-label" for="form2Example34"> Remember me </label>
            </div>
          </div>
      
          <div class="col">
            <!-- Simple link -->
            <a href="#!">Forgot password?</a>
          </div>
        </div>
      
        <!-- Submit button -->
        <button data-mdb-ripple-init type="button" class="btn btn-primary btn-block mb-4">Sign in</button>
      
        <!-- Register buttons -->
        <div class="text-center">
          <p>Not a member? <a href="#!">Register</a></p>
          <p>or sign up with:</p>
          <button  data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
            <i class="fab fa-facebook-f"></i>
          </button>
      
          <a  data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1" href="{{ route('login-by-google') }}">
            <i class="fab fa-google"></i>
          </a>
      
          <button  data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
            <i class="fab fa-twitter"></i>
          </button>
      
          <button  data-mdb-ripple-init type="button" class="btn btn-secondary btn-floating mx-1">
            <i class="fab fa-github"></i>
          </button>
        </div>
      </form>
  </body>
</html>
