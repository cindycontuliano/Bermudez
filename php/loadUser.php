<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

		$username   = $_POST["username"];

        $QUERY 	    =   $LINK -> prepare("SELECT id, permisos, nombre, apellido, correo, telefono  FROM usuario WHERE rut = ?");
        $QUERY	    ->	bind_param('i', $username);
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($id, $permisos, $nombre, $apellido, $correo, $telefono);
        
        if( $QUERY -> num_rows == 1 ){
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "";

		    $QUERY              -> fetch();
		    
		    $DATA["id"]         = $id;
		    $DATA["permisos"] 	= $permisos;
			$DATA["nombre"]	    = $nombre;
			$DATA["apellido"]	= $apellido;
			$DATA["correo"]	    = $correo;
			$DATA["telefono"]	= $telefono;
    
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: El rut ".$username." no está registrado";
			
        }
        
        $QUERY      -> free_result();
		$LINK       -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
