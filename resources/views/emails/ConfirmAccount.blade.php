<!DOCTYPE html>
<html>
<head>
	<title>Welcome email</title>
	<style type="text/css">
.confirm-btn{
    background-color: #E565F3;
    color: #FFFFFF;
    text-transform: uppercase;
    border-radius: 30px;
    height: 40px;
    width: 180px;
    font-size: 14px;
    border: 2px solid #E565F3;
}
.confirm-btn:hover{
    background-color: #FFFFFF;
    color: #E565F3;
    border: 2px solid #E565F3;
    cursor: pointer;
}
button:focus {
    box-shadow: none !important;
    outline: none !important;
}
	</style>
</head>
<body>

	
<h2>Hi <span style="text-transform: uppercase;">{{$data['user']['fname']}} {{$data['user']['lname']}}</span></h2>
<br><br><br>
<p>Greetings for choosing Mapleebooks. Its Easiest way to invoice your clients and get paid online. 

Please click the link below to confirm your email and activate your account.</p>
<center>
	<a href="{{env('APP_URL')}}/confirm_login/{{$data['token']}}"><button type="button" class="confirm-btn">Confirm Email</button></a>
</center>
<br>
<h3>Thanks <br>
Team Mapleebooks</h3>
	
</body>
</html>