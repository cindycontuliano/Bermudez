<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
	    
	    $nameStage      =   $_POST["nameStage"];
	    $projectName    =   $_POST["projectName"];

		$QUERY      =   $LINK -> prepare("SELECT partida.id FROM partida INNER JOIN proyecto ON partida.idProyecto = proyecto.id WHERE partida.nombre = ? AND proyecto.nombre = ?");
		$QUERY      ->  bind_param("ss", $nameStage, $projectName);
		$QUERY      ->  execute();
		$QUERY      ->  store_result();
		$QUERY      ->  bind_result($stageId);

		if( $QUERY -> num_rows > 0 ){
		
		    $QUERY  ->  fetch();
		    $QUERY  ->  free_result();
		    $QUERY 	    =   $LINK -> prepare("SELECT producto.codFlexline, producto.glosa, producto.unidad, producto.familia, productoPartida.cantidadDisponible FROM producto INNER JOIN productoPartida ON producto.codFlexline = productoPartida.codFlexline WHERE productoPartida.idPartida = ? ORDER BY producto.glosa ASC");
		    $QUERY      ->  bind_param("i", $stageId);
            $QUERY      ->  execute();
            $QUERY      ->  store_result();
            $QUERY      ->  bind_result($codFlexline, $glosa, $unidad, $familia, $quantityAvailable);

            if( $QUERY->num_rows > 0 ){
                
                $DATA["ERROR"] 		= false;
    			$DATA["MESSAGE"]	= "";
    			$DATA["count"] 	    = $QUERY->num_rows;
    	
    			while ( $QUERY -> fetch() ){
    				array_push($DATA, [
    				    'codFlexline'   => $codFlexline,
    				    'glosa'         => $glosa,
    				    'unidad'        => $unidad,
    				    'familia'       => $familia,
    				    'cantDisponible'=> $quantityAvailable,
    		    	]);
    			}
    			
            }else{
                $DATA["ERROR"] 		= true;
    			$DATA["MESSAGE"]	= "ERROR: No se han encontrado productos asociados a la partida ".$nameStage;
            }
            
		}else{
		    $DATA["ERROR"]      = true;
		    $DATA["MESSAGE"]    = "ERROR: No se han encontrado resultados para la partida ".$nameStage;
		}

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
