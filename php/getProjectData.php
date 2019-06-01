<?php
    session_start();
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
		$projectName=   $_POST["projectName"];

		$QUERY 	    =   $LINK -> prepare("SELECT id, nombre, fechaInicio, fechaTermino, rutEncargado FROM proyecto WHERE nombre = ?");
		$QUERY	    ->	bind_param('s', $projectName);
		$QUERY	    ->	execute();
		$QUERY      ->  store_result();
        $QUERY      ->  bind_result($id, $nombre, $fechaInicio, $fechaTermino, $rutEncargado);
        
        if( $QUERY -> num_rows == 1 ){
            
            $QUERY->fetch();
 
			$DATA["ERROR"] 		    = false;
			$DATA["projectId"]	    = $id;
			$DATA["projectName"]	= $nombre;
			$DATA["startDate"]		= $fechaInicio;
			$DATA["finishDate"]	    = $fechaTermino;
			$DATA["projectOwner"]   = $rutEncargado;

		}else{
			$DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ERROR: No se han encontrado resultados para el proyecto ".$projectName;
		}

        $QUERY  -> free_result();
		$LINK   -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
