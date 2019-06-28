<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		
        $codSPM     =   $_POST["codSPM"];
        
		$QUERY 	    =   $LINK -> prepare("SELECT spmProducto.idProducto, spmProducto.idPartida, spmProducto.cantidad, spmProducto.fechaDespacho, spmProducto.observacion FROM spmProducto INNER JOIN spm ON spmProducto.idSPM = spm.id WHERE spm.id = ?");
        $QUERY      ->  bind_param("i", $codSPM);
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($productId, $stageId, $quantity, $dateRequired ,$observation);
        
        if( $QUERY->num_rows > 0 ){
    
            $DATA["count"]   = $QUERY->num_rows;
            
            for ( $i=0; $i<$QUERY->num_rows; $i++ ){
               
                $QUERY      -> fetch();
                
                $QUERY2     =   $LINK -> prepare("SELECT codFlexline, glosa, familia, unidad FROM producto WHERE id = ?");
                $QUERY2     ->  bind_param("i", $productId);
                $QUERY2     ->  execute();
                $QUERY2     ->  store_result();
                $QUERY2     ->  bind_result($codFlexline, $productName, $productFamily, $productMeasureUnit);
  			
  			    $QUERY3     =   $LINK -> prepare("SELECT nombre FROM partida WHERE id = ?");
  			    $QUERY3     ->  bind_param("i", $stageId);
  			    $QUERY3     ->  execute();
  			    $QUERY3     ->  store_result();
  			    $QUERY3     ->  bind_result($stageName);
  			
    			if( $QUERY2->num_rows == 1 && $QUERY3->num_rows == 1 ){
       			    
       			    $QUERY2 -> fetch();
       			    $QUERY3 -> fetch();
       			    
   			        array_push($DATA, [
        				    'codFlexline'           => $codFlexline,
        				    'codProduct'            => $productId,
        				    'productName'           => $productName,
        				    'productFamily'         => $productFamily,
        				    'stageName'             => $stageName,
        				    'productMeasureUnit'    => $productMeasureUnit,
        				    'quantity'              => $quantity,
        				    'dateRequired'          => $dateRequired,
        				    'observation'           => $observation,
        		    ]);
       			     
    			}else{
                    $DATA["ERROR"]      = true;
                    $DATA["MESSAGE"]    = "ERROR: El código de producto ".$productId." no contiene ningún registro";
                    break;
                }
            }

        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: La SPM ingresada no contiene ningún registro";
        }
        
        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
