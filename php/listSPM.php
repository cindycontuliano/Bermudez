<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		
		/*
		PREPARE THE QUERY FOR SEARCH THE LIST OF SYSTEM´S USERS 
		*/
		
		$QUERY 	    =   $LINK -> prepare("SELECT id,estado,fechaEmision FROM spm");
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($id, $estado, $fechaEmision);        
        
        if( $QUERY->affected_rows > 0 ){
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "";
			
			$DATA["count"] 	    = $QUERY->num_rows;
	
			while ( $QUERY -> fetch() ){
				
				array_push($DATA, [
				'number'    => $id,
		    	'estado' 	=> $estado,
		    	'date'	    => $fechaEmision,
		    	]);
			}
			
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: No se han encontrado usuarios en la base de datos";
			
        }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>