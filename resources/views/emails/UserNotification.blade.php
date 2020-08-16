<!DOCTYPE html>
<html>
<head>
	<title>New User</title>
</head>
<body>

	
<h2>Hi <span style="text-transform: uppercase;">Admin,</span></h2>
<br><br>
<p>
New user {{$user->fname}} {{$user->lname}} has signed up for maple labs.

<br><br>
<strong>First Name</strong> : {{$user->fname}}
<br>
<strong>Last Name</strong> : {{$user->lname}}
<br>
<strong>Email</strong> : {{$user->email}}
 </p>
<br>
<h3>Thanks <br>
Mapleebooks</h3>
	
</body>
</html>