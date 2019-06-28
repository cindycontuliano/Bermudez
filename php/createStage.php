<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
	    
	    $projectId          = $_POST["projectId"];
	    $stageName          = $_POST["stageName"];
	    $arrayProducts      = json_decode($_POST["arrayProducts"]);
	    $arrayQuantities    = json_decode($_POST["arrayQuantities"]);
	    
        $QUERY 	            =   $LINK -> prepare("INSERT INTO partida (idProyecto, nombre) VALUES (?, ?)");
		$QUERY	            ->	bind_param('is', $projectId, $stageName);
		$QUERY	            ->	execute();

        if( $QUERY -> affected_rows == 1 ){
            $stageId    = $QUERY->insert_id;
            $index      = 0;
            $numErr     = 0;
            
            while( $index < sizeof($arrayProducts) ){
                $product    =   $arrayProducts[$index];
                $quantity   =   $arrayQuantities[$index];
                
                $QUERY      =   $LINK -> prepare("INSERT INTO productoPartida (codFlexline, idPartida, cantidadAsignada, cantidadDisponible) VALUES (?, ?, ?, ?)");
		        $QUERY	    ->	bind_param('sidd', $product, $stageId, $quantity, $quantity);
		        $QUERY	    ->	execute();
		        
		        if( $QUERY->affected_rows == 0 ){
		            $numErr++;
		        }
                
                $index++;
            }
            
            if( $numErr == 0 ){
                $DATA["ERROR"]  = false;
            }else{
                $DATA["ERROR"]  = true;
            }
            
		}else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: La partida ".$stageName." ya se encuentra registrada";
		
		}
		
        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
