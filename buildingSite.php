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
        
        
        <script src="javascript/buildingSite.js"></script>
        <script src="javascript/commonFunctions.js"></script>
    </head>
  
    <body>
        
        <div class="modal-content" id="containerProjects">
            <div class="modal-header">
                <h5 class="modal-title">Lista de Obras</h5>
            </div>
            
            <div class="modal-body">
                <div class="form-group">
                    <label for="projectList">Seleccionar Obra</label>
                    <select class="form-control" id="projectList"></select>
                </div>
            </div>
        </div>
        
        <div>
            <div class="d-flex justify-content-center" id="containerSendSPM">
                <button class="btn btn-primary btn-space" data-toggle="modal" data-target="#SPMForm">Agregar SPM</button>
            </div>
        </div>
        
    <!------------------------------ SPM FORM ---------------------------------------->
        <!-- Modal -->
        <div id="SPMForm" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable">
        
            <!-- Modal content-->
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar SPM</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label for="listStages">Partida</label>
                                <select id="listStages" class="form-control"></select>
                            </div>
                            
                            <div class="form-group">
                                <label for="productFilter">Filtrar Productos</label>
                                <input id="productFilter" type="text" class="form-control" placeholder="Ingrese Filtro">
                            </div>
                            
                            <div class="form-group">
                                <label for="productSPM">Producto<p id="resultsProducts"></p></label>
                                <select id="productSPM" class="form-control"></select>
                            </div>
                            
                            <div class="form-group">
                                <label for="familyProduct">Familia</label>
                                <input id="familyProduct" type="text" class="form-control" placeholder="Familia del Producto">
                            </div>
                            
                            <div class="form-group">
                                <label for="quantitySPM">Cantidad Disponible <p id="unitMeasure"></p></label>
                                <input id="quantitySPM" type="text" class="form-control" placeholder="Cantidad del Producto">
                            </div>
                            
                            <div class="form-group">
                                <label for="dateRequired">Fecha de Despacho</label>
                                <input id="dateRequired" type="date" class="form-control">
                            </div>
    
                            <div class="form-group">
                                <label for="observationSPM">Observación (Opcional)</label>
                                <input id="observationSPM" type="text" class="form-control">
                            </div>
                        </div>
                        
                <!------------------------------ ABSTRACT OF SPMS ---------------------------------------->       
                        <div id="abstractSpm" class="modal fade" style="width: 100%" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">
                    
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Resumen del Pedido</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                            
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="table-reponsive-xl">
                                            <table class="table" id="ListSPM">
                                                
                                            <thead>
                                                <tr>
                                                    <th scope="col">Item</th>
                            						<th scope="col">Cod. Flexline</th>
                            						<th scope="col">Producto</th>
                            						<th scope="col">Familia</th>
                            						<th scope="col">Cantidad</th>
                            						<th scope="col">Unidad</th>
                            						<th scope="col">Partida Asociada</th>
                            						<th scope="col">Fecha Despacho</th>
                            						<th scope="col">Observación</th>
                            						<th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            
                                            </table>
                                        </div>
                                        
                                        
                            <!------------------------------ EDIT ROW IN A TABLE ---------------------------------------->
                                        <div class="modal" id="editRow" class="col-12">
                                            <div class="modal-dialog">
                                                
                                                <div class="modal-content">
                                        
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Editar SPM</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                        
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="newQuantity">Cantidad Disponible <p id="editQuantity"></p></label>
                                                            <input id="newQuantity" type="text" class="form-control" placeholder="Ingrese Cantidad">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="newDateRequired">Fecha Despacho</label>
                                                            <input id="newDateRequired" type="date" class="form-control">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="newObservation">Observación (Opcional)</label>
                                                            <input id="newObservation" type="text" class="form-control" placeholder="Observaciones">
                                                        </div>
                                                    </div>
                                        
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-success" id="commitEdit">Aceptar</button>
                                                        <button id="bttnCloseEdition" type="button" class="btn btn-danger">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                        
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-success" onclick="ValidateSPMForm()">Registrar SPM</button>
                                        <button id="bttnCloseAbstract" type="button" class="btn btn-danger">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-success" onclick="AddNewItem()">Agregar Item</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#abstractSpm">Ir al Resumen</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    
        
    <!------------------------------ ABSTRACT OF SPM EMITTED ---------------------------------------->
        <!-- Modal -->
        <div id="modalValidateSPM" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable">
        
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Lista de SPM Emitidas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
              
                    <div class="modal-body" id="ListSPMEmitted">
                        <div class="table-reponsive">
                            <table class="table" id="spmEmitted">
                                
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Código SPM</th>
                                </tr>
                            </thead>
                            
                            </table>
                        </div>
                    </div>
              
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    
    <!------------------------------ DETAILS ABOUT A SPECIFY SPM ---------------------------------------->
        <div id="spmSpecify" class="modal fade" style="width: 100%" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Resumen del Pedido <p id="spmSpecifyId"></p></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
            
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="table-reponsive-xl">
                            <table class="table" id="spmDetails">
                                
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
            						<th scope="col">Cod. Flexline</th>
            						<th scope="col">Cod. Producto</th>
            						<th scope="col">Producto</th>
            						<th scope="col">Familia</th>
            						<th scope="col">Partida Asociada</th>
            						<th scope="col">Cantidad</th>
            						<th scope="col">Unidad</th>
            						<th scope="col">Fecha Despacho</th>
            						<th scope="col">Observación</th>
            						<th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            
                            </table>
                        </div>
                        
            <!------------------------------ DELETE SPM EMITTED ---------------------------------------->
                        <!-- Modal -->
                        <div id="deleteSPM" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                        
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Lista de SPM Emitidas</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                              
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>¿Estás seguro que deseas eliminar la SPM N° ?<p id="spmToDelete"></p></p>
                                        </div>
                                    </div>
                              
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-primary" onclick="DeleteSpm()">Eliminar SPM</button>
                                        <button id="bttnCloseDelete" type="button" class="btn btn-danger">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
        <!------------------------------ EDIT ROW IN A TABLE ---------------------------------------->
                        <div class="modal" id="editRow2" class="col-12">
                            <div class="modal-dialog">
                                
                                <div class="modal-content">
                        
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar SPM</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                        
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="newQuantity2">Cantidad <p id="editQuantity2"></p></label>
                                            <input id="newQuantity2" type="text" class="form-control" placeholder="Ingrese Cantidad">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="newDateRequired2">Fecha Despacho</label>
                                            <input id="newDateRequired2" type="date" class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="newObservation2">Observación (Opcional)</label>
                                            <input id="newObservation2" type="text" class="form-control" placeholder="Observaciones">
                                        </div>
                                    </div>
                        
                                    <!-- Modal footer -->
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-success" id="commitEdit2">Aceptar</button>
                                        <button id="bttnCloseEdition2" type="button" class="btn btn-danger">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-success" onclick="UpdateSpm()">Registrar SPM</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteSPM">Eliminar SPM</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Volver</button>
                    </div>
                </div>
            </div>
        </div>
    
    <foot>
        <?php
            include 'plantillas/footer.php';
        ?>  
    </foot>
    
</body>
  
  <style type="text/css">
  
    .btn-space{
        margin-left: 10px;
    }
  
    #containerProjects{
        display: none;
    }
    
    #spmDetails, #ListSPM{
        table-layout: fixed;
        word-wrap: break-word;
    }


  </style>
 
 
</html>
