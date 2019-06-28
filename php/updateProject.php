<?php
    session_start();
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		$id             =   $_POST["id"];
		$name           =   $_POST["name"];
		$usernameOwner  =   $_POST["usernameOwner"];
		$usernameGrocer =   $_POST["usernameGrocer"];
		$startDate      =   $_POST["startDate"];
		$finishDate     =   $_POST["finishDate"];
		
		$QUERY 	    =   $LINK -> prepare("UPDATE proyecto SET nombre = ?, fechaInicio = ?, fechaTermino = ?, rutEncargado = ?, rutBodeguero = ? WHERE id = ?");
		$QUERY	    ->	bind_param('sssiii', $name, $startDate, $finishDate, $usernameOwner, $usernameGrocer, $id);
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
