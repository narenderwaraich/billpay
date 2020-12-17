@extends('layouts.homeApp')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <section style="width: 100%;height: auto;max-width: 650px;min-width: 290px;text-align: center;margin: auto;">
        <center><img src="" alt="Logo" class="home-logo"></center>
        <div class="home-title">Online Bill</div>
        <div class="home-title-2">Go Paperless Invoices</div>
        <hr>
        <div class="form-top-title">Create Password</div>
        <div class="form-style shadow-lg">
          <div class="login-title">New Password</div>
            <form action="/Password_Reset/{{$user->token}}" method="post" autocomplete="off">
                {{ csrf_field() }}
                <div class="email-show">
                    {{$user->email}}
                </div>
                <div class="form-group">
                     <input type="password" name="password" id="password" class="form-control form-input {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter New Password" required autocomplete="off">
                     @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                      @endif
                </div>
                <div class="form-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-input {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Confirm Password" autocomplete="off" required>
                    @if ($errors->has('password_confirmation'))
                      <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                      </span>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" onclick="myFunction()"> Show Password
                    </label>
                </div><br>
                <button type="submit" class="btn form-btn btn-lg btn-block">
                Submit</button>
                <br><br>
                <div style="float: right;">Don't have account ? <a href="/SignUp" style="color: #0d47a1">Sign Up Here</a></div> 
            </form>
      </div>
    </div>
  </div> <!-- row end -->
</div> <!-- end container -->
  <script>
function myFunction() {
    var x = document.getElementById("password");
    var y = document.getElementById("password_confirmation");
    if (x.type === "password",y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}
</script>
   @endsection
