<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		
		$QUERY 	    =   $LINK -> prepare("SELECT id, fechaRecepcion FROM spm WHERE spm.estado = 'PENDIENTE'");
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($spmId, $spmDate);        
        
        if( $QUERY->affected_rows > 0 ){
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "";
			
			$DATA["count"] 	    = $QUERY->num_rows;
	
			while ( $QUERY -> fetch() ){
				
			   array_push($DATA, [
            		'spmId'     => $spmId,
            		'spmDate'   =>$spmDate,
		    	]);
			}
			
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: No existen spm en la base de datos";
			
        }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>


