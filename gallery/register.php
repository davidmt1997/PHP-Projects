<?php
include ('data.php');
$datab = new DataBase();
$datab->create();
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Register Page</title>
</head>
<body>

<h2>Register Form</h2>

<form action="" method="post">
  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
    <input name="reg" type="submit" value="Register">
  </div>
</form>

</body>
</html>

