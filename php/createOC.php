<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

        $username           =   $_POST["username"];
        $projectName        =   $_POST["projectName"];
        $arrayProducts      =   json_decode($_POST["arrayProducts"]);
        $arrayQuantities    =   json_decode($_POST["arrayQuantities"]);
        $arrayStages        =   json_decode($_POST["arrayStages"]);
        $arrayDates         =   json_decode($_POST["arrayDates"]);
        $arrayObservations  =   json_decode($_POST["arrayObservations"]);            
            
        $state              =   "EMITIDA";
        $dateToday          =   date('Y-m-d');
                
        
        if( sizeof($arrayProducts) > 0 ){
            
            $QUERY 	        =   $LINK -> prepare("INSERT INTO spm (rutEmisor, estado, fechaEmision) VALUES ( ?, ?, ?)");
    	    $QUERY	        ->	bind_param('iss', $username, $state, $dateToday);
    	    $QUERY	        ->	execute();
            
            if( $QUERY -> affected_rows == 1 ){
                
                $ERROR      =   "";
                $MESSAGE    =   "";
                $spmId      =   $QUERY->insert_id;
                $QUERY      ->  free_result();
            
                $QUERY 	        =   $LINK -> prepare("SELECT id FROM proyecto WHERE nombre = ?");
            	$QUERY	        ->	bind_param('s', $projectName);
            	$QUERY	        ->	execute();
            	$QUERY          ->  store_result();
                $QUERY          ->  bind_result($projectId);
                $QUERY          ->  fetch();
            
                if( $QUERY->num_rows == 1 ){
                
                    for ( $i=0; $i<sizeof($arrayProducts); $i++ ){
                        
                        $stage          =   $arrayStages[$i];
                        
                        $QUERY 	        =   $LINK -> prepare("SELECT id FROM partida WHERE nombre = ? AND idProyecto = ?");
                		$QUERY	        ->	bind_param('si', $stage, $projectId);
                	    $QUERY	        ->	execute();
                	    $QUERY          ->  store_result();
                        $QUERY          ->  bind_result($stageId);
                        $QUERY          ->  fetch();
                        
                        if( $QUERY -> num_rows == 1 ){
        
                            $QUERY          ->  free_result();
                            $product        =   $arrayProducts[$i];
                
                            $QUERY 	        =   $LINK -> prepare("SELECT id FROM producto WHERE glosa = ?");
                    		$QUERY	        ->	bind_param('s', $product);
                    	    $QUERY	        ->	execute();
                    	    $QUERY          ->  store_result();
                            $QUERY          ->  bind_result($productId);
                            $QUERY          ->  fetch();
                
                            if( $QUERY -> num_rows == 1 ){
                                
                                $QUERY          ->  free_result();
                                $quantity       =   $arrayQuantities[$i];
                                $dateRequired   =   $arrayDates[$i];
                                $observation    =   $arrayObservations[$i];
                                
                                $QUERY 	        =   $LINK -> prepare("INSERT INTO spmProducto (idProducto, idSpm, idPartida, cantidad, fechaDespacho, observacion, cantidadPendiente) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
                		        $QUERY	        ->	bind_param('iiiissi', $productId, $spmId, $stageId, $quantity, $dateRequired, $observation, $quantity);
                		        $QUERY	        ->	execute();
                            		        
                		        if( $QUERY -> affected_rows == 1 ){
                		            $ERROR      = false;
                                    $MESSAGE    = "El producto ".$product." se ha agregado exitosamente";
                		        }else{
                		            $ERROR      = true;
                                    $MESSAGE    = "ERROR: No se ha podido agregar la relación SPM-PRODUCTO";
                		        }
                                
                            }else{
                                $ERROR      = true;
                                $MESSAGE    = "ERROR: No se ha encontrado el código del producto ".$product;
                            }
                                 
                        }else{
                            $ERROR      = true;
                            $MESSAGE    = "ERROR: No se ha encontrado el código de la partida ".$stage;
                        }
                        
        				array_push($DATA, [
            				'ERROR'     => $ERROR,
            		    	'MESSAGE'   => $MESSAGE,
            		    ]);
                        
                    }
                
                }else{
                    $DATA["ERROR"]      = true;
                    $DATA["MESSAGE"]    = "ERROR: No se ha encontrado el código del proyecto ".$projectName;
                }
            
            }else{
    			$DATA["ERROR"]      = true;
                $DATA["MESSAGE"]    = "ERROR: No se ha podido crear la SPM";
    		}
		
		    $QUERY  -> free_result();
		    $LINK   -> close();
		
        }else{
            $DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: La SPM no se puede crear debido que no se agregado ningún producto";
        }
        
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
