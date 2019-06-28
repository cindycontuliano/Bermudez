 window.onload      = LoadConfiguration;
 

 function LoadConfiguration(){
    
    document.getElementById("titlePage").innerHTML  = "Gestión de Adquisiciones"; 
    LoadAllSPM();
    LoadProjects();
 /*
    $('.listaSPM').on('show.bs.modal', function () {
        //alert("hola");
        //LoadProjects();
        LoadSPMforProject(); 
        
    });
    
    
    
    $('.listaAllSPM').on('show.bs.modal', function () {
        //alert("hola");
        //LoadProjects();
        LoadAllSPM(); 
        
    });
   */
    //llamar funcion con el boton 

 }

 function LoadProjects(){
     
    $.post("php/getProjects.php", "", function(DATA){
        if( DATA.ERROR === true ){
            alert(DATA.MESSAGE);
         
        }else{
            var count       = 0;
            var projectList = document.getElementById("ProjectList");
            
            while( count < DATA.count ){
                var option          = document.createElement("option");
                option.text         = DATA[count].projectName;
                projectList.add(option);
                
                count++;
            }
            
            //projectList.value   = "";
        }
    });
    
    
    LoadSPMforProject();
 }
 
 function LoadSPM(){
     
    $.post("php/listSPM.php", "", function(DATA){
        
        if( DATA.ERROR === true ){
            alert(DATA.MESSAGE);
         
        }else{
            var count       = 0;
            var SPMList = document.getElementById("SPMListNumber");
            
            while( count < DATA.count ){
                var option          = document.createElement("option");
                option.text         = DATA[count].id;
                SPMList.add(option);
                
                count++;
            }
            
            SPMList.value   = "";
        }
    });
    
 }
 
 function LoadSPMforProject(){
     
     var id = "SPMs";
     var php = "php/SPMPendingForProjects.php";
     var select =document.getElementById("ProjectList");
     
     
     select.addEventListener("change", function(){
         
        var projectName = select.value;
        var variables="projectName="+projectName;
        var table = document.getElementById(id);
        table.innerHTML = "";  
        
        createTable(variables,id,php);     
       
     
     });
  
 }
 
 function LoadAllSPM(){

        var id = "allSPMs";
        var variables=" ";
        var php = "php/SPMPendingAll.php";
        
        createTable(variables,id,php); 
 }
 
 function createTable(variables,id,php){
    
     
    $.post(php,variables,function(DATA){
            
        var table           = document.getElementById(id);
        var arrayTest       = [];

        for( var j=0; j<DATA.count; j++ ){
            arrayTest.push(DATA[j]);   
        }
         
        arrayTest.sort((a,b) => (a.spmId> b.spmId) ? 1: -1);
        console.log(arrayTest);
        
        for(var i=0;i<DATA.count; i++){
            
            var theadTable                   = document.createElement("thead");
                theadTable.className         = "thead-light";
            var rowTitleNumberDate           = document.createElement("tr");
                
	        var colNumber                    = document.createElement("th");
	            colNumber.id                 = arrayTest[i].spmId;
	            //colNumber.id                 = DATA[i].spmId;
	            colNumber.setAttribute("colspan", "5");  
	            
	        var colDate                      = document.createElement("th");
                colDate.setAttribute("colspan", "5");
                
            var textNumber          = document.createTextNode("Número: ");
            var number		        = document.createTextNode(arrayTest[i].spmId);
            //var number		        = document.createTextNode(DATA[i].spmId);
            var textDate            = document.createTextNode("Fecha: ");
            var date		        = document.createTextNode(moment(arrayTest[i].spmDate).format("DD-MM-YYYY"));
            
    
            colNumber.appendChild(textNumber);
            colNumber.appendChild(number);
            rowTitleNumberDate.appendChild(colNumber);

    	    colDate.appendChild(textDate);
    	    colDate.appendChild(date);
    	    rowTitleNumberDate.appendChild(colDate);
    	    
            theadTable.appendChild(rowTitleNumberDate); 
            //table.appendChild(theadTable);    
            createTableProduct(arrayTest[i].spmId,id,table,theadTable,arrayTest,i,j);    
        }
    });
 }
 
 function createTableProduct(id,idTable,table,theadTable,arrayTest,i,k){
        /*                   
            for(var i=0;i<j;i++){
                if(id == arrayTest[i]){
                var variables = "codSPM=" + id;
                console.log(variables+i); 
                break;
                }
            }
            
              
            var table2 = document.createElement(idTable);
            var arrayId = [];
            console.log(idTable);
            
            for( var p=1; p<arrayTest.length; p++){
                arrayId.push(table2.rows[p].cells[1].innerHTML);
                console.log(arrayId);
                
            }
            //console.log(arrayId);
            id  = JSON.stringify(id);
            */
            var variables = "codSPM=" + id;
            
            $.post("php/getSpmByIdPendientes.php",variables,function(DATA){

                
                var tbodyTable   = document.createElement("tbody");   
                    
                    var rowTitleProduct         = document.createElement("tr");
                    var colCodFlexlineProduct   = document.createElement("th");
                    var colGlosaProduct         = document.createElement("th");
                    var colCantidadProduct      = document.createElement("th");
                    var colUnidadProduct        = document.createElement("th");     
                    var colFechaDespachoProduct = document.createElement("th");
                    var colObservacionesProduct = document.createElement("th");
                    var colNumberOCProduct      = document.createElement("th");
                    var colCantidadOCProduct    = document.createElement("th");    
                    var colPrecioOCProduct      = document.createElement("th");    
                    var colCheckBoxProduct      = document.createElement("th");
                    
                    var codFlexlineProduct     = document.createTextNode("Cod Flexline");
                    var glosaProduct           = document.createTextNode("Descripción");
                    var cantidadProduct        = document.createTextNode("Cant");
                    var unidadProduct          = document.createTextNode("Uni");
                    var fechaDespachoProduct   = document.createTextNode("Fecha Despacho");
                    var observacionesProduct   = document.createTextNode("Observación");
                    var numberOCProduct        = document.createTextNode("N° OC");
                    var cantidadOCProduct      = document.createTextNode("Cant OC");
                    var precioOCProduct        = document.createTextNode("Precio OC");
                    var checkboxProduct        = document.createTextNode("Imprimir");
                    
                    colCodFlexlineProduct.appendChild(codFlexlineProduct);
                    colGlosaProduct.appendChild(glosaProduct);
                    colUnidadProduct.appendChild(unidadProduct);
                    colCantidadProduct.appendChild(cantidadProduct);
                    colFechaDespachoProduct.appendChild(fechaDespachoProduct);
                    colNumberOCProduct.appendChild(numberOCProduct);
                    colCantidadOCProduct.appendChild(cantidadOCProduct);
                    colPrecioOCProduct.appendChild(precioOCProduct);
                    colCheckBoxProduct.appendChild(checkboxProduct);
                    colObservacionesProduct.appendChild(observacionesProduct);
                    rowTitleProduct.appendChild(colCodFlexlineProduct);
                    rowTitleProduct.appendChild(colGlosaProduct);
                    rowTitleProduct.appendChild(colCantidadProduct);
                    rowTitleProduct.appendChild(colUnidadProduct);
                    rowTitleProduct.appendChild(colFechaDespachoProduct);
                    rowTitleProduct.appendChild(colNumberOCProduct);
                    rowTitleProduct.appendChild(colCantidadOCProduct);
                    rowTitleProduct.appendChild(colPrecioOCProduct);
                    rowTitleProduct.appendChild(colCheckBoxProduct);
                    rowTitleProduct.appendChild(colObservacionesProduct);
                    tbodyTable.appendChild(rowTitleProduct);
                
                    
                for(j=0;j<DATA.count;j++){
                    
                    var rowProductList             = document.createElement("tr");
                        rowProductList.id          = ("spm"+arrayTest[i].spmId+"Product"+j);
                    var colCodFlexlineProductList  = document.createElement("td");
                    var colGlosaProductList        = document.createElement("td");
                    var colUnidadProductList       = document.createElement("td");     
                    var colCantidadProductList     = document.createElement("td");
                    var colFechaDespachoProductList= document.createElement("td");
                    var colObservationProductList  = document.createElement("td");
                    var colNumberOCProductList     = document.createElement("td");
                    var colCantidadOCProductList   = document.createElement("td");
                    var colPrecioOCProductList     = document.createElement("td");    
                    var colCheckBoxProductList     = document.createElement("td");
                       
                    var codFlexlineProductList     = document.createTextNode(DATA[j].codFlexline);
                    var glosaProductList           = document.createTextNode(DATA[j].productName);
                    var unidadProductList          = document.createTextNode(DATA[j].productMeasureUnit);
                    var cantidadProductList        = document.createTextNode(DATA[j].cantidadPendiente);
                        cantidadProductList.id     = "cantPendSpm"+arrayTest[i].spmId+"Product"+j;
                    var fechaDespachoProductList   = document.createTextNode(moment(DATA[j].dateRequired).format("DD-MM-YYYY"));
                    var observationProductList     = document.createTextNode(DATA[j].observation); 
                    
                    var inputNumberOCProductList                = document.createElement("input");
                        inputNumberOCProductList.type           = "text";
                        inputNumberOCProductList.class          = "form-control";
                        inputNumberOCProductList.placeholder    = "N°";
                        inputNumberOCProductList.id             = "numberSpm"+arrayTest[i].spmId+"Product"+j;
                   
                        
                    var inputCantidadOCProductList              = document.createElement("input");
                        inputCantidadOCProductList.type         = "text";
                        inputCantidadOCProductList.class        = "form-control";
                        inputCantidadOCProductList.placeholder  = "Cant";
                        inputCantidadOCProductList.id           = "cantSpm"+arrayTest[i].spmId+"Product"+j;
                        
                    var inputPrecioOCProductList                = document.createElement("input");
                        inputPrecioOCProductList.type           = "text";
                        inputPrecioOCProductList.class          = "form-control";
                        inputPrecioOCProductList.placeholder    = "$";
                        inputPrecioOCProductList.id             = "precioSpm"+arrayTest[i].spmId+"Product"+j;
                        
                    var checkBoxProductList                     = document.createElement("input");
                        checkBoxProductList.type                = "checkbox";
                        checkBoxProductList.class               = "form-check-input";
                        checkBoxProductList.id                  = "checkBoxSpm"+arrayTest[i].spmId+"Product"+j;
                            
                    colCodFlexlineProductList.appendChild(codFlexlineProductList);
                    colGlosaProductList.appendChild(glosaProductList);
                    colUnidadProductList.appendChild(unidadProductList);
                    colCantidadProductList.appendChild(cantidadProductList);
                    colFechaDespachoProductList.appendChild(fechaDespachoProductList);
                    colObservationProductList.appendChild(observationProductList);
                    colNumberOCProductList.appendChild(inputNumberOCProductList);
                    colCantidadOCProductList.appendChild(inputCantidadOCProductList);
                    colPrecioOCProductList.appendChild(inputPrecioOCProductList);
                    colCheckBoxProductList.appendChild(checkBoxProductList);
                    
                    rowProductList.appendChild(colCodFlexlineProductList);
                    rowProductList.appendChild(colGlosaProductList);
                    rowProductList.appendChild(colCantidadProductList);
                    rowProductList.appendChild(colUnidadProductList);
                    rowProductList.appendChild(colFechaDespachoProductList);
                    
                    rowProductList.appendChild(colNumberOCProductList);
                    rowProductList.appendChild(colCantidadOCProductList);
                    rowProductList.appendChild(colPrecioOCProductList);
                    rowProductList.appendChild(colCheckBoxProductList);
                    rowProductList.appendChild(colObservationProductList);
                    tbodyTable.appendChild(rowProductList);
                    
                    
                }
                
            table.appendChild(theadTable);    
            table.appendChild(tbodyTable);
            });
            
 }
 
 function createOC(numero, cantidad, precio, idSpmProducto){
     
     
 }
 
 function saveOC(){
    
    //var variables = "codSPM=" + id;  
    var idSPM = document.getElementById(id);
    
    $.post("php/getSpmByIdPendientes.php",idSPM,function(DATA){
            console.log(DATA);
        
    
            for (var j=0;j<DATA.count;j++){
                
                number = document.getElementById("numberSpm"+idSPM+"Product"+j);
                cant   = document.getElementById("cantSpm"+idSPM+"Product"+j);
                precio = document.getElementById("precioSpm"+idSPM+"Product"+j);
                
            }
    
        
      
    });
 }
 

 
  
 
