<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

		$username       = $_POST["username"];
        $oldPassword    = $_POST["oldPassword"];
        $newPassword    = $_POST["newPassword"];

		$QUERY 	    =   $LINK -> prepare("SELECT AES_DECRYPT(clave,'ro67aa45') FROM usuario WHERE rut = ?");
		
		$QUERY	    ->	bind_param('i', $username);
		$QUERY	    ->	execute();
		$QUERY      ->  store_result();
        $QUERY      ->  bind_result($clave);
        
        if( $QUERY->num_rows == 1 ){
            
            $QUERY->fetch();
            
            if( $clave == $oldPassword ){

        		$QUERY2 	=   $LINK -> prepare("UPDATE usuario SET clave = AES_ENCRYPT(?, 'ro67aa45') WHERE rut = ?");
                $QUERY2	    ->	bind_param('si', $newPassword, $username);
                $QUERY2	    ->	execute();
            
                if( $QUERY2->affected_rows == 1 ){
                    $DATA["ERROR"]      = false;
                    $DATA["MESSAGE"]    = "Se ha actualizado la clave exitosamente";
                
                }else{
                    $DATA["ERROR"]      = false;
                    $DATA["MESSAGE"]    = "ERROR: No se ha podido actualizar la clave";
                }
                
            $QUERY2     -> free_result();
                
            }else{
                $DATA["ERROR"]      = true;
                $DATA["MESSAGE"]    = "ERROR: La clave antigua ingresada no coincide con la registrada";
            }
            
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
