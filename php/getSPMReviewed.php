<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		
        $projectName    = $_POST["projectName"];
        $AUX            = array();
        $error          = true;

		$QUERY 	    =   $LINK -> prepare("SELECT partida.id FROM partida RIGHT JOIN proyecto ON partida.idProyecto = proyecto.id WHERE proyecto.nombre = ?");
        $QUERY      ->  bind_param("s", $projectName);
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($stageId);        

        if( $QUERY->num_rows > 0 ){

//  I have 214 results
            
            //$error  = true;
            $count  = 0;
            
            for ( $i=0; $i<$QUERY->num_rows; $i++ ){
               
                $QUERY      -> fetch();

                $QUERY2     =   $LINK -> prepare("SELECT spm.id FROM spm INNER JOIN spmProducto ON spm.id = spmProducto.idSpm WHERE spm.estado = 'EMITIDA' AND spmProducto.idPartida = ?");
                $QUERY2     ->  bind_param("i", $stageId);
                $QUERY2     ->  execute();
                $QUERY2     ->  store_result();
                $QUERY2     ->  bind_result($spmId);
  			
    			if( $QUERY2 -> num_rows > 0 ){
       			    $error  = false;
       			    
    			    for( $j=0; $j<$QUERY2->num_rows; $j++ ){
    			    
    			        $exists =   false;    
    			        $QUERY2 ->  fetch();
    			        $idPrev =   array_column($DATA, 'spmId');
    			        
    			        for( $k=0; $k<sizeof($idPrev); $k++ ){
    			            
    			            if( $spmId == $idPrev[$k] ){
        			            $exists  = true;
        			            break;
        			        }
    			                
    			        }
    			        
    			        if( $exists === false ){
    			           $count++;
    			           $DATA["count"]   = $count;
        			       array_push($DATA, [
            				    'spmId'     => $spmId,
            				    'stageId'   => $stageId,
            		    	]); 
        			    }    
    			       
    			    }
    			     
    			}
            }
            
            if( $error  === false ){
                $DATA["ERROR"]      = false;
            
            }else{
                $DATA["ERROR"]      = true;
                $DATA["MESSAGE"]    = "ERROR: No se ha encontrado ninguna spm para el proyecto ".$projectName;
            }
            
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: El proyecto ".$projectName." no tiene registrado ninguna partida";
        }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
