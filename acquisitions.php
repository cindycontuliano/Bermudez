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
    
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, user-scalable=no">
        <script src="javascript/acquisitions.js"></script>
        <script src="javascript/commonFunctions.js"></script>
  </head>
  
  <body>
        <div class="container-fluid">
            <div class="d-flex justify-content-center h-100">
                <div class="user_card">
                    <div class="d-flex justify-content-center Title">
					    <div class="title">
						    <h5>Obras Activas</h5>
					    </div>
				    </div>
	                <div class="d-flex justify-content-center ListProjects">
	                    <select multiple class="form-control" id="ProjectList"> </select>
				    </div>
				    <div class="d-flex justify-content-center SPMPending">
				        <div class="row ">
				            <div class="col-6">
				                <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".listaAllSPM" >Ver Todo</button> 
				                <div class="modal fade listaAllSPM" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">SPM Pendientes</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                
                                            </div>
                                            <div class="modal-body">
                                               <table class ="table table-responsive" id="allSPMs"></table>
                                               
                                            </div>   
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".enviar">Enviar</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
				            </div>
				            <div class="col-6">
				                <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".listaSPM">SPM Pendientes</button>
                                <div class="modal listaSPM" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">SPM Pendientes</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class ="table table-responsive" id="SPMs"></table>
                                            </div>   
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" onclick="saveOC()" >Guardar</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>         
				            </div>
				        </div>
				    </div>
                </div>
            </div>
        </div>

        

        <?php
            include 'plantillas/footer.php';
        ?>
  </body>

  <style type="text/css">
    .user_card {
        margin-top:80px;
        height: 400px;
    }

  </style>
 
 
</html>
