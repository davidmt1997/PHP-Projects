<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	<p>Welcome Home</p>
	<form action="" method="post" enctype="multipart/form-data">
		Which file? <input name = "userfile" type = "file">
		<input name = "Submit" type = "submit"><br>
		<input name="Logout" type="submit" value="Log out">
		<div class = "gallery.php">
			<a href="./gallery.php" target="_blank">Go to gallery.</a>
		</div>
	</form>
	<?php 
		if(isset($_POST['Logout'])){
			setcookie("login_user", "", time() - 3600);
			header("location: login.php");
		}
		
		if(isset($_POST['Submit']) && $_FILES['userfile']['size'] > 0){
	
			$fileName = $_FILES['userfile']['name'];
			$tmpName  = $_FILES['userfile']['tmp_name'];
			$fileType = $_FILES['userfile']['type'];
			#$content  = $_FILES['userfile']['pic'];
			$file_open = fopen($tmpName, "r");
    		$content = fread($file_open, fileSize($tmpName));
			
			$db = new PDO('mysql:host=localhost;dbname=davidmt1997', 'randy', '');	
			$query = "INSERT INTO pics (filename, type, pic)  VALUES (?, ?,?)";
           
            $stmt = $db->prepare($query);
            $stmt->execute(array($fileName,$fileType, $content));

            #echo $content;
		}
		else{
			echo "error";
		}
	 ?>
</body>
</html>