<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

		$username   =   $_POST["username"];

		$QUERY 	    =   $LINK -> prepare("SELECT correo, nombre, apellido FROM usuario WHERE rut = ?");
		
		$QUERY	    ->	bind_param('i', $username);
		$QUERY	    ->	execute();
		$QUERY      ->  store_result();
        $QUERY      ->  bind_result($email, $name, $lastname);
        
        if( $QUERY -> num_rows == 1 ){
            
            $QUERY->fetch();
            
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "Se ha enviado su nueva clave al correo ".$email;
			$DATA["EMAIL"]      = $correo;
			
			$password   =   substr( md5(microtime()), 1, 8);

			$QUERY2 	=   $LINK -> prepare("UPDATE usuario SET clave = AES_ENCRYPT(?, 'ro67aa45') WHERE rut = ?");
	        $QUERY2	    ->	bind_param('si', $password, $username);
	        $QUERY2	    ->	execute();

            if( $QUERY2 -> affected_rows == 1 ){
                # SEND EMAIL TO EMAIL REGISTERED
                $subject            =  "Solicitud cambio de clave";
                $message            =  '<html>
                                            <head>
                                                <title>Solicitud cambio de clave</title>
                                            </head>
                                            <body>
                                                <p>Estimado(a): '.$name. ' '.$lastname.'<br><br>'.
                                                    'Tu clave ha sido renovada debido a una solicitud reciente.<br>'.
                                                    'Tu nueva clave de acceso es:<br><br>'.
                                                    '     <b>'.$password.'</b><br><br>'.
                                                    'Ante cualquier duda o inquietud háznosla saber al correo support@bermudez.cl<br><br>'.
                                                    'Saludos</p>
                                            </body>
                                        </html>';
                $headers            = 'MIME-Version: 1.0' . "\r\n";
                $headers           .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers           .= 'From: admin@bermudez.cl' . "\r\n";
    
                mail($email, $subject, $message, $headers);    
            
            }else{
                $DATA["ERROR"]      = true;
                $DATA["MESSAGE"]    = "ERROR: No se ha podido actualizar la clave del usuario ".$name." ".$lastname;
		    
            }

            $QUERY2     -> free_result();

		}else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: El usuario $username no está registrado";
		}

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
