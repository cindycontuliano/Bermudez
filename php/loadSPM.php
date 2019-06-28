<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		
		$QUERY 	    =   $LINK -> prepare("SELECT id FROM spm");
        $QUERY      ->  execute();
        $QUERY      ->  store_result();
        $QUERY      ->  bind_result($SPMid);        
        
        if( $QUERY->num_rows > 0 ){
            
            $DATA["ERROR"] 		= false;
			$DATA["MESSAGE"]	= "";
			$DATA["count"] 	    = $QUERY->num_rows;
	
			while ( $QUERY -> fetch() ){
				array_push($DATA, [
				    'SPMid'   => $SPMid,
		
		    	]);
			}
			
        }else{
            $DATA["ERROR"] 		= true;
			$DATA["MESSAGE"]	= "ERROR: No se han encontrado SPM en la base de datos";
			
        }

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
