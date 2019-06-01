<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
	    session_start();
	    
	    unset($_SESSION['username']);
		unset($_SESSION['name']);
		unset($_SESSION['lastname']);
		unset($_SESSION['timesession']);
		
		session_destroy();
		$DATA["MESSAGE"] = "Se ha cerrado sesión exitosamente";
		
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
