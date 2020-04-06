<?php
#require ('check.php');
require ('data.php');
if (isset($_COOKIES['login_user'])){
  header("location: home.php");
}
$datab = new DataBase();
$datab->locate();
?>

<!DOCTYPE html>
<html>
<head>
        <title>Login Page</title>
</head>
<body>

<h2>Login Form</h2>

<form action="" method="post">
 	 <div class="container">
    		<label><b>Username</b></label>
    		<input type="text" placeholder="Enter Username" name="uname" required>

    		<label><b>Password</b></label>
    		<input type="password" placeholder="Enter Password" name="psw" required>
        
    		<input name="submit" type="submit" value="Login">
  	</div>
  	<div class="register">
	<a href="./register.php" target="_blank">I am not yet register.</a>
	</div>
</form>
</body>
</html>
