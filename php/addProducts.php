<?php
    
    include "configuration/conf.php";
    
    $LINK = new mysqli($URL, $USERNAME, $PASSWORD, $DATABASE);

	if(	empty($LINK) ){
		$DATA["ERROR"]      = true;
		$DATA["MESSAGE"]    = "ERROR: El servidor no responde";
	
	}else{
	    $arrayCodFlexline   =   json_decode($_POST["arrayCodFlexline"]);
        $arrayGlosa         =   json_decode($_POST["arrayGlosa"]);
        $arrayFamilia       =   json_decode($_POST["arrayFamilia"]);
        $arrayUnidad        =   json_decode($_POST["arrayUnidad"]);
        $dateToday          =   date('Y-m-d');

        $numItems           =   sizeof($arrayCodFlexline);
        $count              =   0;
        $numErr             =   0;
       
        while( $count < $numItems ){
            $codFlexline    =   $arrayCodFlexline[$count];
            $glosa          =   str_replace ( "  " , " " , $arrayGlosa[$count]);
            $glosa          =   ltrim($glosa);
            
            $familia        =   $arrayFamilia[$count];
            $unidad         =   $arrayUnidad[$count];
            
            $QUERY 	    =   $LINK -> prepare("INSERT INTO producto (codFlexline, glosa, familia, unidad, fechaActualizacion) VALUES (?, ?, ?, ?, ?)");
	        $QUERY	    ->	bind_param('sssss', $codFlexline, $glosa, $familia, $unidad, $dateToday);
	        
	        if( $QUERY -> execute() ){
	            
	        }else{
	            $numErr++;   
	        }
	        
	        $count++;
        }

        if( $numErr == 0 ){
            $DATA["ERROR"]      = false;
            $DATA["MESSAGE"]    = "Se han agregado todos los productos exitosamente";
            
        }else{
            $DATA["ERROR"]      = true;
            $DATA["MESSAGE"]    = "ADVERTENCIA: Se han omitido ".$numErr." productos por estar duplicados";
            
        }

        $QUERY  -> free_result();
		$LINK   -> close();

	}

    header('Content-Type: application/json');
	echo json_encode($DATA);
?>
