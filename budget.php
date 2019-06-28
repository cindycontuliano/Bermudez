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
        
        <div class="container-fluid h-100">
            <div class="row">
                <div class="col-4 col-md-4">
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#CreateProjectForm">Crear Proyecto</button>
                    </div>
                </div>
               
			    <div class="col-4 col-md-4">
			        <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#AddProductsMaster">Cargar Productos</button>
                    </div>
                </div>
                
			    <div class="col-4 col-md-4">
                    <div class="d-flex justify-content-center brand_logo_container">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#ProjectOptionsForm">Gestionar Proyectos</button>
                    </div>
                </div>
            </div>
        </div>

<!------------------------------ CREATE A NEW PROJECT ---------------------------------------->
        <!-- Modal -->
        <div id="CreateProjectForm" class="modal fade" role="dialog">
            <div class="modal-dialog">
        
            <!-- Modal content-->
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Cargar Proyecto</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label for="ProjectExcel">Archivo Excel</label>
                        <div class="file-field">
                            <div class="btn btn-primary btn-sm float-left">
                                <input type="file" id="ProjectExcel">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" onclick="CreateProject()">Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
<!------------------------------ LOAD THE PRODUCTS MASTER ---------------------------------------->
        <!-- Modal -->
        <div id="AddProductsMaster" class="modal fade" role="dialog">
            <div class="modal-dialog">
        
            <!-- Modal content-->
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Cargar Maestro de Materiales</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label for="ProductsExcel">Archivo Excel</label>
                        <div class="file-field">
                            <div class="btn btn-primary btn-sm float-left">
                                <input type="file" id="ProductsExcel">
                            </div>
                        </div>
                    </div>
              
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" onclick="AddProducts()">Aceptar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

<!------------------------------ MANIPULATE A PROJECT ---------------------------------------->
        <!-- Modal -->
        <div id="ProjectOptionsForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
        
            <!-- Modal content-->
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Gestión de Proyectos</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ProjectList">Seleccione un Proyecto</label>
                            <select class="form-control" id="ProjectList"></select>
                        </div>
                        
                        <div class="form-group">
                            <label>Acciones</label>
                            <div class="custom-control">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <button class="btn btn-primary" onclick="LoadProjectData()">Actualizar Proyecto</button>
                                    </li>

                                    <li class="list-group-item">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#CloseProject">Cerrar Proyecto</button>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <button class="btn btn-primary" onclick="LoadProjectToOpen()">Abrir Proyecto</button>
                                    </li>

                                    <li class="list-group-item">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#DeleteProject">Eliminar Proyecto</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!------------------------------ UPDATE A PROJECT ---------------------------------------->
                        <!-- Modal -->
                        <div id="UpdateProject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                        
                            <!-- Modal content-->
                                <div class="modal-content">
                                    
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Actualizar Información del Proyecto <p id="projectToUpdate"></p></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                              
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="newProjectName">Nombre</label>
                                            <input id="newProjectName" type="text" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="usernameOwner">Administrador de Obra</label>
                                            <select class="form-control" id="userList1"></select>
                                        </div>
                                        <div class="form-group">
                                            <label for="usernameGrocer">Bodeguero de la Obra</label>
                                            <select class="form-control" id="userList2"></select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="startDate">Fecha de Inicio</label>
                                            <input id="startDate" type="date" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="finishDate">Fecha de Termino (Contractual)</label>
                                            <input id="finishDate" type="date" class="form-control" placeholder="">
                                        </div>
                                    </div>
                              
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-primary" onclick="UpdateProject()">Actualizar Proyecto</button>
                                        <button type="button" class="btn btn-danger" id="bttnCloseUpdateProject" >Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!------------------------------ CLOSE A PROJECT ---------------------------------------->
                        <!-- Modal -->
                        <div id="CloseProject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                        
                            <!-- Modal content-->
                                <div class="modal-content">
                                    
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cerrar Proyecto </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                              
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>¿Estás seguro que deseas cerrar el proyecto?<p id="projectToClose"></p></p>
                                        </div>
                                    </div>
                              
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-primary" onclick="CloseProject()">Cerrar Proyecto</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!------------------------------ OPEN A PROJECT ---------------------------------------->
                        <!-- Modal -->
                        <div id="OpenProject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                        
                            <!-- Modal content-->
                                <div class="modal-content">
                                    
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Abrir Proyecto </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                              
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="ProjectsToOpen">Seleccione un Proyecto</label>
                                            <select class="form-control" id="ProjectsToOpen"></select>
                                        </div>
                                    </div>
                              
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-primary" onclick="OpenProject()">Abrir Proyecto</button>
                                        <button type="button" class="btn btn-danger" id="bttnCloseOpenProject">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!------------------------------ DELETE A PROJECT ---------------------------------------->
                        <!-- Modal -->
                        <div id="DeleteProject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                        
                            <!-- Modal content-->
                                <div class="modal-content">
                                    
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Eliminar Proyecto </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                              
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>¿Estás seguro que deseas eliminar el proyecto?<p id="projectToDelete"></p></p>
                                        </div>
                                    </div>
                              
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-primary" onclick="DeleteProject()">Eliminar Proyecto</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
              
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
</html>
