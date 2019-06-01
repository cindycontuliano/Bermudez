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
        
        
        <script src="javascript/buildingSite.js"></script>
        <script src="javascript/commonFunctions.js"></script>
    
    </head>
  
    <body>

        <div class="mainContainer">
            <div class="containtElement">
                <label for="OpenCreateSPM"><b>Ingresar SPM</b></label>
                <button id="OpenCreateSPM" onclick="OpenCreateSPM()"></button>
            </div>
        </div>
        
        
<!------------------------------ SPM FORM ---------------------------------------->
        <div id="SPMForm">
            <center>
                <h2>Agregar SPM</h2>
            </center>
            
            <div class="internalContainerSPM">
                <center>
                    <table id="ListSPM">
    					<tr>
    						<th>Item</th>
    						<th>Producto</th>
    						<th>Cantidad</th>
    						<th>Partida Asociada</th>
    						<th>Fecha Despacho</th>
    					</tr>
    				</table>
				</center>
            </div>
            
            <div class="containerToAddItem">
                <label for="productSPM">Producto</label>
                <select id="ProductSPM"></select>
                
                <label for="quantitySPM">Cantidad</label>
                <input id="quantitySPM" type="text">
                
                <label for="listStages">Partidas</label>
                <select id="listStages"></select>
                
                <label for="dateRequired">Fecha de Despacho</label>
                <input id="dateRquired" type="date">
                
                <center>
                    <button onclick="AddNewItem()">Agregar Item</button>
                </center>
            </div>
            
            <div>
                <center>
                    <button onclick="ValidateSPMForm()">Aceptar</button>
                    <button onclick="CloseSPMForm()">Cancelar</button>
                </center>
            </div>
                
        </div>
        
        
    
    <foot>
        <?php
            include 'plantillas/footer.php';
        ?>  
    </foot>
    
</body>
  
  <style type="text/css">
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
    
    input, select {
        width: 100%;
        padding: 12px 20px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        text-align: left;
        margin-bottom: 3%;
    }
    
    Label {
        display: inline-block;
	    width: 100px;
    }
    
    button:hover, .button:hover {
        opacity: 0.8;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 80%;
        background: white;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .mainContainer {
        height: 50%;
        margin-top: 5%;
        margin-right: 20%;
        margin-left: 20%;
        padding-right: 5%;
        padding-left: 5%;
    }
    
    .containtElement {
        margin-right: 5%;
        width: 120px;
        float: left;
    }
    
    .internalContainerSPM {
        padding-top: 2%;
        padding-bottom:5%;
        margin-bottom: 5%;
        height: 150px;
        border: 1px solid red;
        border-collapse: collapse;
        overflow: auto;
    }
    
    .containerToAddItem {
        padding-top: 2%;
        padding-bottom:5%;
        margin-bottom: 5%;
        height: 300px;
        border: 1px solid red;
        border-collapse: collapse;
        overflow: auto;
    }
    
    #SPMForm {
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        width: 500px;
        margin-left: 30%;
        padding-bottom: 2%;
        background: white;
        border: 1px solid blue;
        height: 600px;
        overflow: auto;
    }
    

    #OpenCreateSPM {
        background-image:url(img/addUser.png);
  	    background-repeat:no-repeat;
  	    height:120px;
  	    width:120px;
  	    background-position:center;
    }
    
  </style>
 
 
</html>
