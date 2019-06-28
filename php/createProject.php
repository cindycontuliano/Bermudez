<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		$username       =   $_POST["username"];
        $projectName    =   $_POST["projectName"];
        $dateToday      =   date('Y-m-d');

        $QUERY 	        =   $LINK -> prepare("INSERT INTO proyecto (rutPresupuesto, nombre, fechaInicio, activo) VALUES (?, ?, ?, 1)");
		$QUERY	        ->	bind_param('iss', $username, $projectName, $dateToday);
		$QUERY	        ->	execute();

        if( $QUERY -> affected_rows == 1 ){
            $projectId  =   $QUERY->insert_id;
            
            $DATA["projectId"]  = $projectId;
            $DATA["ERROR"]      = false;
            
		}else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: El proyecto ".$projectName." ya se encuentra registrado";
		
		}
		
        $QUERY  -> free_result();
		$LINK   -> close();

	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
