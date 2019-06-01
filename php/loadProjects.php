<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		
		$QUERY 	    =   $LINK -> prepare("SELECT nombre FROM proyecto");
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($projectName);        
        
        if( $QUERY->affected_rows > 0 ){
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "";
			$DATA["count"] 	    = $QUERY->num_rows;
	
			while ( $QUERY -> fetch() ){
				array_push($DATA, [
				'projectName'  => $projectName,
		    	]);
			}
			
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ADVERTENCIA: No hay registrado ningún proyecto en la base de datos";
			
        }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
