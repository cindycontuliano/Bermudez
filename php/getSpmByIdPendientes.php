<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
	    
	    //$arrayTest  = json_decode($_POST["arrayTest"]);
		
		//for( $i=0; $i<sizeof($arrayTest); $i++ ){
		    
		  //  $codSPM    = $arrayTest[$i];

        $codSPM     =   $_POST["codSPM"];
        
		$QUERY 	    =   $LINK -> prepare("SELECT spmProducto.idProducto, spmProducto.cantidad, spmProducto.fechaDespacho ,spmProducto.observacion, spmProducto.cantidadPendiente FROM spmProducto INNER JOIN spm ON spmProducto.idSPM = spm.id WHERE spmProducto.cantidadPendiente > 0 AND spm.id = ? ");
        $QUERY      ->  bind_param("i", $codSPM);
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($productId, $quantity, $dateRequired ,$observation, $cantidadPendiente);
        
        if( $QUERY->num_rows > 0 ){
    
            $DATA["count"]   = $QUERY->num_rows;
            
            for ( $i=0; $i<$QUERY->num_rows; $i++ ){
               
                $QUERY      -> fetch();

                $QUERY2     =   $LINK -> prepare("SELECT codFlexline, glosa, familia, unidad FROM producto WHERE id = ?");
                $QUERY2     ->  bind_param("i", $productId);
                $QUERY2     ->  execute();
                $QUERY2     ->  store_result();
                $QUERY2     ->  bind_result($codFlexline, $productName, $productFamily, $productMeasureUnit);
  			
    			if( $QUERY2 -> num_rows == 1 ){
       			    
       			    $QUERY2 -> fetch();
       			    
   			        array_push($DATA, [
   			                'idTest'                => $codSPM,
        				    'codFlexline'           => $codFlexline,
        				    'codProduct'            => $productId,
        				    'productName'           => $productName,
        				    'productFamily'         => $productFamily,
        				    'productMeasureUnit'    => $productMeasureUnit,
        				    'quantity'              => $quantity,
        				    'dateRequired'          => $dateRequired,
        				    'observation'           => $observation,
        				    'cantidadPendiente'     => $cantidadPendiente,
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
	//}
    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
