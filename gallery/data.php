<?php
class DataBase{
    private $db;
    function __construct(){
        global $db;
        include('connect.php');
        #$db = new PDO('mysql:host=localhost;dbname=davidmt1997', 'randy', '');  

    }
    function locate(){
        global $db;
        session_start(); 
        $error=''; 
    	if (isset($_POST['submit'])) {
        	if (empty($_POST['uname']) || empty($_POST['psw'])) {
                $error = "Username or Password is invalid";
            }else{
            	$name=$_POST['uname'];
            	$pass=$_POST['psw'];
            	$pass = md5($pass);
            	
           		$query = "SELECT * FROM users WHERE username=? AND password=?;";
                
                $result = $db->prepare($query);
                if($result->execute(array($name,$pass))){
                	$rows = $result->fetch();
                	if ($rows > 0) {
                       	setcookie('login_user', $username);
                        setcookie('login_cookie',$session);     
        	            header("location: home.php"); 
                    }else{
                       		$error = "username or password is invalid";
                	}
                }
                $db = null;
            }
        } echo $error;
    }
	function create(){
		global $db;
		if (isset($_POST['reg'])) {
        	if (empty($_POST['uname']) || empty($_POST['psw'])) {
            	$error = "Username or Password is invalid";
            }else{
            	$name=$_POST['uname'];
                $pass=$_POST['psw'];
                $regex = "([A-Z][a-z]{2,9}|[a-z]{3,10})";
                if(preg_match($regex, $name)){
                    $pass = md5($pass);

                    $query = "INSERT INTO users (username, password) VALUES (?,?);";
                    $result = $db->prepare($query);
                    if($result->execute(array($name, $pass))){
                        echo "Registration Successful";
                        sleep(1);
                        header("location: login.php");    
                    }
                    else {
                        echo"username already exists";
                    }    

                        
                    $db = null;
                }
                else{
                    echo"username has to be between 3 and 10 chars long";
                }
            }
		}
	}
}