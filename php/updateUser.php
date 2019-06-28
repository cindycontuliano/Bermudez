<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

        $id         = $_POST["id"];
		$username   = $_POST["username"];
		$permissions= $_POST["permissions"];
		$name       = $_POST["name"];
		$lastname   = $_POST["lastname"];
		$email      = $_POST["email"];
		$phone      = $_POST["phone"];
		
		if( ctype_digit($phone) == false ){
            $phone  = "";
		}
		
		/*
		PREPARE THE QUERY FOR UPDATE THE USER´S DATA IN THE DATABASE
		*/

		$QUERY  =   $LINK -> prepare("UPDATE usuario SET rut = ?, permisos = ?, nombre = ?, apellido = ?, correo = ?, telefono = ? WHERE id = ?");
		$QUERY  ->	bind_param('issssii', $username, $permissions, $name, $lastname, $email, $phone, $id);
        $QUERY  ->  execute();
        
        if( $QUERY->affected_rows == 1 ){
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "Se han modificado los datos del usuario ".$name." ".$lastname." exitosamente";
        
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: No se ha podido realizar la actualización de los datos";
		}

        $QUERY  -> free_result();
		$LINK   -> close();
    }
    header('Content-Type: application/json');
	echo json_encode($DATA);
?>