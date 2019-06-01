<?php 
    session_start();
    include 'plantillas/base.php';
    

    
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <script src="javascript/login.js"></script>
    <script src="javascript/commonFunctions.js"></script>
    
  </head>
  
  <body>

        
   
    <header>
        
        <?php 
        //  include 'plantillas/header.php'; 
        ?>   
    </header>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="img/img_login.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form>
						<div class="input-group mb-3">
							<input id="uname" type="text" placeholder="Rut" name="uname">
						</div>
						<div class="input-group mb-1">
					    	<input id="psw" type="password" placeholder="Clave" name="psw">
						</div>
					</form>
				</div>
				<div class="d-flex justify-content-center login_container mb-1">
					<input class="btn login_btn active" type="button" name="button" onclick="Validate()" value="Ingresar">
				</div>

				<div class="d-flex justify-content-end links">
				    <span class="psw"><a href="changePass.php">Recuperar Clave</a></span>
				</div>
			
			</div>
		</div>
	</div>
	

        
</body>
  
    <style type="text/css">

        body {
       
            /*background: linear-gradient(to bottom, #005bbf 20%, black); */
            font-family: Arial, Helvetica, sans-serif;
            background-image: url(img/EmpresasBermudez.jpg);
            background-size: cover; 
           
            background-attachment: fixed;

            
            
        }
        @media (max-width: 768px) {

            body {
                background-image: url(img/EmpresasBermudezMovil.jpg);
                background-size: cover;
                background-attachment: fixed;
           
            }
            
            .user_card {
                background-color: #f39c12;
           
            }

        }
		
		.brand_logo_container {
			position: absolute;
			height: 170px;
			width: 170px;
			top:-75px;
			border-radius: 50%;
			text-align: center;
		}
		
		.brand_logo {
			height: 150px;
			width: 150px;
			border-radius: 50%;
			border: 2px solid white;
		}
		
		.form_container {
			margin-top: 100px;
		}



        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            -moz-border-radius: 37px 37px 37px 37px;
            -webkit-border-radius: 37px 37px 37px 37px;
        }
        

        
        button{
            display:none;
        }
        
        .login_btn{
            background-color: #f39c12;
            color: white;
            padding: 14px 20px;
            margin: 2% 25% 2%;
            cursor: pointer;
            width: 50%;
            font-size: 110%;
        }
        
        a{
            color:white;
        }
        span.psw {
           
            float: right;
            padding-top: 16px;
            font-size:20px;
            color:white;
           
        }
        .user_card {
            margin-top:150px;
            background: linear-gradient(to top, #005bbf 20%, white);
        }
    


        
    </style>
 
</html>
