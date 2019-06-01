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
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
        <script src="javascript/budget.js"></script>
        <script src="javascript/commonFunctions.js"></script>

    </head>
  
    <body>

        <div class="container">
            <div class="containtElement">
                <label for="OpenCreateProject"><b>Cargar Proyecto</b></label>
                <button id="OpenCreateProject" onclick="OpenCreateProject()"></button>
            </div>
        </div>
        
        <div class="container">
            <div class="containtElement">
                <label for="OpenLoadProducts"><b>Cargar Productos</b></label>
                <button id="OpenLoadProducts" onclick="OpenLoadProducts()"></button>
            </div>
        </div>
        
        <div class="container">
            <div class="containtElement">
                <label for="OpenProjectOptions"><b>Gestionar Proyectos</b></label>
                <button id="OpenProjectOptions" onclick="OpenProjectOptions()"></button>
            </div>
        </div>
        
<!--------------------------------------- CREATE A NEW PROJECT ----------------------------->
        <div id="CreateProjectForm">
            <center>
                <h2>Ingrese Datos del Proyecto</h2>
            </center>
            
            <div class="internalContainer">
                <label for="ExcelFile">Cargar Archivo Excel</label>
                <input type="file" id="ExcelFile" name="files[]">
            </div>
            
            <center>
                <div>
                    <button onclick="CreateProject()">Aceptar</button>
                    <button onclick="CloseCreateProject()">Cancelar</button>
                </div>
            </center>
        </div>
        
<!--------------------------------------- LOAD PRODUCTS ----------------------------->
        <div id="LoadProductsForm">
            <center>
                <h2>Ingrese Archivo Productos</h2>
            </center>
            
            <div class="internalContainer">
                <label for="ProductsExcel">Cargar Archivo Excel</label>
                <input type="file" id="ProductsExcel" name="files[]">
            </div>
            
            <center>
                <div>
                    <button onclick="LoadProducts()">Aceptar</button>
                    <button onclick="CloseLoadProductsForm()">Cancelar</button>
                </div>
            </center>
        </div>

<!--------------------------------------- PROJECT OPTIONS FORM ----------------------------->
        <div id="ProjectOptionsForm">
            <center>
                <h2>Editar Datos de un Proyecto</h2>
            </center>
            
            <div class="internalContainer">
                <label for="ProjectList">Nombre de Proyectos</label>
                <select id="ProjectList"></select>
            </div>
            
            <center>
                <div>
                    <button onclick="OpenProjectEditor()">Editar</button>
                    <button onclick="OpenProjectDelete()">Eliminar</button>
                    <button onclick="OpenAssignProject()">Asignar Proyecto</button>
                    <button onclick="OpenUnassignProject()">Desasignar Proyecto</button>
                    <button onclick="CloseProjectOptions()">Cancelar</button>
                </div>
            </center>
        </div>

        
<!--------------------------------------- PROJECT EDITOR FORM ----------------------------->
        <div id="ProjectEditorForm">
            <center>
                <h2>Editar Proyecto </h2><p id="projectNameToEdit"></p>
            </center>
            
            <div class="internalContainer">
                <label for="newProjectName">Nombre</label>
                <input id="newProjectName" type="text">
                
                <label for="startDate">Fecha de Inicio</label>
                <input id="startDate" type="date">
                
                <label for="finishDate">Fecha de Termino (Estimada)</label>
                <input id="finishDate" type="date">
            </div>
            
            <center>
                <div>
                    <button onclick="EditProject()">Aceptar</button>
                    <button onclick="CloseProjectEditor()">Cancelar</button>
                </div>
            </center>
        </div>
 
 
 <!--------------------------------------- PROJECT DELETE FORM ----------------------------->
        <div id="ProjectDeleteForm">
            <center>
                <h2>Eliminar Proyecto </h2><p id="projectNameToDelete"></p>
            </center>
            
            <div class="internalContainer">
                <p>¿Estás seguro de eliminar el proyecto junto con todas sus partidas?</p>
            </div>
            
            <center>
                <div>
                    <button onclick="DeleteProject()">Aceptar</button>
                    <button onclick="CloseProjectDelete()">Cancelar</button>
                </div>
            </center>
        </div>
        
<!--------------------------------------- FORM TO ASSIGN PROJECT ----------------------------->
        <div id="FormToAssignProject">
            <center>
                <h2>Asignar Proyecto </h2><p id="projectNameToAssign"></p>
            </center>
            
            <div class="internalContainer">
                <label for="UsersList">Lista de Usuarios</label>
                <select id="UsersList"></select>
            </div>
            
            <center>
                <div>
                    <button onclick="AssignProject()">Aceptar</button>
                    <button onclick="CloseAssignProject()">Cancelar</button>
                </div>
            </center>
        </div>
        
<!--------------------------------------- FORM TO UNASSIGN PROJECT ----------------------------->
        <div id="FormToUnassignProject">
            <center>
                <h2>Desasignar Proyecto </h2><p id="projectNameToUnassign"></p>
            </center>
            
            <div class="internalContainer">
                <label for="usernameToUnassign">Usuario Encargado</label>
                <input id="usernameToUnassign">
            </div>
            
            <center>
                <div>
                    <button onclick="UnassignProject()">Aceptar</button>
                    <button onclick="CloseUnassignProject()">Cancelar</button>
                </div>
            </center>
        </div> 
        
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

    .container {
        height: 50%;
        margin-top: 5%;
        margin-right: 20%;
        margin-left: 20%;
        padding-right: 5%;
        padding-left: 5%;
        float: left;
    }
    
    .containtElement {
        margin-right: 5%;
        width: 120px;
    }
    
    .internalContainer{
        border: 1px solid red;
        margin-left: 5%;
        margin-right: 5%;
        margin-bottom: 5%;
    }
    
    #OpenCreateProject {
        background-image:url(img/project.png);
  	    background-repeat:no-repeat;
  	    height:120px;
  	    width:120px;
  	    background-position:center;
    }
    
    #OpenLoadProducts {
        background-image:url(img/project.png);
  	    background-repeat:no-repeat;
  	    height:120px;
  	    width:120px;
  	    background-position:center;
    }
    
    #OpenProjectOptions {
        background-image:url(img/addUser.png);
  	    background-repeat:no-repeat;
  	    height:120px;
  	    width:120px;
  	    background-position:center;
    }
    
    #CreateProjectForm, #LoadProductsForm, #ProjectOptionsForm {
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        width: 500px;
        margin-left: 30%;
        padding-bottom: 2%;
        background: white;
        border: 1px solid blue;
        float:  left;
    }
    
    #ProjectEditorForm, #ProjectDeleteForm, #FormToAssignProject, #FormToUnassignProject {
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        width: 500px;
        margin-left: 30%;
        padding-bottom: 2%;
        background: white;
        border: 1px solid blue;
        float:  left;
    }

  </style>
 
 
</html>
