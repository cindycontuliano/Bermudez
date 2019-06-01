<?php
    session_start();
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		$projectName    =   $_POST["projectName"];
		$username       =   $_POST["username"];
		
		$QUERY 	    =   $LINK -> prepare("UPDATE proyecto SET rutEncargado = ? WHERE nombre = ?");
		$QUERY	    ->	bind_param('is', $username, $projectName);
		$QUERY	    ->	execute();
        
        if( $QUERY -> affected_rows == 1 ){
			$DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]    = "Se ha actualizado el proyecto exitosamente";

		}else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: No se ha podido actualizar el proyecto";
		}

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
