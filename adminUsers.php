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

        <div class="container-fluid h-100">
            <div class="row">
                <div class="col-3 col-md-3">
                    <div class="d-flex justify-content-center">
                        <label for="OpenAddUser"><b>Agregar Usuario</b></label>
                        <button class="btn btn-default btn-circle" id="OpenAddUser" data-toggle="modal" data-target="#AddUserForm">
                            <img class="brand_logo" alt="Logo" src="img/addUser.png">
                        </button>
                    </div>
                </div>
               
			    <div class="col-3 col-md-3">
			        <div class="d-flex justify-content-center">
                        <label for="OpenModifyUser"><b>Modificar Datos</b></label>
                        <button class="btn btn-default btn-circle" id="OpenModifyUser" data-toggle="modal" data-target="#LoadUserForm">
                            <img class="brand_logo" alt="Logo" src="img/updateUser.png">
                        </button>
                    </div>
                </div>
                
			    <div class="col-3 col-md-3">
                    <div class="d-flex justify-content-center brand_logo_container">
                        <label for="OpenDeleteUser"><b>Eliminar Usuario</b></label>
                        <button class="btn btn-default btn-circle" id="OpenDeleteUser" data-toggle="modal" data-target="#DeleteUserForm">
                            <img class="brand_logo" alt="Logo" src="img/deleteUser.png">
                        </button>
                    </div>
                </div>
                
                <div class="col-3 col-md-3">
                    <div class="d-flex justify-content-center brand_logo_container">
                        <label for="OpenListUsers"><b>Lista de Usuarios</b></label>
                        <button class="btn btn-default btn-circle" id="OpenListUsers" onclick="GetListUsers()">
                            <img class="brand_logo" alt="Logo" src="img/userList.png">
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    
<!------------------------------ ADD A NEW USER FORM ---------------------------------------->
        <!-- Modal -->
        <div id="AddUserForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
        
            <!-- Modal content-->
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ingrese Datos del Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="addUname">Rut</label>
                            <input id="addUname" type="text" class="form-control" placeholder="Ingrese Rut">
                        </div>
                        
                        <div class="form-group">
                            <label>Permiso(s)</label>
                            <div class="custom-control custom-checkbox">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <input type="checkbox" class="custom-control-input" id="AdminType">
                                        <label class="custom-control-label" for="AdminType">Administración Usuarios</label>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <input type="checkbox" class="custom-control-input" id="BuildsiteType">
                                        <label class="custom-control-label" for="BuildsiteType">Administración Obra</label>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <input type="checkbox" class="custom-control-input" id="SupervisorType">
                                        <label class="custom-control-label" for="SupervisorType">Administración Supervisor</label>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <input type="checkbox" class="custom-control-input" id="BudgetType">
                                        <label class="custom-control-label" for="BudgetType">Administración Presupuesto</label>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <input type="checkbox" class="custom-control-input" id="AcquisitionType">
                                        <label class="custom-control-label" for="AcquisitionType">Administración Adquisiciones</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="addName">Nombre</label>
                            <input id="addName" type="text" class="form-control" placeholder="Ingrese Nombre">
                        </div>
                        
                        <div class="form-group">
                            <label for="addLastname">Apellido</label>
                            <input id="addLastname" type="text" class="form-control" placeholder="Ingrese Apellido">
                        </div>
                        
                        <div class="form-group">
                            <label for="addEmail">Correo</label>
                            <input id="addEmail" type="text" class="form-control" placeholder="Ingrese Correo">
                        </div>
                        
                        <div class="form-group">
                            <label for="addPhone">Teléfono (Opcional)</label>
                            <input id="addPhone" type="text" class="form-control" placeholder="Ingrese Teléfono">
                        </div>
                    </div>
              
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" onclick="AddUser()">Agregar Usuario</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
<!------------------------------ SEARCH A USER ---------------------------------------->
        <!-- Modal -->
        <div id="LoadUserForm" class="modal fade" role="dialog">
            <div class="modal-dialog">
        
            <!-- Modal content-->
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ingrese Rut del Usuario a Editar</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="searchUname">Rut</label>
                            <input id="searchUname" type="text" class="form-control" placeholder="Ingrese Rut">
                        </div>
                        
            <!------------------------------ EDIT USER´S DATAS ---------------------------------------->
                        <!-- Modal -->
                        <div id="SearchResultsForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                        
                            <!-- Modal content-->
                                <div class="modal-content">
                                    
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Resultados de la Búsqueda</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                              
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="usernamePrevious">Rut</label>
                                            <input id="usernamePrevious" type="text" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Permiso(s)</label>
                                            <div class="custom-control custom-checkbox">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <input type="checkbox" class="custom-control-input" id="AdminPermission">
                                                        <label class="custom-control-label" for="AdminPermission">Administración Usuarios</label>
                                                    </li>
                                                    
                                                    <li class="list-group-item">
                                                        <input type="checkbox" class="custom-control-input" id="BuildsitePermission">
                                                        <label class="custom-control-label" for="BuildsitePermission">Administración Obra</label>
                                                    </li>
                                                    
                                                    <li class="list-group-item">
                                                        <input type="checkbox" class="custom-control-input" id="SupervisorPermission">
                                                        <label class="custom-control-label" for="SupervisorPermission">Administración Supervisor</label>
                                                    </li>
                                                    
                                                    <li class="list-group-item">
                                                        <input type="checkbox" class="custom-control-input" id="BudgetPermission">
                                                        <label class="custom-control-label" for="BudgetPermission">Administración Presupuesto</label>
                                                    </li>
                                                    
                                                    <li class="list-group-item">
                                                        <input type="checkbox" class="custom-control-input" id="AcquisitionPermission">
                                                        <label class="custom-control-label" for="AcquisitionPermission">Administración Adquisiciones</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="resultName">Nombre</label>
                                            <input id="resultName" type="text" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="resultLastname">Apellido</label>
                                            <input id="resultLastname" type="text" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="resultEmail">Correo</label>
                                            <input id="resultEmail" type="text" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="resultPhone">Teléfono (Opcional)</label>
                                            <input id="resultPhone" type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                              
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-primary" onclick="UpdateUser()">Confirmar Cambios</button>
                                        <button type="button" class="btn btn-danger" id="bttnCloseUpdateUser">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" onclick="LoadUser()">Buscar Usuario</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
     
<!------------------------------ DELETE A USER ---------------------------------------->
        <!-- Modal -->
        <div id="DeleteUserForm" class="modal fade" role="dialog">
            <div class="modal-dialog">
        
            <!-- Modal content-->
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ingrese Rut del Usuario a Eliminar</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="deleteUname">Rut</label>
                            <input id="deleteUname" type="text" class="form-control" placeholder="Ingrese Rut">
                        </div>
                    </div>
              
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" onclick="DeleteUser()">Eliminar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 

 <!------------------------------ TABLE WITH THE SYSTEM´S USERS ---------------------------------------->       
        <div id="ListUsersForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Usuarios del Sistema</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
            
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="table-reponsive-xl">
                            <table class="table" id="ListUsers">
                                
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
            						<th scope="col">Rut</th>
            						<th scope="col">Permisos</th>
            						<th scope="col">Nombre</th>
            						<th scope="col">Apellido</th>
            						<th scope="col">Correo</th>
            						<th scope="col">Teléfono</th>
                                </tr>
                            </thead>
                            
                            </table>
                        </div>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
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
    
    <style type="css/text">
        select{
            width: 300px;
        }
    </style>
</html>
