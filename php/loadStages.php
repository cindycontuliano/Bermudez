<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		
		$username   =   $_POST["username"];
		
		$QUERY 	    =   $LINK -> prepare("SELECT id FROM proyecto WHERE rutEncargado = ?");
        $QUERY      ->	bind_param('i', $username);
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($projectId);
        
        if( $QUERY -> num_rows == 1 ){
            
            $QUERY      ->  fetch();
            $QUERY 	    =   $LINK -> prepare("SELECT id, nombre FROM partida WHERE idProyecto = ?");
            $QUERY      ->	bind_param('i', $projectId);
            $QUERY      ->  execute();
            $QUERY      ->  store_result();
            $QUERY      ->  bind_result($stageId, $stageName);        
            
            if( $QUERY  ->  num_rows > 0 ){
                $DATA["ERROR"] 		= false;
    			$DATA["MESSAGE"]	= "";
    			$DATA["count"] 	    = $QUERY->num_rows;
    	        
    			while ( $QUERY -> fetch() ){
    				array_push($DATA, [
    				    'stageId'   => $stageId,
    		    	    'stageName' => $stageName,
    		    	]);
    			}
   	
            }else{
                $DATA["ERROR"] 		= true;
    			$DATA["MESSAGE"]	= "ERROR: No se han encontrado partidas asociadas en la base de datos";
    			
            }
        }else{
            $DATA["ERROR"] 		= true;
    		$DATA["MESSAGE"]	= "ADVERTENCIA: Tu rut no tiene asociado ningún proyecto";
        }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
