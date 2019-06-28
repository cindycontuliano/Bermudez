<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

		$idSpm              = $_POST["idSpm"];
		$projectName        = $_POST["projectName"];
		$arrayCodsFlexline  = json_decode($_POST["arrayCodsFlexline"]);
		$arrayQuantities    = json_decode($_POST["arrayQuantities"]);
		$arrayStageNames    = json_decode($_POST["arrayStageNames"]);
		
		
		for( $i=0; $i<sizeof($arrayCodsFlexline); $i++ ){
		    
		    $codFlexline    = $arrayCodsFlexline[$i];
		    $quantity       = $arrayQuantities[$i];
		    $stageName      = $arrayStageNames[$i];
		    
		    $QUERY  =   $LINK -> prepare("SELECT partida.id FROM partida INNER JOIN proyecto ON partida.idProyecto = proyecto.id WHERE proyecto.nombre = ? AND partida.nombre = ?");
		    $QUERY  ->  bind_param("ss", $projectName, $stageName);
		    $QUERY  ->  execute();
		    $QUERY  ->  store_result();
		    $QUERY  ->  bind_result($stageId);
		    
		    $QUERY  ->  fetch();
		    $QUERY  ->  free_result();
		    
		    $QUERY  =   $LINK -> prepare("UPDATE productoPartida SET cantidadDisponible = cantidadDisponible + ? WHERE codFlexline = ? AND idPartida = ?");
		    $QUERY  ->  bind_param("isi", $quantity, $codFlexline, $stageId);
		    $QUERY  ->  execute();
		    
		}
		
        $QUERY  =   $LINK -> prepare("DELETE FROM spm WHERE id = ?");
		$QUERY  ->	bind_param('i', $idSpm);
        $QUERY  ->  execute();
        
        if( $QUERY -> affected_rows ==  1){
    
            $QUERY  =   $LINK -> prepare("DELETE FROM spmProducto WHERE idSpm = ?");
    		$QUERY  ->	bind_param('i', $idSpm);
            $QUERY  ->  execute();
           
            if( $QUERY->affected_rows > 0 ){
                $DATA["ERROR"] 		= false;
    	        $DATA["MESSAGE"]	= "Se ha eliminado la SPM n° ".$idSpm." exitosamente junto con todos sus productos";
        
            }else{
                $DATA["ERROR"] 		= true;
    		    $DATA["MESSAGE"]	= "ERROR: No se ha podido eliminar los productos de la SPM n° ".$idSpm;
            }
            
        }else{
            $DATA["ERROR"] 		= true;
            $DATA["MESSAGE"]	= "ERROR: No se ha podido eliminar la SPM n° ".$idSpm;
        }
        
		$LINK       -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
