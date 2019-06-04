<?php 
    //session_start();
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

    #ChangePasswordForm {
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
    
 </style>

 <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030"><meta name="viewport" content="width=device-width, user-scalable=no">
    

    
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
                     
                         
                        <div class="dropdown d-flex flex-row-reverse">
                         
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                   <span class="icon-cog"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" onclick ="OpenChangePassword()"> <span class="icon-cw"> </span>Cambiar Clave</button>
                                    <button class="dropdown-item" id="logout" onclick ="Logout()"><span class="icon-user"> </span>Cerrar Sesión</button>
                                </div>
                        </div>   
                                         
                    </div>
                </div>
            </div>

            
            <div id="ChangePasswordForm">
                <center>
                    <h2>Cambio de Clave</h2>
                </center>
                
                <div class="internalContainer">
        
                    <label for="oldPassword"><b>Clave Antigua</b></label>
                    <input type="password" id="oldPassword">
                    
                    <label for="newPassword"><b>Clave Nueva</b></label>
                    <input type="password" id="newPassword">
                    
                    <label for="confirmNewPassword"><b>Confirmar Clave Nueva</b></label>
                    <input type="password" id="confirmNewPassword">
                </div>
                
                <center>
                    <div>
                        <button onclick="ChangePassword()">Aceptar</button>
                        <button onclick="CloseChangePassword()">Cancelar</button>
                    </div>
                </center>
            </div>
        </header>
    </body>
 </html>
