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
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script src="javascript/adminUsers.js"></script>
        <script src="javascript/commonFunctions.js"></script>
    
    </head>
  
    <body>

        <div class="container">
            <div class="containtElement">
                <label for="OpenAddUser"><b>Agregar Usuario</b></label>
                <button id="OpenAddUser" onclick="OpenAddUser()"></button>
            </div>
                
            <div class="containtElement">
                <label for="OpenModifyUser"><b>Modificar Datos</b></label>
                <button id="OpenModifyUser" onclick="OpenLoadUser()"></button>
            </div>
            
            <div class="containtElement">
                <label for="OpenDeleteUser"><b>Eliminar Usuario</b></label>
                <button id="OpenDeleteUser" onclick="OpenDeleteUser()"></button>
            </div>
                
            <div class="containtElement">
                <label for="OpenListUsers"><b>Consultar Usuarios</b></label>
                <button id="OpenListUsers" onclick="OpenListUsers()"></button>
            </div>
        </div>
        
        
<!-- HIDDEN CODES -->

    <!-- ADD A NEW USER-->
        <div id="AddUserForm">
            <center>
                <h2>Ingrese Datos del Usuario</h2>
            </center>
            
            <div class="internalContainer">
                <label for="addUname"><b>Rut</b></label>
                <input type="text" id="addUname">
                
                <label for="addType"><b>Tipo</b></label>
                <div>
                    <label for="AdminType">Administrador</label>
                    <input id="AdminType" type="checkbox">
                    
                    <label for="BuildsiteType">Obra</label>
                    <input id="BuildsiteType" type="checkbox">
                    
                    <label for="SupervisorType">Supervisor</label>
                    <input id="SupervisorType" type="checkbox">
                    
                    <label for="BudgetType">Presupuesto</label>
                    <input id="BudgetType" type="checkbox">
                    
                    <label for="AcquisitionType">Adquisiciones</label>
                    <input id="AcquisitionType" type="checkbox">
				</div>
                
                <label for="addName"><b>Nombre</b></label>
                <input type="text" id="addName">
                
                <label for="addLastname"><b>Apellido</b></label>
                <input type="text" id="addLastname">
                
                <label for="addEmail"><b>Correo</b></label>
                <input type="text" id="addEmail">
                
                <label for="addPhone"><b>Teléfono (Opcional)</b></label>
                <input type="text" id="addPhone">
            </div>
            
            <center>
                <div>
                    <button onclick="AddUser()">Aceptar</button>
                    <button onclick="CloseAddUser()">Cancelar</button>
                </div>
            </center>
        </div>
    <!-- END ADD A NEW USER -->
        
        
    <!-- SEARCH A USER -->
        <div id="LoadUserForm">
            <center>
                <h2>Ingrese Rut</h2>
            </center>
            
            <div class="internalContainer">
                <label for="searchUname"><b>Rut</b></label>
                <input type="text" id="searchUname">
            </div>
            
            <center>
                <div>
                    <button onclick="LoadUser()">Aceptar</button>
                    <button onclick="CloseLoadUser()">Cancelar</button>
                </div>
            </center>
        </div>
    <!-- END SEARCH A USER -->
    
    
    <!-- RESULT OF A SEARCH -->   
        <div id="SearchResultsForm">
            <center>
                <h2>Resultados de la búsqueda</h2>
            </center>
           
            <div class="internalContainer">
                <label for="usernamePrevious"><b>Rut Usuario</b></label>
                <input id="usernamePrevious" type="text">
                
                <label for="resultType"><b>Tipo</b></label>
                <div>
                    <label for="AdminPermission">Administrador</label>
                    <input id="AdminPermission" type="checkbox">
                    
                    <label for="BuildsitePermission">Obra</label>
                    <input id="BuildsitePermission" type="checkbox">
                    
                    <label for="SupervisorPermission">Supervisor</label>
                    <input id="SupervisorPermission" type="checkbox">
                    
                    <label for="BudgetPermission">Presupuesto</label>
                    <input id="BudgetPermission" type="checkbox">
                    
                    <label for="AcquisitionPermission">Adquisiciones</label>
                    <input id="AcquisitionPermission" type="checkbox">
				</div>
                
                <label for="resultName"><b>Nombre</b></label>
                <input type="text" id="resultName">
                
                <label for="resultLastname"><b>Apellido</b></label>
                <input type="text" id="resultLastname">
                
                <label for="resultEmail"><b>Correo</b></label>
                <input type="text" id="resultEmail">
                
                <label for="resultPhone"><b>Teléfono (Opcional)</b></label>
                <input type="text" id="resultPhone">
            </div>
            
            <center>
                <div>
                    <button id="ButtonModifyUser">Aceptar</button>
                    <button onclick="CloseSearchResults()">Cancelar</button>
                </div>
            </center>
        </div>
     <!-- END RESULT OF A SEARCH -->
     
     
        
    <!-- DELETE A USER-->
        <div id="DeleteUserForm">
            <center>
                <h2>Ingrese Rut a Eliminar</h2>
            </center>
            
            <div class="internalContainer">
                <label for="deleteUname"><b>Rut</b></label>
                <input type="text" id="deleteUname">
            </div>
            
            <center>
                <div>
                    <button onclick="DeleteUser()">Aceptar</button>
                    <button onclick="CloseDeleteUser()">Cancelar</button>
                </div>
            </center>
        </div>
    <!-- END DELETE A USER-->
    
    
    <!-- LIST OF SYSTEM´S USERS -->
        <center>
            <div id="ListUsersForm">
                <h2>Lista de Usuarios</h2>
                
                <div class="InternalListUsers">
                    <table id="ListUsers">
    					<tr>
    						<th>Rut</th>
    						<th>Permisos</th>
    						<th>Nombre</th>
    						<th>Apellido</th>
    						<th>Correo</th>
    						<th>Teléfono</th>
    					</tr>
    				</table>
                </div>
                
                <button onclick="CloseListUsers()">Aceptar</button>
            </div> 
        </center>
       
    
    
    <!-- END LIST -->
    
    </body>
  
    <foot>
        <?php
            include 'plantillas/footer.php';
        ?>  
    </foot>
 
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

    .container {
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
    
    .internalContainer{
        border: 1px solid red;
        margin-left: 5%;
        margin-right: 5%;
        margin-bottom: 5%;
    }
    
    .internalListUsers {
        padding-top: 2%;
        padding-bottom:5%;
        margin-bottom: 5%;
        height: 150px;
        border: 1px solid red;
        border-collapse: collapse;
        overflow: auto;
    }
    
    #AddUserForm, #SearchResultsForm {
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
    
    #LoadUserForm, #DeleteUserForm {
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        width: 500px;
        margin-left: 30%;
        padding-bottom: 2%;
        background: white;
        border: 1px solid blue;
    }
    
    #ListUsersForm {
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        width: 80%;
        margin-left: 10%;
        margin-right: 10%;
        padding-bottom: 2%;
        background: white;
        border: 1px solid blue;
    }
    
    #OpenAddUser {
        background-image:url(img/addUser.png);
  	    background-repeat:no-repeat;
  	    height:120px;
  	    width:120px;
  	    background-position:center;
    }
    
    #OpenModifyUser {
        background-image:url(img/modifyUser.png);
  	    background-repeat:no-repeat;
  	    height:120px;
  	    width:120px;
  	    background-position:center;
    }
    
    #OpenDeleteUser {
        background-image:url(img/deleteUser.png);
  	    background-repeat:no-repeat;
  	    height:120px;
  	    width:120px;
  	    background-position:center;
    }
    
    #OpenListUsers {
        background-image:url(img/searchUser.png);
  	    background-repeat:no-repeat;
  	    height:120px;
  	    width:120px;
  	    background-position:center;
    }
    
  </style>
 
 
</html>
