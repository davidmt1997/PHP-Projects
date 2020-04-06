<?php

	try{
        $db = new PDO('mysql:host=localhost;dbname=davidmt1997', 'randy', '');	
    }
    catch(Exception $e){
    	print "Error!: " . $e->getMessage() . "<br/>";
	    die();
    }
?>
