@extends('layouts.app')
@section('content')
 <div class="card stripe-connect-box">
        <div class="card-header">
            <strong class="card-title">Update Password</strong><span style="float: right;"><a href="/dashboard"><i class="fa fa-arrow-left"></i> Back</a></span>
        </div>
        <div class="card-body" style="text-align: left;background-color: #e5e4ff;">
        <form method="post" action="/updatepassword/{{auth()->user()->id}}">
            {{ csrf_field() }}
            <input type="password" name="old_password" id="old_password" class="form-control pass-filed input-border {{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="Enter Old Password" required>
            @if ($errors->has('old_password'))
                  <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                      <strong>{{ $errors->first('old_password') }}</strong>
                  </span>
            @endif
            <input type="password" name="password" id="password" class="form-control pass-filed input-border {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter New Password" required>
            @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
            @endif
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pass-filed input-border {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Confirm Password" required>
            @if ($errors->has('password_confirmation'))
              <span class="invalid-feedback" role="alert" style="text-align: center;padding-bottom: 10px">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
              </span>
            @endif
            <input type="checkbox" onclick="myFunction()" class="chk-box"> &nbsp; <b>Show Password</b>
            <br>
            <button type="submit" class="btn change-pass-btn">Submit</button>
        </form>
    </div>
  </div>
       


        <script>
function myFunction() {
    var x = document.getElementById("password");
    var y = document.getElementById("password_confirmation");
    var z = document.getElementById("old_password");    
    if (x.type === "password",y.type === "password",z.type === "password") {
        x.type = "text";
        y.type = "text";
        z.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
        z.type = "password";
    }
}
</script>
    @endsection