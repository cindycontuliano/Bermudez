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
        $arrayResumen   =   json_decode($_POST["arrayResumen"]);
        $arrayImpPres   =   json_decode($_POST["arrayImpPres"]);

        $QUERY 	        =   $LINK -> prepare("INSERT INTO proyecto (rutPresupuesto, nombre, fechaInicio) VALUES (?, ?, ?)");
		$QUERY	        ->	bind_param('iss', $username, $projectName, $dateToday);
		$QUERY	        ->	execute();

        if( $QUERY -> affected_rows == 1 ){
            
            $QUERY          -> free_result();
            
            $QUERY 	        =   $LINK -> prepare("SELECT id FROM proyecto WHERE nombre = ?");
		    $QUERY	        ->	bind_param('s', $projectName);
		    $QUERY	        ->	execute();
		    $QUERY          ->  store_result();
            $QUERY          ->  bind_result($idProject);
            $QUERY          ->  fetch();
            $QUERY          ->  free_result();
            
            $numItems       =   sizeof($arrayResumen);
            $count          =   0;
           
            while( $count < $numItems ){
                $valResumen =   $arrayResumen[$count];
                $valImpPres =   $arrayImpPres[$count];
                
                $QUERY 	    =   $LINK -> prepare("INSERT INTO partida (idProyecto, nombre, monto) VALUES (?, ?, ?)");
		        $QUERY	    ->	bind_param('isi', $idProject, $valResumen, $valImpPres);
		        $QUERY	    ->	execute();
		        
		        $count++;
            }
            
            $DATA["ERROR"]      = false;
            $DATA["MESSAGE"]    = "Se ha agregado el proyecto ".$projectName." exitosamente";

		}else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: No se ha podido crear el proyecto ".$projectName;
		
		}

        $QUERY  -> free_result();
		$LINK   -> close();

	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
