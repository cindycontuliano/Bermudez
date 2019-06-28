<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
	    
	    $codFlexline    =   $_POST["codFlexline"];
	    $stageName      =   $_POST["stageName"];
	    $projectName    =   $_POST["projectName"];
	    
	    $QUERY  =   $LINK -> prepare("SELECT partida.id FROM partida INNER JOIN proyecto ON partida.idProyecto = proyecto.id WHERE proyecto.nombre = ? AND partida.nombre = ?");
	    $QUERY  ->  bind_param("ss", $projectName, $stageName);
		$QUERY  ->  execute();
		$QUERY  ->  store_result();
		$QUERY  ->  bind_result($stageId);

	    if( $QUERY->num_rows == 1 ){
	        
	        $QUERY  ->  fetch();
	        $QUERY  ->  free_result();
	        
	        $QUERY  =   $LINK -> prepare("SELECT productoPartida.cantidadDisponible, producto.unidad FROM productoPartida INNER JOIN producto ON producto.codFlexline = productoPartida.codFlexline WHERE productoPartida.codFlexline = ? AND productoPartida.idPartida = ?");
    		$QUERY  ->  bind_param("si", $codFlexline, $stageId);
    		$QUERY  ->  execute();
    		$QUERY  ->  store_result();
    		$QUERY  ->  bind_result($quantAvailable, $unitMeasure);

    		if( $QUERY -> num_rows == 1 ){
    		
    		    $QUERY  ->  fetch();
    		    
    		    $DATA["quantAvailable"] = $quantAvailable;
    		    $DATA["unitMeasure"]    = $unitMeasure;
                $DATA["ERROR"]          = false;
                
    		}else{
    		    $DATA["ERROR"]      = true;
    		    $DATA["MESSAGE"]    = "ERROR: La partida no continen el producto indicado";
    		}
    		
	    }else{
            $DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: No se han encontrado resultados para la partida";
	    }
	    
        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
