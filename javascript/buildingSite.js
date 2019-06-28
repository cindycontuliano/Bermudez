 
 window.onload    = StartupConfig;
 
 function StartupConfig(){
    
    document.getElementById("titlePage").innerHTML  = "Seleccione algún proyecto";
    
    $('#bttnCloseAbstract').click(function(){
        CloseModal('#abstractSpm');
    });
    
    $('#bttnCloseDelete').click(function(){
        CloseModal('#deleteSPM');
    });
    
    $('#bttnCloseEdition').click(function(){
        CloseModal('#editRow');  
    });
    
    $('#bttnCloseEdition2').click(function(){
        CloseModal('#editRow2');  
    });
    
    $(document).on('hidden.bs.modal', function () {
        $('body').addClass('modal-open');
    });
    
    getProjects();
    filterProduct();
    EventChangeProject();
    EventChangeProduct();
    
 }

 function getProjects(){
    
    var username    = sessionStorage.getItem("USERNAME");
    var Variables   = "username=" + username;
    
    
    $.post("php/getAllProjects.php", Variables, function(DATA){

    // There is errors?
        if( DATA.ERROR === true ){
            alert(DATA.MESSAGE);
            Logout();
        
        }else{
            // There is only a one row?
            if( DATA.count == 1 ){
                
                if( username == DATA[0].usernameAdministrator ){
                    
                    document.getElementById("titlePage").innerHTML  = "Administrador de obra: " + DATA[0].projectName; 
                    createSendSPM();
                    SetProjectData();
                    
                }else if( username == DATA[0].usernameGrocer ){
                    document.getElementById("titlePage").innerHTML  = "Bodeguero de obra: " + DATA[0].projectName; 
                    SetProjectData();
                    
                }
        
        // There is more than one row 
            }else{
                
                var Select  = document.getElementById("projectList");
                var rol     = "";
                
                for( var i=0; i<DATA.count; i++ ){
                    
                    if( username == DATA[i].usernameGrocer ){
                        document.getElementById("titlePage").innerHTML  = "Bodeguero de obra: " + DATA[i].projectName; 
                        rol         = "Grocer";
                        break;
                    }
                    
                }
                
                if( rol === "" ){
                
                    for( var j=0; j<DATA.count; j++ ){
                    
                        if( username == DATA[j].usernameAdministrator ){
                            var option  = document.createElement("option");
                            option.text = DATA[j].projectName;
                        
                            Select.add(option);
                        }
                    }
                    
                    if( Select.length > 1 ){
                        document.getElementById("containerProjects").style.display  = "block";
                        Select.value    = "";
                        
                    }else{
                        document.getElementById("titlePage").innerHTML  = "Administrador de obra: " + Select[0].value; 
                    }
                    
                    createSendSPM();
                }
            }
        }
    });
 }
 
 function SetProjectData(){
    
    var aux         = document.getElementById("titlePage").innerHTML.split(":");
    var projectName = aux[1].replace(" ", "");
    var Variables   = "projectName=" + projectName;

    $.post("php/getStages.php", Variables, function(DATA){

        if( DATA.ERROR === false ){
            
            var Select  = document.getElementById("listStages");
            
            for( var i=0; i<DATA.count; i++){
                var option          = document.createElement("option");
                option.text         = DATA[i].stageName;
                Select.add(option);
            }
            
            Select.value   = "";
            
            Select.addEventListener("change", function(){
                ClearSelect("productSPM");
                GetProducts(Select.value);
            });
            
        }
    });
 }
 
 function EventChangeProject(){
    var Select = document.getElementById("projectList");
    
    Select.addEventListener("change", function(){

        ClearSelect("listStages");
        
        document.getElementById("titlePage").innerHTML  = "Administrador de obra: " + Select.value;
        var projectName = Select.value;
        var Variables   = "projectName=" + projectName;
    
        $.post("php/getStages.php", Variables, function(DATA){

            if( DATA.ERROR === false ){
                
                var Select  = document.getElementById("listStages");
                
                for( var i=0; i<DATA.count; i++){
                    var option          = document.createElement("option");
                    option.text         = DATA[i].stageName;
                    Select.add(option);
                }
                
                Select.value   = "";
                
                Select.addEventListener("change", function(){
                    GetProducts(Select.value);
                });
            }
        });
    });
 }
 
 function GetProducts(Value){
    
    var projectName = GetProjectName();
    var Variable    = "nameStage=" + Value + "&projectName=" + projectName;

    $.post("php/getProducts.php", Variable, function(DATA){
        
        if( DATA.ERROR  === true ){
            alert(DATA.MESSAGE);
            
        }else{
            var Select  = document.getElementById("productSPM");
            
            for( var i=0; i<DATA.count; i++){
                var option  = document.createElement("option");
                option.text = DATA[i].glosa;
                Select.add(option);
            }
            
            Select.value   = "";
            sessionStorage.setItem("DataProducts", JSON.stringify(DATA) );
        }
        
    });
 }
 
 function GetProjectName(){
    
    var aux         = document.getElementById("titlePage").innerHTML.split(":");
    var projectName = aux[1].replace(" ", "");
    return projectName;

 }
 
 function filterProduct(){
    var input   = document.getElementById("productFilter");
    
    input.addEventListener("keypress", function(event){
        
        var prevItems   = sessionStorage.getItem("numItems");
        var items       = document.getElementById("productSPM");
        var char        = String.fromCharCode(event.keyCode);
            char        = char.toUpperCase();
        var regex       = new RegExp("(" + input.value.toUpperCase() + char + ")", "g");
        var count       = 0;

        for( var j=0; j<items.length; j++){
            var value   = items.options[j].value;
            
            if( !regex.test(value) ){
                items.options[j].style.display = "none";
            }else{
                items.options[j].style.display = "list-item";
                count++;
            }
            
            document.getElementById("resultsProducts").innerHTML    = "Resultados: " + count;
        }
    });
 }
 
 function createSendSPM(){

    var body                = document.getElementById("containerSendSPM");
        
    var button                  = document.createElement("button");
        button.className        = "btn btn-primary";
        button.innerHTML        = "Enviar SPM";
        button.setAttribute("onclick", "ValidateSPM()");

    body.appendChild(button);
 }
 
 function ValidateSPM(){
    var aux         = document.getElementById("titlePage").innerHTML;

    if( aux === "Seleccione algún proyecto" ){
        alert("ERROR: Debes seleccionar un proyecto primero");
        
    }else{
        aux             = aux.split(":");
        var projectName = aux[1].substring(1);
        var Variables   = "projectName=" + projectName;
        
        $.post("php/getSPMReviewed.php", Variables, function(DATA){
            
            if( DATA.ERROR  === true ){
                alert(DATA.MESSAGE);
                
            }else{
                LoadSPMEmitted(DATA);
                $('#modalValidateSPM').modal('show');
            }
        });
    }
 }
 
 function LoadSPMEmitted(DATA){
 
    ClearTable("spmEmitted");
 
    var table       = document.getElementById("spmEmitted");
    var bodyTable   = document.createElement("tbody");
    var arrayTest   = [];

    for( var j=0; j<DATA.count; j++ ){
        arrayTest.push(DATA[j].spmId);   
    }
    
    arrayTest.sort();

    for( i=0; i<DATA.count; i++ ){
        
        var row        = document.createElement("tr");
        
        var itemCell    = document.createElement("td");
        var codCell     = document.createElement("td");
        
        var link        = document.createAttribute("href");
            link.value  = "javascript:getSPMbyId('" + arrayTest[i] + "' );";
        
        var item        = document.createTextNode( (i+1) );
        var cod         = document.createElement("a");
            cod.innerHTML   = arrayTest[i];
            cod.setAttributeNode(link);

        itemCell.appendChild(item);
        codCell.appendChild(cod);
        
        row.appendChild(itemCell);
        row.appendChild(codCell);
        
        bodyTable.appendChild(row);
    }
    
    table.appendChild(bodyTable);
    
 }
 
 function getSPMbyId(id){
    
    var Variables    = "codSPM=" + id;
    
    $.post("php/getSpmById.php", Variables, function(DATA){
        
        if( DATA.ERROR === true ){
            alert(DATA.MESSAGE);
        
        }else{
            
            ClearTable("spmDetails");
            
            var table       = document.getElementById("spmDetails");
            var bodyTable   = document.createElement("tbody");
   
            for( i=0; i<DATA.count; i++ ){
                var row                 = document.createElement("tr");
        
                var itemCell            = document.createElement("td");
                var flexlineCell        = document.createElement("td");
                var codProductCell      = document.createElement("td");
                var productCell         = document.createElement("td");
                var familyCell          = document.createElement("td");
                var stageCell           = document.createElement("td");
                var quantityCell        = document.createElement("td");
                var measureUnitCell     = document.createElement("td");
                var dateRequiredCell    = document.createElement("td");
                var observationCell     = document.createElement("td");
                var actionCell          = document.createElement("td");
                
                var item            = document.createTextNode((i+1));
                var codFlexline     = document.createTextNode( DATA[i].codFlexline );
                var codProduct      = document.createTextNode( DATA[i].codProduct )
                var productName     = document.createTextNode( DATA[i].productName );
                var productFamily   = document.createTextNode( DATA[i].productFamily );
                var stageName       = document.createTextNode( DATA[i].stageName );
                var quantity        = document.createTextNode( DATA[i].quantity );
                var measureUnit     = document.createTextNode( DATA[i].productMeasureUnit );
                var dateRequired    = document.createTextNode( moment(DATA[i].dateRequired).format("DD/MM/YYYY") );
                var observation     = document.createTextNode( DATA[i].observation );
                var editBtton       = document.createElement("button");
                var deleteBtton     = document.createElement("button");
    
                    editBtton.className     = "btn btn-warning";
	                editBtton.innerHTML     = "Editar";
                    editBtton.setAttribute("onclick", "EditRow2(" +  '"spmDetails",' + (i+1) + ")");
                    editBtton.setAttribute("id", "editBtton" + (i+1));
                    
                    deleteBtton.className    = "btn btn-danger";
	                deleteBtton.innerHTML    = "Eliminar";
                    deleteBtton.setAttribute("onclick", "DeleteRow(" +  '"spmDetails",' + (i+1) + ', ' + id + ")");
                    deleteBtton.setAttribute("id", "deleteBtton" + (i+1));

                itemCell.appendChild(item);
                flexlineCell.appendChild(codFlexline);
                codProductCell.appendChild(codProduct);
                productCell.appendChild(productName);
                familyCell.appendChild(productFamily);
                stageCell.appendChild(stageName);
                quantityCell.appendChild(quantity);
                measureUnitCell.appendChild(measureUnit);
                dateRequiredCell.appendChild(dateRequired);
                observationCell.appendChild(observation);
                actionCell.appendChild( editBtton );
                actionCell.appendChild( deleteBtton );
        
                row.appendChild(itemCell);
                row.appendChild(flexlineCell);
                row.appendChild(codProductCell);
                row.appendChild(productCell);
                row.appendChild(familyCell);
                row.appendChild(stageCell);
                row.appendChild(quantityCell);
                row.appendChild(measureUnitCell);
                row.appendChild(dateRequiredCell);
                row.appendChild(observationCell);
                row.appendChild(actionCell);
        
                bodyTable.appendChild(row);
            }
    
            table.appendChild(bodyTable);
            
            $('#spmSpecify').modal('show');
            $('#spmSpecifyId').html(id);
            $('#spmToDelete').html(id);
            
        }
    });
 }
 
 function EventChangeProduct(){
    var Select = document.getElementById("productSPM");
    
    Select.addEventListener("change", function(){
        
        var index   = Select.selectedIndex;
        var aux     = GetDataProducts(index);

        document.getElementById("familyProduct").value      = aux[0];
        document.getElementById("unitMeasure").innerHTML    = aux[3] + " " + aux[2];
    
        document.getElementById("familyProduct").disabled   = true;
    });
 }
 
 function GetDataProducts(index){
    var array           = JSON.parse( sessionStorage.getItem("DataProducts") );
    var elements        = [];
    
    elements.push(array[index].familia);
    elements.push(array[index].codFlexline);
    elements.push(array[index].unidad);
    elements.push(array[index].cantDisponible);
    
    return elements;
 }
 
 function AddNewItem(){
    var product         = document.getElementById("productSPM").value;
    var family          = document.getElementById("familyProduct").value;
    var quantity        = document.getElementById("quantitySPM").value;
    var quantAvailable  = document.getElementById("unitMeasure").innerHTML.split(" ");
    
    var stage           = document.getElementById("listStages").value;
    var dateRequired    = document.getElementById("dateRequired").value;
    var observation     = document.getElementById("observationSPM").value;
    
    if( stage === "" ){
        alert("ERROR: Se debe seleccionar una partida del proyecto");

    }else if( product === "" ){
        alert("ERROR: Se debe seleccionar un producto");
        
    }else if( !isValidNumber(quantity) || quantity == 0 ){
        alert("ERROR: La cantidad ingresada no es correcta");
        document.getElementById("quantitySPM").value    = "";
    
    }else if( quantity > quantAvailable[0] ){
        alert("ERROR: La cantidad ingresada no puede ser superior a la cantidad disponible");
        document.getElementById("quantitySPM").value    = "";
        
    }else if( dateRequired === "" ){
        alert("ERROR: La fecha de despacho ingresada no es valida");
    
    }else if( CompareTwoDates(dateRequired) ){
        alert("ERROR: La fecha de despacho no puede ser igual o anterior al dia de hoy");
        
    }else{
        
        var table               = document.getElementById("ListSPM");
	    var bodyTable           = document.createElement("tbody");
        var row                 = document.createElement("tr");

 	    var itemCell            = document.createElement("td");
 	    var codFlexlineCell     = document.createElement("td");
        var productCell         = document.createElement("td");
        var familyCell          = document.createElement("td");
        var quantityCell        = document.createElement("td");
        var unitMeasureCell     = document.createElement("td");
        var stageCell           = document.createElement("td");
        var dateRequiredCell    = document.createElement("td");
        var observationCell     = document.createElement("td");
        var actionCell          = document.createElement("td");
        
        var index               = document.getElementById("productSPM").selectedIndex;
        var aux                 = GetDataProducts(index);

        var item                = document.createTextNode( table.rows.length );
	    var codFlexline         = document.createTextNode( aux[1]  );           // aux[0] containts the flexline code
	    var productItem         = document.createTextNode( product );
	    var familyItem          = document.createTextNode( family );
	    var quantityItem        = document.createTextNode( quantity );
	    var unitMeasure         = document.createTextNode( aux[2] );            // aux[1] containts the unit measure
	    var stageItem           = document.createTextNode( stage );
	    var dateRequiredItem    = document.createTextNode( moment(dateRequired).format("DD/MM/YYYY") );
	    var observationItem     = document.createTextNode( observation );
	    var editBtton           = document.createElement("button");
        var deleteBtton         = document.createElement("button");
    
            editBtton.className     = "btn btn-warning";
            editBtton.innerHTML     = "Editar";
            editBtton.setAttribute("onclick", "EditRow(" +  '"ListSPM",' + table.rows.length + ")");
            editBtton.setAttribute("id", "editBtton" + table.rows.length);
            
            deleteBtton.className    = "btn btn-danger";
            deleteBtton.innerHTML    = "Eliminar";
            deleteBtton.setAttribute("onclick", "DeleteRow(" +  '"ListSPM",' + table.rows.length + ', ' + null + ")");
            deleteBtton.setAttribute("id", "deleteBtton" + table.rows.length);
	    
	    itemCell.appendChild( item );
	    codFlexlineCell.appendChild( codFlexline );
	    productCell.appendChild( productItem );
	    familyCell.appendChild( familyItem );
	    quantityCell.appendChild( quantityItem );
	    unitMeasureCell.appendChild( unitMeasure );
	    stageCell.appendChild( stageItem );
	    dateRequiredCell.appendChild( dateRequiredItem );
	    observationCell.appendChild( observationItem );
        actionCell.appendChild( editBtton );
        actionCell.appendChild( deleteBtton );
    
        row.appendChild( itemCell );
        row.appendChild( codFlexlineCell );
        row.appendChild( productCell );
        row.appendChild( familyCell );
        row.appendChild( quantityCell );
        row.appendChild( unitMeasureCell );
        row.appendChild( stageCell );
        row.appendChild( dateRequiredCell );
        row.appendChild( observationCell );
        row.appendChild( actionCell );
        
        bodyTable.appendChild(row);
        
	    table.appendChild(bodyTable);

        ClearInputs();
        ClearSelect("productSPM");

    }
 }
 
 function UpdateSpm(){
    var table   = document.getElementById("spmDetails");
    
    if( table.rows.length == 1 ){
        alert("ERROR: Debes agregar almenos una SPM primero");
    
    }else{
        
        var spmId               = parseInt(document.getElementById("spmSpecifyId").innerHTML);
        var arrayCodProducts    = [];
        var arrayQuantities     = [];
        var arrayDates          = [];
        var arrayObservations   = [];
        
        
        for( var i=1; i<table.rows.length; i++){
            
            arrayCodProducts.push( table.rows[i].cells[2].innerHTML );
            arrayQuantities.push( table.rows[i].cells[6].innerHTML.replace(/,/g , '.' ) );
            arrayDates.push( FormatDate(table.rows[i].cells[8].innerHTML).replace(/\//g, '-') );
            arrayObservations.push( table.rows[i].cells[9].innerHTML );
            
        }
        
        arrayCodProducts    = JSON.stringify(arrayCodProducts);
        arrayQuantities     = JSON.stringify(arrayQuantities);
        arrayDates          = JSON.stringify(arrayDates);
        arrayObservations   = JSON.stringify(arrayObservations);
        
        var Variables       = "spmId=" + spmId + "&arrayCodProducts=" + arrayCodProducts +  "&arrayQuantities=" + arrayQuantities + "&arrayDates=" + arrayDates + "&arrayObservations=" + arrayObservations;

        $.post("php/updateSPM.php", Variables, function(DATA){

            alert(DATA.MESSAGE);
            
            ClearTable("spmDetails");
            ClearTable("spmEmitted");
            
            CloseModal('#spmSpecify');
            CloseModal('#modalValidateSPM');
        });
    }
    
 }
 
 function DeleteSpm(){
    
    var idSpm               = $('#spmToDelete').text();
    
    var table               = document.getElementById("spmDetails");
    
    var projectName         = GetProjectName();
    var arrayCodsFlexline   = [];
    var arrayQuantities     = [];
    var arrayStageNames     = [];

    for( var i=1; i<table.rows.length; i++){
        arrayCodsFlexline.push( table.rows[i].cells[1].innerHTML );
        arrayStageNames.push( table.rows[i].cells[5].innerHTML );
        arrayQuantities.push( table.rows[i].cells[6].innerHTML );
    }
    
    arrayCodsFlexline   = JSON.stringify(arrayCodsFlexline);
    arrayQuantities     = JSON.stringify(arrayQuantities);
    arrayStageNames     = JSON.stringify(arrayStageNames);

    var Variables   = "idSpm=" + idSpm + "&projectName=" + projectName + "&arrayCodsFlexline=" + arrayCodsFlexline + "&arrayQuantities=" + arrayQuantities + "&arrayStageNames=" + arrayStageNames;
    
    $.post("php/deleteSpm.php", Variables, function(DATA){
        
        if( DATA.ERROR === false ){
            alert(DATA.MESSAGE);
            
            CloseModal('#deleteSPM');
            CloseModal('#spmSpecify');
            CloseModal('#modalValidateSPM');
            
        }else{
            alert(DATA.MESSAGE);
            CloseModal('#deleteSPM');
        }
    });
 }
 
 function ClearInputs(){
    document.getElementById("productFilter").value      = "";
    document.getElementById("productSPM").value         = "";
    document.getElementById("familyProduct").value      = "";
    document.getElementById("unitMeasure").innerHTML    = "";
    document.getElementById("quantitySPM").value        = "";
    document.getElementById("listStages").value         = "";
    document.getElementById("dateRequired").value       = "";
    document.getElementById("observationSPM").value     = "";
 }
 
 function GetQuantitiesByIndex(codFlexline, stageName, callback){
     
    var Variables   = "codFlexline=" + codFlexline + "&stageName=" + stageName + "&projectName=" + GetProjectName();
    
    $.post("php/getProductStageData.php", Variables, function(DATA){

        if( DATA.ERROR == false ){
            callback(DATA.quantAvailable + " " + DATA.unitMeasure);
        }else{
            alert(DATA.MESSAGE);
            callback(null);
        }
        
    });
 }
 
 function EditRow(id, index){
    
    var table           = document.getElementById(id);
    
    var codFlexline     = table.rows[index].cells[1].innerHTML;
    var quantity        = table.rows[index].cells[4].innerHTML;
    var stageName       = table.rows[index].cells[6].innerHTML;
    var dateRequired    = table.rows[index].cells[7].innerHTML;
    var observation     = table.rows[index].cells[8].innerHTML;
  
    GetQuantitiesByIndex( codFlexline, stageName, function( variableAux ){
        
        if( variableAux != null ){
        
            document.getElementById("editQuantity").innerHTML   = variableAux;
            document.getElementById("newQuantity").value        = quantity;
            document.getElementById("newDateRequired").value    = FormatDate(dateRequired);
            document.getElementById("newObservation").value     = observation;
            
            $('#editRow').modal('show');
            
            document.getElementById("commitEdit").onclick   = function(){
                
                var newQuantity         = document.getElementById("newQuantity").value;
                var newDateRequired     = document.getElementById("newDateRequired").value;
                var newObservation      = document.getElementById("newObservation").value;
                var quantAvailable      = document.getElementById("editQuantity").innerHTML.split(" ");
                
                if( !isValidNumber(newQuantity) || newQuantity == 0 ){
                    alert("ERROR: La cantidad ingresada no es correcta");
                    document.getElementById("newQuantity").value    = "";
                
                }else if( newQuantity > quantAvailable[0] ){
                    alert("ERROR: La cantidad ingresada no puede ser superior a la cantidad disponible");
                    document.getElementById("newQuantity").value    = "";   
                
                }else if( CompareTwoDates(newDateRequired) ){
                    alert("ERROR: La fecha de despacho no puede ser igual o anterior al dia de hoy");
                    
                }else{
                    table.rows[index].cells[4].innerHTML    = newQuantity;
                    table.rows[index].cells[7].innerHTML    = moment(newDateRequired).format("DD/MM/YYYY");
                    table.rows[index].cells[8].innerHTML    = newObservation;
                    
                    CloseModal('#editRow');
                }
            };
        }
        
    });
 
 }
 
 function EditRow2(id, index){
     
    var table           = document.getElementById(id);
    
    var codFlexline     = table.rows[index].cells[1].innerHTML;
    var stageName       = table.rows[index].cells[5].innerHTML;
    var quantity        = table.rows[index].cells[6].innerHTML;
    var dateRequired    = table.rows[index].cells[8].innerHTML;
    var observation     = table.rows[index].cells[9].innerHTML;
  
    GetQuantitiesByIndex( codFlexline, stageName, function( variableAux ){
        
        if( variableAux != null ){
            
            variableAux = variableAux.split(" ");
            
            document.getElementById("editQuantity2").innerHTML  = (parseInt(variableAux[0]) + parseInt(quantity)) + " " +variableAux[1];
            document.getElementById("newQuantity2").value       = quantity;
            document.getElementById("newDateRequired2").value   = FormatDate(dateRequired);
            document.getElementById("newObservation2").value    = observation;
            
            $('#editRow2').modal('show');
            
            document.getElementById("commitEdit2").onclick   = function(){
                
                var newQuantity     = document.getElementById("newQuantity2").value;
                var newDateRequired = document.getElementById("newDateRequired2").value;
                var newObservation  = document.getElementById("newObservation2").value;
                var quantAvailable  = document.getElementById("editQuantity2").innerHTML.split(" ");
                
                if( !isValidNumber(newQuantity) || newQuantity == 0 ){
                    alert("ERROR: La cantidad ingresada no es correcta");
                    document.getElementById("newQuantity2").value    = "";
                
                }else if( newQuantity > quantAvailable[0] ){
                    alert("ERROR: La cantidad ingresada no puede ser superior a la cantidad disponible");
                    document.getElementById("newQuantity").value    = "";   
                
                }else if( CompareTwoDates(newDateRequired) ){
                    alert("ERROR: La fecha de despacho no puede ser igual o anterior al dia de hoy");
                   
                
                }else{
                    table.rows[index].cells[6].innerHTML    = newQuantity;
                    table.rows[index].cells[8].innerHTML    = moment(newDateRequired).format("DD/MM/YYYY");
                    table.rows[index].cells[9].innerHTML    = newObservation;
                    
                    var delta   = quantity - newQuantity;
                    
                    var Variable   = "projectName=" + GetProjectName() + "&stageName=" + stageName + "&codFlexline=" + codFlexline + "&quantity=" + delta;
                    
                    $.post("php/updateQuantityAvailable.php", Variable, function(DATA){
                    });
                    
                    CloseModal('#editRow2');
                }
                
            };
                
        }
        
    });
    
 }
 
 function DeleteRow(id, index, idSpm){
    var table   = document.getElementById(id);
    table.deleteRow(index);
    
    for( var i=index; i<table.rows.length; i++){
        table.rows[i].cells[0].innerHTML    = i;
        
        var editBtton   = document.getElementById("editBtton" + (i+1));
        var deleteBtton = document.getElementById("deleteBtton" + (i+1));

        editBtton.setAttribute("onclick", "EditRow(" + '"' + id + '"' + ',' + i + ")");
        editBtton.setAttribute("id", "editBtton" + i);
        
        deleteBtton.setAttribute("onclick", "DeleteRow(" + '"' + id + '"' + ',' + i + ', ' + idSpm + ")");
        deleteBtton.setAttribute("id", "deleteBtton" + i);
    }
    
 }
 
 function ValidateSPMForm(){
     
    var table       = document.getElementById("ListSPM");
    var count       = table.rows.length;

    if( count < 2 ){
        alert("ERROR: Debes agregar almenos una SPM primero");
    
    }else{
        
        var username            = sessionStorage.getItem("USERNAME");
        var projectName         = GetProjectName();
        var arrayProducts       = [];
        var arrayQuantities     = [];
        var arrayStages         = [];
        var arrayDates          = [];
        var arrayObservations   = [];
        

        for( var i=1; i<count; i++){
            
            arrayProducts.push( table.rows[i].cells[2].innerHTML );
            arrayQuantities.push( table.rows[i].cells[4].innerHTML.replace(/,/g , '.' ) );
            arrayStages.push( table.rows[i].cells[6].innerHTML );
            arrayDates.push( FormatDate(table.rows[i].cells[7].innerHTML).replace(/\//g, '-') );
            arrayObservations.push( table.rows[i].cells[8].innerHTML );
        
        }

        arrayProducts       = JSON.stringify(arrayProducts);
        arrayQuantities     = JSON.stringify(arrayQuantities);
        arrayStages         = JSON.stringify(arrayStages);
        arrayDates          = JSON.stringify(arrayDates);
        arrayObservations   = JSON.stringify(arrayObservations);
        
        var Variables       = "username=" + username + "&projectName=" + projectName + "&arrayProducts=" + arrayProducts +  "&arrayQuantities=" + arrayQuantities + "&arrayStages=" + arrayStages + "&arrayDates=" + arrayDates + "&arrayObservations=" + arrayObservations;
        
        $.post("php/createSPM.php", Variables, function(DATA){

            if( DATA.ERROR === true ){
                alert(DATA.ERROR);
            
            }else{
                var numErr  = 0;
                
                for( var i=0; i<DATA.length; i++ ){
                    if( DATA[i].ERROR === true ){
                        numErr++;
                        console.log(DATA[i].MESSAGE);
                    }
                }
                
                if( numErr == 0 ){
                    alert("Se ha registrado la SPM exitosamente");
                }else{
                    alert("ADVERTENCIA: Algúnos productos de la SPM no se han podido registrar");
                    
                }
                
                ClearTable("ListSPM");
                ClearInputs();
            }
            
            CloseModal('#abstractSpm');
        });
    }
 }
