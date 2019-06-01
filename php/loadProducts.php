<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli( "190.151.42.155", "FLEXLINE", "flexline", "DBFlexline", 3306);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		$DATA["ERROR"]      = false;
		$DATA["MESSAGE"]    = "Conexión Exitosa";
	
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
