<?php

    session_start();
    
    if( !isset($_SESSION['username']) ){
        ?>
        <script>
            alert("ERROR: Tu sesión ha caducado. Por favor reingresa al sistema.");
            location.href = "index.php";
       </script>
        <?php
        
    }else{
        include 'plantillas/header.php';
        include 'plantillas/base.php';
    }
    
?>

<html>
    
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
        <script src="javascript/mainMenu.js"></script>
        <script src="javascript/commonFunctions.js"></script>
    </head>
  
    <body>

        <div class="container-fluid h-100">
            <div class="row">
                
			    <div class="d-flex justify-content-center brand_logo_container">
                    <div class="col-6 col-md-3" id="containtAdministration">
                    </div>
                </div>
               
			    <div class="d-flex justify-content-center brand_logo_container">
                    <div class="col-6 col-md-3" id="containtBuildSite">
                    </div>
                </div>
                
			    <div class="d-flex justify-content-center brand_logo_container">
                    <div class="col-3 col-md-3" id="containtBudget">
                    </div>
                </div>
                
                <div class="d-flex justify-content-center brand_logo_container">
                    <div class="col-3 col-md-3" id="containtAcquisition">
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>
  
    <foot>
        <?php
            include 'plantillas/footer.php';
        ?>  
    </foot>
 
  <style type="text/css">

    
    Label {
        display: inline-block;
	    width: 100px;
    }
    
    button:hover, .button:hover {
        opacity: 0.8;
    }

    
  </style>
 
 
</html>
