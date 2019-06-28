<?php
    include 'plantillas/base.php';
?>

<style type="text/css">
    
    .main-header{
        height:100px;
        background: linear-gradient(to top, #005bbf 20%, black);
        /*background: linear-gradient(to bottom, #005bbf, white);*/
        padding: 1%;
        
    }
    header {
        padding:0px;
    }
    
    #titlePage{
        font-size:220%;
        color:white;
        font-weight:bold;
        
    }
    
    #LogoBermudez{
        width:60%;
        float: left;
        margin-top:1px;
    }
    
 </style>

 <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        
    	<meta name="viewport" content="width=device-width, user-scalable=no">
    </head> 
    <body>
        <header >
            <div class ="container-fluid main-header">
                
                <div class = "row">
                    <div class = "col-2 col-md-3">
                        <div class="row">
                            <div class="col-1 col-md-4" id= "ContainerReturnMainMenu">
                                <div class="d-flex align-items-end">
                                    <button class="btn btn-warning" onclick ="ReturnMainMenu()"><span class="icon-arrow-long-left"> </span></button>
                                </div>    
                            </div>
                            <div class="col-md-8">
                          
                            </div>
                        </div>
                    </div> 
                   
                    <div class = "col-7 col-md-6">
                        <div class="d-flex justify-content-center">
                        <h1 id="titlePage"></h1>
                        </div>
                    </div> 

                    <div class = "col-3 col-md-3">
                     
                         
                        <div class="dropdown d-flex flex-row-reverse" id="containerDropdown">
                         
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                               <span class="icon-cog"></span>
                            </button>
                            
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" data-toggle="modal" data-target="#ChangePasswordForm"> <span class="icon-cw"> </span>Cambiar Clave</button>
                                <button class="dropdown-item" id="logout" onclick ="Logout()"><span class="icon-user"> </span>Cerrar Sesión</button>
                            </div>
                                
                        <!-- Modal -->
                            <div class="modal fade" id="ChangePasswordForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                
                                    <!-- Modal Header -->  
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Cambiar Clave</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                  
                                    <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="oldPassword">Clave Antigua</label>
                                                <input id="oldPassword" type="password" class="form-control" placeholder="Ingrese Clave Antigua">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="newPassword">Clave Nueva</label>
                                                <input id="newPassword" type="password" class="form-control" placeholder="Ingrese Clave Nueva">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="confirmNewPassword">Confirmar Clave Nueva</label>
                                                <input id="confirmNewPassword" type="password" class="form-control" placeholder="Confirme Clave Nueva">
                                            </div>
                                        </div>
                                        
                                    <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="ChangePassword()">Cambiar Clave</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                        </div>
                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>
    </body>
 </html>
