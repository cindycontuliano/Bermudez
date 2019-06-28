<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

		$projectName   = $_POST["projectName"];
    
        $QUERY  =   $LINK -> prepare("UPDATE proyecto SET activo = 0 WHERE nombre = ?");
    	$QUERY  ->	bind_param('s', $projectName);
        $QUERY  ->  execute();
        
        if( $QUERY->affected_rows == 1 ){
            $DATA["ERROR"] 		= false;
	        $DATA["MESSAGE"]	= "Se ha cerrado el proyecto ".$projectName." exitosamente";
    
        }else{
            $DATA["ERROR"] 		= true;
		    $DATA["MESSAGE"]	= "ERROR: No se ha podido cerrar el proyecto ".$projectName;
        }
        
        $QUERY      -> free_result();
		$LINK       -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
