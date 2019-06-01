<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

		$username   = $_POST["username"];
    
        $QUERY  =   $LINK -> prepare("DELETE FROM usuario WHERE rut = ?");
		$QUERY  ->	bind_param('i', $username);
        $QUERY  ->  execute();

        if( $QUERY->affected_rows == 1 ){
            $DATA["ERROR"] 		= false;
	        $DATA["MESSAGE"]	= "Se ha eliminado el rut ".$username." exitosamente";
    
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: No se ha podido eliminar el rut ".$username;
        }

        $QUERY      -> free_result();
		
		$LINK       -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
