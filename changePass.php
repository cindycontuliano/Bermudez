<?php 
    include 'plantillas/base.php';
    include 'plantillas/header.php';
 
?>

<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        
        <meta name="viewport" content="width=device-width, user-scalable=no">
        
        <script src="javascript/commonFunctions.js"></script>
        <script src="javascript/changePass.js"></script>
    </head>

    <body>
    	<div class="container h-100">
		<div class="d-flex justify-content-center h-90">
			<div class="user_card">
			    <div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="img/img_login.png" class="brand_logo" alt="Logo">
					</div>
				</div>
			    <div class="d-flex align-items-baseline">
			        
			    </div>
			    
				<div class="d-flex justify-content-center form_container">
					<div>
						<div class="input-group mb-3">
							<input id="uname" type="text" placeholder="Rut">
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-center login_container mb-1">
					<input class="btn login_btn active" type="button" name="button" onclick="ChangePass()" value="Aceptar">
				</div>

				
			
			</div>
		</div>
	</div>

    <footer>
        <?php
            include 'plantillas/footer.php';
        ?>
    </footer>
        
  </body>
 
  <style type="text/css">
    .user_card {
		margin-top:100px;	
		height: 400px;
	}
	
	button{
        display:none;
    }
        
    .form_container {
        
        
    
        
    }
  </style>
 
</html>