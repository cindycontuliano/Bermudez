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
    
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        
        <script src="javascript/commonFunctions.js"></script>
  </head>
  
  <body>
        <h1>This website is in maintenance</h1>
        <?php
            include 'plantillas/footer.php';
        ?>
  </body>

  <style type="text/css">

  </style>
 
 
</html>
