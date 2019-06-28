<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

        $spmId              = $_POST["spmId"];
        $arrayCodProducts   = json_decode($_POST["arrayCodProducts"]);
        $arrayQuantities    = json_decode($_POST["arrayQuantities"]);
        $arrayDates         = json_decode($_POST["arrayDates"]);
        $arrayObservations  = json_decode($_POST["arrayObservations"]);  
        $state              = "PENDIENTE";
        $dateToday          = date('Y-m-d');


        $QUERY 	=   $LINK -> prepare("UPDATE spm SET estado = ?, fechaRecepcion = ? WHERE id = ?");
	    $QUERY	->	bind_param('ssi', $state, $dateToday, $spmId);
	    $QUERY	->	execute();
        
        if( $QUERY -> affected_rows == 1 ){
         
            $QUERY  ->  free_result();
            $QUERY 	=   $LINK -> prepare("SELECT spmProducto.id, spmProducto.idProducto FROM spmProducto INNER JOIN spm ON spmProducto.idSpm = spm.id WHERE spm.id = ?");
	        $QUERY	->	bind_param('i', $spmId);
	        $QUERY	->	execute();
	        $QUERY  ->  store_result();
	        $QUERY  ->  bind_result($spmProductId, $spmProductIdProd);
   
            if( $QUERY -> num_rows > 0 ){
                
                for ( $i=0; $i<$QUERY->num_rows; $i++ ){
                    
                    $QUERY          -> fetch();
                    $existElement   = false;
                    $index          = 0;
                    
                    for( $j=0; $j<sizeof($arrayCodProducts); $j++ ){
                        
                        if( $arrayCodProducts[$j] == $spmProductIdProd ){
                            $existElement   = true;
                            $index          = $j; 
                            break;
                        }
                        
                    }
                    
                    if( $existElement == false ){
                        $QUERY2 =   $LINK -> prepare("DELETE FROM spmProducto WHERE id = ?");
	                    $QUERY2	->	bind_param('i', $spmProductId);
	                    $QUERY2	->	execute();
                    
                    }else{
                        $quantity       =   $arrayQuantities[$index];
                        
                        $date           =   $arrayDates[$index];
                        $dateConverted  =   date_create_from_format('Y-m-j', $date);
                        $dateRequired   =   date_format($dateConverted, 'Y-m-d');
                        
                        $observation    =   $arrayObservations[$index];  
                        
                        $QUERY2 =   $LINK -> prepare("UPDATE spmProducto SET cantidad = ?, fechaDespacho = ?, observacion = ?, cantidadPendiente = ? WHERE id = ?");
	                    $QUERY2	->	bind_param('dssid', $quantity, $dateRequired, $observation, $spmProductId, $quantity);
	                    $QUERY2	->	execute();
                    }
                }
                
                $DATA["ERROR"]      = false;
                $DATA["MESSAGE"]    = "Se ha registrado la spm ".$spmId." exitosamente";
                
            }else{
                $DATA["ERROR"]      = true;
                $DATA["MESSAGE"]    = "ERROR: No se han encontrado ninguna relación entre la spm ".$spmId." con algún producto";
            }
         
        }else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: No se ha podido actualizar la SPM con código ".$spmId;
		}

        $QUERY  -> free_result();
		$LINK   -> close();

	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
