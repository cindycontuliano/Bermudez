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
		
		$QUERY 	        =   $LINK -> prepare("SELECT rut, permisos, nombre, apellido FROM usuario ORDER BY nombre ASC");
        $QUERY          ->  execute();
        $QUERY          ->  store_result();
        $QUERY          ->  bind_result($rut, $permisos, $nombre, $apellido);
        
        if( $QUERY->affected_rows > 0 ){
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "";
			
			$DATA["count"]      = 0;
			
			while ( $QUERY -> fetch() ){

                $permission = str_split($permisos);
                
				if( $permission[3] == 4 ){
				    array_push($DATA, [
    				    'username'      => $rut,
    		    	    'permissions' 	=> $permisos,
    		    	    'name'	        => $nombre,
    		    	    'lastname'	    => $apellido,
    		    	    'email'	        => $correo,
    		    	    'phone'	        => $telefono,
    		    	]);
    		    	
    		    	$DATA["count"] = $DATA["count"] + 1;
				}
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
