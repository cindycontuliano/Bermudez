<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{

		$projectName   = $_POST["projectName"];
    
        $QUERY  =   $LINK -> prepare("SELECT id FROM proyecto WHERE nombre = ?");
		$QUERY  ->	bind_param('s', $projectName);
        $QUERY  ->  execute();
        $QUERY  ->  store_result();
        $QUERY  ->  bind_result($id);        
        
        if( $QUERY -> num_rows ==  1){
            $QUERY  ->  fetch();
    
            $QUERY  =   $LINK -> prepare("DELETE FROM proyecto WHERE id = ?");
    		$QUERY  ->	bind_param('i', $id);
            $QUERY  ->  execute();
    
            $QUERY2 =   $LINK -> prepare("DELETE FROM partida WHERE idProyecto = ?");
    		$QUERY2 ->	bind_param('i', $id);
            $QUERY2 ->  execute();
    
            if( $QUERY->affected_rows == 1 ){
                $DATA["ERROR"] 		= false;
    	        $DATA["MESSAGE"]	= "Se ha eliminado el proyecto ".$projectName." exitosamente junto con todas sus partidas";
        
            }else{
                $DATA["ERROR"] 		= true;
    		    $DATA["MESSAGE"]	= "ERROR: No se ha podido eliminar el proyecto ".$projectName;
            }

            $QUERY2     -> free_result();
            
        }else{
            $DATA["ERROR"] 		= true;
	        $DATA["MESSAGE"]	= "ERROR: No se ha encontrado el proyecto ".$projectName;
        }
        
        $QUERY      -> free_result();
		$LINK       -> close();
	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
