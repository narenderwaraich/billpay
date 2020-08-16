<!DOCTYPE html>
<html>
<head>
	<title>Password Reset</title>
<style>
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
<h2>Hello!</h2>
<h4>You are receiving this email because we received a password reset request for your account.</h4>
<center>
	<a href="{{env('APP_URL')}}/Password_Reset/{{$data['token']}}"><button type="button" class="confirm-btn"> New Password</button></a>
</center>
	<h4>If you did not request a password reset, no further action is required.</h4>
<h3>Regards,<br>
Laravel
</h3>

	
</body>
</html>