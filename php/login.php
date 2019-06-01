<?php
    session_start();
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		$username   =   $_POST["username"];
        $password   =   $_POST["password"];

		$QUERY 	    =   $LINK -> prepare("SELECT AES_DECRYPT(clave,'ro67aa45'), permisos, nombre, apellido FROM usuario WHERE rut = ?");
		
		$QUERY	    ->	bind_param('i', $username);
		$QUERY	    ->	execute();
		$QUERY      ->  store_result();
        $QUERY      ->  bind_result($clave, $permisos, $nombre, $apellido);
        
        if( $QUERY -> num_rows == 1 ){
            
            $QUERY->fetch();
            
	        if( $password == $clave ){
				$DATA["ERROR"] 		    = false;
				$DATA["permissions"]	= $permisos;
				$DATA["name"]		    = $nombre;
				$DATA["lastname"]	    = $apellido;
				
                $_SESSION['username']       = $_POST["username"];
                $_SESSION['name']           = $nombre;
                $_SESSION['lastname']       = $apellido;
                $_SESSION['timesession']    = time();
				
			}else{
				$DATA["ERROR"] 	    = true;
			    $DATA["MESSAGE"]    = 1;
			}

		}else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = 2;
		}

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
