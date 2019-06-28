<?php
    session_start();
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		$projectName    =   $_POST["projectName"];
		$stageName      =   $_POST["stageName"];
		$codFlexline    =   $_POST["codFlexline"];
		$quantity       =   $_POST["quantity"];
		
		$QUERY 	    =   $LINK -> prepare("SELECT partida.id FROM partida INNER JOIN proyecto ON partida.idProyecto = proyecto.id WHERE partida.nombre = ? AND proyecto.nombre = ?");
		$QUERY	    ->	bind_param('ss', $stageName, $projectName);
		$QUERY	    ->	execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($stageId);
        
        if( $QUERY->num_rows == 1 ){
            
            $QUERY  ->  fetch();
            $QUERY  ->  free_result();
            
            $QUERY 	    =   $LINK -> prepare("UPDATE productoPartida SET cantidadDisponible = cantidadDisponible + ? WHERE codFlexline = ? AND idPartida = ?");
		    $QUERY	    ->	bind_param('isi', $quantity, $codFlexline, $stageId);
		    $QUERY	    ->	execute();
            
            if( $QUERY->affected_rows == 1 ){
                $DATA["ERROR"] 		= false;
                
            }else{
			    $DATA["ERROR"] 		= true;
			    $DATA["MESSAGE"]    = "No se ha podido actualizar la cantidad disponible del producto ingresado";
            }

		}else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: No se ha encontrado registros para la partida ".$stageName;
		}

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
