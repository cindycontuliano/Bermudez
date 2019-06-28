<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
	    
	    $projectName    = $_POST["projectName"];
		
		$QUERY 	    =   $LINK -> prepare("SELECT id FROM proyecto WHERE nombre = ?");
        $QUERY      ->  bind_param("s", $projectName);
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($projectId);        
        
        if( $QUERY->affected_rows == 1 ){
            
            $QUERY      ->  fetch();
            
            $QUERY 	    =   $LINK -> prepare("SELECT nombre FROM partida WHERE idProyecto = ? ORDER BY nombre ASC");
            $QUERY      ->  bind_param("i", $projectId);
            $QUERY      ->  execute();
            $QUERY      ->  store_result();
            $QUERY      ->  bind_result($stages);
            
            if( $QUERY -> num_rows > 0 ){
                
                $DATA["ERROR"] 		= false;
    			$DATA["MESSAGE"]	= "";
    			$DATA["count"] 	    = $QUERY->num_rows;
    	
    			while ( $QUERY -> fetch() ){
    				array_push($DATA, [
    				'stageName'  => $stages,
    		    	]);
    			}
                
            }else{
                $DATA["ERROR"] 		= true;
			    $DATA["MESSAGE"]	= "ERROR: El proyecto ".$projectName." no tiene asociada ninguna partida";
            }
            
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: No se ha encontrado datos para el proyecto ".$projectName;
        }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
