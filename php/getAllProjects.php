<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		
		$username   = $_POST["username"];
		
		$QUERY 	    =   $LINK -> prepare("SELECT id, nombre, rutEncargado, rutBodeguero FROM proyecto WHERE rutEncargado = ? OR rutBodeguero = ?");
        $QUERY      ->  bind_param("ii", $username, $username);
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($id, $nombre, $rutEncargado, $rutBodeguero);
        
        if( $QUERY -> num_rows > 0 ){
            
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "";
			$DATA["count"] 	    = $QUERY->num_rows;
	        
			while ( $QUERY -> fetch() ){
				array_push($DATA, [
				    'projectId'             => $id,
		    	    'projectName'           => $nombre,
		    	    'usernameAdministrator' => $rutEncargado,
		    	    'usernameGrocer'        => $rutBodeguero,
		    	]);
			}
    			
        }else{
            $DATA["ERROR"] 		= true;
    		$DATA["MESSAGE"]	= "ERROR: El usuario no está registrado en ningún proyecto\nSu sesión se cerrará a la brevedad";
        }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
