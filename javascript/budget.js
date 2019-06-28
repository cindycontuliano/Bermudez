 
 window.onload      = LoadConfiguration;
 
//  INITIAL CONFIGURATION
 function LoadConfiguration(){
    document.getElementById('ProjectExcel').addEventListener('change', handleExcelProject, false);
    document.getElementById('ProductsExcel').addEventListener('change', handleExcelProducts, false);
    
    $('#titlePage').html('Gestión de Presupuesto');

    $('#bttnCloseUpdateProject').click(function(){
        CloseModal('#UpdateProject');
    });

    LoadProjects();
    LoadUsers();
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
            
            projectList.value   = "";
            
            projectList.addEventListener("change", function(){
                document.getElementById("projectToUpdate").innerHTML    = projectList.value;
                document.getElementById("projectToClose").innerHTML     = projectList.value;
                document.getElementById("projectToDelete").innerHTML    = projectList.value;
            });
        }
    });
 }
 
 function LoadUsers(){
    $.post("php/budgetUsers.php", "", function(DATA){
        
        if( DATA.ERROR === true ){
            alert(DATA.MESSAGE);
         
        }else{
            
            var count       = 0;
            var list1       = document.getElementById("userList1");
            var list2       = document.getElementById("userList2");
            
            while( count < DATA.count ){
                var option1     = document.createElement("option");
                var option2     = document.createElement("option");
                
                option1.text    = DATA[count].name + " " + DATA[count].lastname;
                option1.value   = DATA[count].username;
                
                option2.text    = DATA[count].name + " " + DATA[count].lastname;
                option2.value   = DATA[count].username;
                
                list1.add(option1);
                list2.add(option2);
                
                count++;
            }
            
        }
    });
 }


// FUNCTIONS TO CREATE A PROJECT

 function handleExcelProject(evt) {
     
    var filename    = document.getElementById('ProjectExcel').value;
    var status      = isValidExcel(filename, "ProjectExcel");
    
    if( status === true ){
        sessionStorage.setItem("projectName", filename);
        var files   = evt.target.files;
        var xl2json = new ProjectToJSON(files[0]);
        xl2json.parseExcel(files[0]);
    }
 }
 
 function ProjectToJSON() {

    this.parseExcel = function(file) {
        
        var reader      = new FileReader();
        reader.onload   = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
            
            var arrayData   = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[workbook.SheetNames[0]]);
                arrayResult = GetProjectData(arrayData, 0, null);

            sessionStorage.setItem("ProjectData", JSON.stringify(arrayResult));
            arrayData       = null;
            arrayResult     = null;
        };

        reader.onerror = function(ex) {
            alert(ex);
        };

        reader.readAsBinaryString(file);
    };
 }
 
 function GetProjectData(Array, index, codStage){
    
    var arrayCod        = [];
    var arrayQuantity   = [];
    var arrayAbstract   = [];
    var arrayResult     = [];
    
    var cod             = "";
    var newCodStage     = "";
    var quantity        = "";
    var newQuantity     = "";
    var name            = "";
    var result          = "";
    
    // If this code doesn´t works, you must add the field 'Otros'
    if( Array[index + 1].Nat == 'Material' || Array[index + 1].Nat == 'Maquinaria' || Array[index + 1].Nat == 'Mano de Obra' || Array[index + 1].Nat == 'Otros'){
        
        cod             = Array[index].Codigo;
        name            = Array[index].Resumen;
        quantity        = Array[index].CanPres;

        index++;
        
        while( cod != Array[index].Resumen ){
            
            if( Array[index].Nat == 'Partida' ){
                
                newQuantity = Array[index].CanPres;
                newCodStage = Array[index].Codigo;
                
                while( newCodStage != Array[index + 1].Resumen ){
                    
                    result      = GetProjectData(Array, index, newCodStage);
                    index       = result[0] - 1;
                
                    arrayResult.push(result);
                }

                arrayAbstract.push(arrayResult);
                
            }else if( Array[index].Nat == 'Material' ){
                arrayCod.push(Array[index].Codigo);
                arrayQuantity.push(Array[index].CanPres * quantity);
            }
            
            index++;
        }
        
        arrayAbstract.push(index);
        arrayAbstract.push(cod);
        arrayAbstract.push(name);
        arrayAbstract.push(arrayCod);
        arrayAbstract.push(arrayQuantity);
        arrayAbstract.push(codStage);
       
        return arrayAbstract;
        
    }else if( Array[index + 1].Nat == 'Partida' ){
        index++;

        quantity    = Array[index].CanPres;
        codStage    = Array[index].Codigo;
        
        while( codStage != Array[index + 1].Resumen ){
            index++;
            
            result      = GetProjectData(Array, index, codStage);
            index       = result[0];
        
            arrayResult.push(result);
        }

        for( var i=0; i<arrayResult.length; i++ ){
            var arrayTest   = arrayResult[i][4];
            
            for ( var j=0; j<arrayResult[i][4].length; j++ ){
                arrayTest[j]    = arrayTest[j] * quantity;
            }
            
            arrayResult[i][4]  = arrayTest;
        }
        
        return arrayResult;
        
    }else{
        
        while( index < Array.length - 3 ){
            index++;
            result      = GetProjectData(Array, index, codStage);

            if( result.length == 6 ){
                index   = result[0];
                
            }else{
                arrayTest   = [];
                existNumber = false;

                for( var i=0; i<result.length; i++ ){
                    
                    if( typeof(result[i]) == 'number' ){
                        arrayTest.push(result[i]);
                        existNumber = true;
                        break;
                        
                    }else{
                        
                        for( var j=0; j<result[i].length; j++ ){
                            
                            if( typeof(result[i][j]) == 'number' ){
                                arrayTest.push(result[i][j]);
                                break;
                                
                            }else if( typeof(result[i][j]) == 'object' ){
                                arrayAux    = [];
                                
                                for( var k=0; k<result[i][j].length; k++ ){
                                    arrayAux    = result[i][j];
                                    
                                    if( typeof(arrayAux[k]) == 'number' ){
                                        arrayTest.push(arrayAux[k]);
                                        break;  
                                    }
                                }
                            }        
                        }
                        
                    }
                    
                }
                arrayTest.sort(function(a, b){return b - a});
                
                if( existNumber === true ){
                    index = arrayTest[0];
                }else{
                    index = arrayTest[0] + 1;
                }
                
            }
            
            arrayResult.push(result);
        }
        
        return arrayResult;
    }
    
 }
 
 function CreateProject(){
    
    var structure   = JSON.parse(sessionStorage.getItem("ProjectData"));

    if( structure.length == 0 ){
        alert("ERROR: El archivo excel ingresado se encuentra vacio");
    
    }else{
        var username        = sessionStorage.getItem("USERNAME");
        var aux1            = sessionStorage.getItem("projectName").substr(12).split(".");
        var projectName     = aux1[0];
    
        var Variables       = "username=" + username + "&projectName=" + projectName;
       
        $.post("php/createProject.php", Variables, function(DATA){
            
            if(DATA.ERROR === false ){
                var projectId   = DATA.projectId;
                var numErr      = 0;

                for( var i=0; i<structure.length; i++ ){
                    numErr  = UploadStages(structure[i], projectId);
                }
                
                if( numErr == 0 ){
                    alert("Se ha agregado el proyecto junto con sus partidas exitosamente");
                    ClearSelect("ProjectList");
                    LoadProjects();
                    
                }else{
                    alert("ADVERTENCIA: Se ha agregado el proyecto, pero " + numErr + " partidas no se puedieron agregar");
                }
            
            }else{
                alert(DATA.MESSAGE);
            }
            
            sessionStorage.removeItem("ProjectData");
            sessionStorage.removeItem("projectName");
        });
    }
 }
 
 function UploadStages(Array, projectId){
    
    var stageName   = "";
    var products    = [];
    var quantities  = [];
    var numErr      = 0;
    
    if( typeof(Array[0]) == "number" ){
        
        if( Array[3].length > 0 ){

            stageName   = Array[2];
            
            for( var i=0; i<Array[3].length; i++ ){
                products.push( Array[3][i] );
                quantities.push( parseFloat(Array[4][i]) );
            }
            
            products    = JSON.stringify(products);
            quantities  = JSON.stringify(quantities);

            Variables   = "projectId="+projectId + "&stageName="+stageName + "&arrayProducts="+products + "&arrayQuantities="+quantities;
            
            $.post("php/createStage.php", Variables, function(DATA){
                if( DATA.ERROR == true ){
                    numErr++;
                }
            });
            
            return numErr;
        
        }else{
            return 0;
        }
        
    }else{

        for( var j=0; j<Array.length; j++ ){
            
            if( typeof(Array[j]) == "object" ){
                numErr  = UploadStages(Array[j], projectId);
                
            }else if( typeof(Array[j]) == "number" ){
                var arrayAux    = [];

                for( var k=0; k<Array[j].length - j; k++){
                    arrayAux.push(Array[j]);
                }
                
                j = j + 6;
                numErr  = UploadStages(arrayAux, projectId);
            }
        }
        
        return numErr;
    }
}

// FUNCTIONS TO UPLOAD THE PRODUCT MASTER

 function handleExcelProducts(evt) {
    
    var filename    = document.getElementById('ProductsExcel').value;
    var status      = isValidExcel(filename, "ProductsExcel");
    
    if( status === true ){
        var files   = evt.target.files;
        var xl2json = new ProductsToJSON(files[0]);
        xl2json.parseExcel(files[0]);
    }
 } 

 function ProductsToJSON() {
    this.parseExcel = function(file) {
        
        var reader      = new FileReader();
        reader.onload   = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
        
            var sheetName   = workbook.SheetNames[0];

            // The JSON is modificated here
            var XL_row_object   = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
            
            var arrayCodFlexline    = [];
            var arrayGlosa          = [];
            var arrayFamilia        = [];
            var arrayUnidad         = [];
            
            for(i=0; i<XL_row_object.length; i++){
                
                arrayCodFlexline.push( XL_row_object[i]["COD. FLEX"] );
                arrayGlosa.push( XL_row_object[i].GLOSA );
                arrayFamilia.push( XL_row_object[i].FAMILIA );
                arrayUnidad.push( XL_row_object[i].UNIDAD );

            }
            
            sessionStorage.setItem("arrayCodFlexline", JSON.stringify(arrayCodFlexline));
            sessionStorage.setItem("arrayGlosa", JSON.stringify(arrayGlosa));
            sessionStorage.setItem("arrayFamilia", JSON.stringify(arrayFamilia));
            sessionStorage.setItem("arrayUnidad", JSON.stringify(arrayUnidad));

        };

        reader.onerror = function(ex) {
            alert(ex);
        };

        reader.readAsBinaryString(file);
    };
 }

 function AddProducts(){
     
    var aux1    = sessionStorage.getItem("arrayCodFlexline");
    var aux2    = sessionStorage.getItem("arrayGlosa");
    var aux3    = sessionStorage.getItem("arrayFamilia");
    var aux4    = sessionStorage.getItem("arrayUnidad");

    if( aux1 === "" || aux2 === "" || aux3 === "" || aux4 === "" ){
        alert("ERROR: El archivo excel no contiene datos");
    
    }else{
        var arrayCodFlexline    = aux1;
        var arrayGlosa          = aux2;
        var arrayFamilia        = aux3;
        var arrayUnidad         = aux4;

        var data    = "arrayCodFlexline=" + arrayCodFlexline + "&arrayGlosa=" + arrayGlosa + "&arrayFamilia=" + arrayFamilia + "&arrayUnidad=" + arrayUnidad;
       
        $.post("php/addProducts.php", data, function(DATA){

            if(DATA.ERROR === true ){
                alert(DATA.MESSAGE);
                ClearDataProducts();
            
            }else{
                alert(DATA.MESSAGE);
                location.reload();
            
            }
        });
    }
 }
 
 function ClearDataProducts(){
    sessionStorage.setItem("arrayCodFlexline", "");
    sessionStorage.setItem("arrayGlosa", "");
    sessionStorage.setItem("arrayFamilia", "");
    sessionStorage.setItem("arrayUnidad", "");
 }
 
 
 
// FUNCTIONS TO UPDATE PROJECTS
 
 function LoadProjectData(){

    var projectName =  document.getElementById("projectToUpdate").innerHTML;
    var Variables   = "projectName=" + projectName;
    
    $.post("php/getProjectData.php", Variables, function(DATA){
        
        if( DATA.ERROR === false ){
            sessionStorage.setItem("projectId", DATA.projectId);
            
            $('#newProjectName').val(DATA.projectName);
            $('#userList1').val(DATA.projectOwner);          
            $('#userList2').val(DATA.projectGrocer);        
            $('#startDate').val(DATA.startDate);
            $('#finishDate').val(DATA.finishDate);
            
            $('#UpdateProject').modal('show');
            
        }else{
            alert(DATA.MESSAGE);

            CloseModal('#ProjectOptionsForm');
        }
    });
 }
 
 function UpdateProject(){
    var id              = sessionStorage.getItem("projectId");
        sessionStorage.removeItem("projectId");
    var name            = document.getElementById("newProjectName").value;
    var usernameOwner   = document.getElementById("userList1").value;
    var usernameGrocer  = document.getElementById("userList2").value;
    var startDate       = document.getElementById("startDate").value;
    var finishDate      = document.getElementById("finishDate").value
  
    if( name === "" ){
        alert("ERROR: El nombre del proyecto no puede estar vacio");
    
    }else{
        
        if( startDate === "" ){
            alert("ERROR: La fecha de inicio puede estar vacia");
    
        }else if( finishDate != "" && finishDate <= startDate ){
            alert("ERROR: La fecha de termino no puede ser anterior o igual a la fecha de inicio del proyecto");
            document.getElementById("finishDate").value = "";
        
        }else{
            var Variables   = "id=" + id + "&name=" + name + "&usernameOwner=" + usernameOwner + "&usernameGrocer=" + usernameGrocer + "&startDate=" + startDate + "&finishDate=" + finishDate;
      
            $.post("php/updateProject.php", Variables, function(DATA){
                
                alert(DATA.MESSAGE);
                
                $('#projectToUpdate').html('');
                
                $('#newProjectName').val('');
                $('#usernameOwner').val('');
                $('#usernameGrocer').val('');
                $('#startDate').val('');
                $('#finishDate').val('');
            
                CloseModal('#UpdateProject');
            });
        }
    }
 }




// FUNCTION TO CLOSE A PROJECT

 function CloseProject(){
     
    var projectName = document.getElementById("projectToClose").innerHTML;
    
    if( projectName === ""){
        alert("ERROR: Debes seleccionar un proyecto antes de cerrarlo");
    
    }else{
        var Variables   = "projectName=" + projectName;
        
        $.post("php/closeProject.php", Variables, function(DATA){
            
            if( DATA.ERROR === false ){
                alert(DATA.MESSAGE);
                $('#projectToClose').html('');
                
                CloseModal('#CloseProject');
                ClearSelect("ProjectList");
                LoadProjects();
                
            }else{
                alert(DATA.MESSAGE);
                CloseModal("#CloseProject");

            }
            
        });
    } 
 }
 
 // FUNCTION TO OPEN A PROJECT
 
 function LoadProjectToOpen(){
     
    $.post("php/getProjectsClosed.php", "", function(DATA){
        
        if( DATA.ERROR == false ){
            
            ClearSelect('ProjectsToOpen');
            var Select  = document.getElementById("ProjectsToOpen");
            
            for( var i=0; i<DATA.count; i++ ){
                var option  = document.createElement("option");
                option.text = DATA[i].projectName;
                Select.add(option);
            }
            
            Select.value    = "";
            $('#OpenProject').modal('show');
            $('#bttnCloseOpenProject').click(function(){
                CloseModal('#OpenProject');
            });
            
        }else{
            alert(DATA.MESSAGE);   
        }
    });
 }
 
 function OpenProject(){
     
    var projectName = document.getElementById("ProjectsToOpen").value;
    
    if( projectName === ""){
        alert("ERROR: Debes seleccionar un proyecto antes de abrirlo");
    
    }else{
        var Variables   = "projectName=" + projectName;
        
        $.post("php/openProject.php", Variables, function(DATA){
            
            if( DATA.ERROR === false ){
                alert(DATA.MESSAGE);
                
                CloseModal('#OpenProject');
                ClearSelect("ProjectList");
                LoadProjects();
                
            }else{
                alert(DATA.MESSAGE);
                CloseModal("#OpenProject");

            }
        });
    } 
 }


// FUNCTION TO DELETE A PROJECT

 function DeleteProject(){
    
    var projectName = document.getElementById("projectToDelete").innerHTML;
    
    if( projectName === ""){
        alert("ERROR: Debes seleccionar un proyecto antes de eliminarlo");
    
    }else{
        var Variables   = "projectName=" + projectName;
      
        $.post("php/deleteProject.php", Variables, function(DATA){
            
            if( DATA.ERROR === false ){
                alert(DATA.MESSAGE);
                $('#projectToDelete').html('');
                
                CloseModal("#DeleteProject");
                ClearSelect("ProjectList");
                LoadProjects();
                    
            }else{
                alert(DATA.MESSAGE);
                CloseModal("#DeleteProject");
                
            }
            
        });
    }
 }
 