<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
		exit;
	
	}else{

		$username   = $_POST["username"];
        $permissions= $_POST["permissions"];
		$name       = $_POST["name"];
		$lastname   = $_POST["lastname"];
		$email      = $_POST["email"];
		$phone      = $_POST["phone"];
		    
		if( ctype_digit($phone) == false ){
            $phone  = "";
		}
		
		
		$QUERY      =   $LINK -> prepare("SELECT id FROM usuario WHERE rut = ?");
		$QUERY	    ->	bind_param('i', $username);
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($rut);
		
		if( $QUERY -> num_rows > 0 ){
		    $DATA["ERROR"]      = true;
		    $DATA["MESSAGE"]    = "ERROR: El rut ingresado ya se encuentra registrado en la base de datos";
		
		}else {
		    
		    $QUERY -> free_result();
		    /*
    		PREPARE THE QUERY FOR INSERT THE NEW USER INTO THE DATABASE
    		*/
    		
    		// The default password is the first fours numbers of the rut.
    		$password   =   substr($username, 0, 4);
    
    		$QUERY 	    =   $LINK -> prepare("INSERT INTO `usuario`(`rut`, `clave`, `permisos`, `nombre`, `apellido`, `correo`, `telefono`) 
    		                                    VALUES (?, AES_ENCRYPT(?, 'ro67aa45'), ?, ?, ?, ?, ?)");
    		$QUERY	    ->	bind_param('isssssi', $username, $password, $permissions, $name, $lastname, $email, $phone);
            $QUERY      ->  execute();
            
            if( $QUERY->affected_rows == 1 ){
                $DATA["ERROR"] 		= false;
    			$DATA["MESSAGE"]	= "Se ha agregado el usuario ".$name." ".$lastname." exitosamente";
    			
    			# SEND EMAIL TO EMAIL REGISTERED
                $subject            =  "Bienvenido al Sistema";
                $message            =  '<html>
                                            <head>
                                                <title>Bienvenido al Sistema</title>
                                            </head>
                                            <body>
                                                <p>Estimado(a): '.$name. ' '.$lastname.'<br><br>'.
                                                    'Te damos la más cordial bienvenida al sistema de integración de procesos de empresas Bermúdez.<br>'.
                                                    'Para hacer ingreso al sistema debes utilizar tu <b>Rut</b> y tu clave (Los primeros <b>4 dígitos de tu Rut</b>).<br>'.
                                                    'Ante cualquier duda o inquietud háznosla saber al correo support@bermudez.cl<br><br>'.
                                                    'Saludos</p>
                                            </body>
                                        </html>';
                $headers            = 'MIME-Version: 1.0' . "\r\n";
                $headers           .= 'Content-type: text/html; charset=utf-8' . "\r\n";
     //           $headers           .= $email . "\r\n";
                $headers           .= 'From: admin@bermudez.cl' . "\r\n";
    
    /*			
                $headers  		    = 'MIME-Version: 1.0'."\r\n";
                                      'Content-type: text/html; charset=iso-8859-1'."\r\n";
                                      'From:admin@bermudez.cl>';
                $message		    = "<html><body><p></p></body></html>";
    
    */
                mail($email, $subject, $message, $headers);
        
            }else{
                $DATA["ERROR"] 		= true;
			    $DATA["MESSAGE"]	= "ERROR: El usuario ".$name." ".$lastname." ya está registrado";
			
            }
        
	    }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
