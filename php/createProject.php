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
        $arrayResumen   =   $_POST["arrayResumen"];
        $arrayImpPres   =   $_POST["arrayImpPres"];
        
        $resumen        = json_decode($arrayResumen);
        $DATA["0"]  =   $arrayResumen;
        $DATA["1"]  =   $resumen[0];
        $DATA["2"]  =   $resumen;
/*
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
            
            $resumenList    =   json_decode($arrayResumen);
            $impPresList    =   json_decode($arrayImpPres);
            
            $numItems       =   sizeof($resumenList);
            $count          =   0;
           
            while( $count < $numItems ){
                $auxResumen =   $resumenList[$count];
                $auxImpPres  =   $impPresList[$count];
                
                $QUERY 	    =   $LINK -> prepare("INSERT INTO partida (idProyecto, nombre, monto) VALUES (?, ?, ?)");
		        $QUERY	    ->	bind_param('isi', $idProject, $auxResumen, $auxImpPres);
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
*/
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
