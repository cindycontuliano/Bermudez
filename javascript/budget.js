 
 window.onload      = LoadConfiguration;
 
//  INITIAL CONFIGURATION
 function LoadConfiguration(){
    document.getElementById('ExcelFile').addEventListener('change', handleFileSelect, false);
    document.getElementById('ProductsExcel').addEventListener('change', verifyExcelFile, false);

    LoadProjects();
    LoadUsers();
 }
 
 
 
 function OpenCreateProject(){
    var pop  = document.getElementById("CreateProjectForm");
    pop.style.display    = "block";
    
    LockButtons();
 }
 
 function OpenLoadProducts(){
    var pop  = document.getElementById("LoadProductsForm");
    pop.style.display    = "block";
    
    LockButtons();
 }
 
 function OpenProjectOptions(){
    var pop  = document.getElementById("ProjectOptionsForm");
    pop.style.display    = "block";
    
    LockButtons();
 }

 function OpenProjectEditor(){
    
    var status          = SetProjectName("projectNameToEdit");
    
    if( status === true ) {
        var pop  = document.getElementById("ProjectEditorForm");
        pop.style.display   = "block";
        
        CloseProjectOptions();
        LockButtons();
        LoadProjectData();
    }
 }
 
 function OpenProjectDelete(){
     
    var status          = SetProjectName("projectNameToDelete");
    
    if( status === true ) {
        var pop  = document.getElementById("ProjectDeleteForm");
        pop.style.display   = "block";
        
        CloseProjectOptions();
        LockButtons();
    }
 }
 
 function OpenAssignProject(){
     
    var status          = SetProjectName("projectNameToAssign");
    
    if( status === true ) {
        var pop  = document.getElementById("FormToAssignProject");
        pop.style.display   = "block";
        
        CloseProjectOptions();
        LockButtons();
    }
 }
 
 function OpenUnassignProject(){
    
    document.getElementById("usernameToUnassign").disabled  = true;
    var status          = SetProjectName("projectNameToUnassign");
    
    if( status === true ) {
        var pop  = document.getElementById("FormToUnassignProject");
        pop.style.display   = "block";
        
        CloseProjectOptions();
        GetProjectOwner();
        LockButtons();
    }
 }


 function CloseCreateProject(){
    var pop  = document.getElementById("CreateProjectForm");
    pop.style.display    = "none";
    
    document.getElementById('ExcelFile').value  =   "";
    UnlockButtons();
 }
 
 function CloseLoadProductsForm(){
    var pop  = document.getElementById("LoadProductsForm");
    pop.style.display    = "none";
    
    document.getElementById('ExcelFile').value  =   "";
    UnlockButtons();
 }
 
 function CloseProjectOptions(){
    var pop  = document.getElementById("ProjectOptionsForm");
    pop.style.display    = "none";

    document.getElementById("ProjectList").value    = "";
    UnlockButtons();
 }
 
 function CloseProjectEditor(){
    var pop  = document.getElementById("ProjectEditorForm");
    pop.style.display    = "none";
    
    document.getElementById("newProjectName").value = "";
    document.getElementById("startDate").value      = "";
    document.getElementById("finishDate").value     = "";
    
    UnlockButtons();
 }
 
 function CloseProjectDelete(){
    var pop  = document.getElementById("ProjectDeleteForm");
    pop.style.display    = "none";
    
    UnlockButtons();
 }
 
 function CloseAssignProject(){
    var pop  = document.getElementById("FormToAssignProject");
    pop.style.display    = "none";
    
    UnlockButtons();
 }
 
 function CloseUnassignProject(){
    var pop  = document.getElementById("FormToUnassignProject");
    pop.style.display    = "none";
    
    UnlockButtons();
 }
 

//  MAIN FUNCTIONS
 function handleFileSelect(evt) {
    var filename    = document.getElementById('ExcelFile').value;
    var status      = isValidExcel(filename, "ExcelFile");
    
    if( status === true ){
        sessionStorage.setItem("projectName", filename);
        var files = evt.target.files;
        var xl2json = new ExcelToJSON();
        xl2json.parseExcel(files[0]);
    }
 }
 
 function verifyExcelFile(evt) {
alert("In Proccess");
/*    var filename    = document.getElementById('ExcelFile').value;
    var status      = isValidExcel(filename, "ExcelFile"); 
    
    if( status === true ){
        var files = evt.target.files;
        var xl2json = new PrepareProductsToJSON();
        xl2json.parseExcel(files[0]);    
    }
*/
 } 

 function ExcelToJSON() {
    this.parseExcel = function(file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
        
            workbook.SheetNames.forEach(function(sheetName) {
            
                // The JSON is modificated here
                var XL_row_object   = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                var jsonComplete    = JSON.stringify(XL_row_object);
                var jsonPartidas    = JSON.parse(jsonComplete);
                var arrayResumen    = [];
                var arrayImpPres    = [];
                
                for(i=0; i<jsonPartidas.length; i++){
                    
                    if( jsonPartidas[i].Nat == "Partida"){
                        arrayResumen.push(jsonPartidas[i].Resumen);
                        arrayImpPres.push(jsonPartidas[i].ImpPres.replace(/,/g,""));
                    }
                }
                
                sessionStorage.setItem("arrayResumen", JSON.stringify(arrayResumen));
                sessionStorage.setItem("arrayImpPres", JSON.stringify(arrayImpPres));
            });
        };

        reader.onerror = function(ex) {
            alert(ex);
        };

        reader.readAsBinaryString(file);
    };
 }
 
 function PrepareProductsToJSON() {
    alert("Load Excel Data");
 }
 
 function CreateProject(){
    var aux1    = sessionStorage.getItem("arrayResumen");
    var aux2    = sessionStorage.getItem("arrayImpPres");
 
    if( aux1 === "" || aux2 === "" ){
        alert("ERROR: El archivo excel no contiene datos");
    
    }else{
        var arrayResumen    = aux1;
        var arrayImpPres    = aux2;
        var username        = sessionStorage.getItem("USERNAME");
            aux1            = sessionStorage.getItem("projectName");
            aux2            = aux1.substr(12);
        var aux3            = aux2.split(".");
        var projectName     = aux3[0];

        var data    = "arrayResumen=" + arrayResumen + "&arrayImpPres=" + arrayImpPres + "&username=" + username + "&projectName=" + projectName;
       
        $.post("php/createProject.php", data, function(DATA){
            sessionStorage.setItem("arrayResumen", "");
            sessionStorage.setItem("arrayImpPres", "");
            
            if(DATA.ERROR === true ){
                alert(DATA.MESSAGE);
                CloseCreateProject();
                ClearDataProject();
            
            }else{
                alert(DATA.MESSAGE);
                ClearDataProject();
                location.reload();
            
            }
        });
    }
 }
 
 function LoadProducts(){
     alert("Load Products");
 }
 
 function ClearDataProject(){
    sessionStorage.setItem("arrayResumen", "");
    sessionStorage.setItem("arrayPrPres", "");
    sessionStorage.setItem("projectName", "");
 }
 
 function LoadProjects(){
     
    $.post("php/loadProjects.php", "", function(DATA){
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
        }
    });
 }
 
 function LoadUsers(){
    $.post("php/listUsers.php", "", function(DATA){
        if( DATA.ERROR === true ){
            alert(DATA.MESSAGE);
         
        }else{
            var count       = 0;
            var userList    = document.getElementById("UsersList");
            var arrayUsers  = [];
            
            while( count < DATA.count ){
                var option          = document.createElement("option");
                option.text         = (count + 1) + " - " + DATA[count].name + " " + DATA[count].lastname;
                arrayUsers.push(DATA[count].username);
                userList.add(option);
                
                count++;
            }
            sessionStorage.setItem("assignProjectToUser", JSON.stringify(arrayUsers));
            userList.value   = "";
        }
    });
 }
 
 function SetProjectName(id){
    var projectName = document.getElementById("ProjectList").value;
    
    if( projectName === ""){
        alert("ERROR: Debe seleccionar alg煤n proyecto de la lista");
        return false;
        
    }else{
        document.getElementById(id).innerHTML    = projectName;
        return true;
    }
    
 }
 
 function LoadProjectData(){
    var projectName =  document.getElementById("projectNameToEdit").innerHTML;
    var Variables   = "projectName=" + projectName;
  
    $.post("php/getProjectData.php", Variables, function(DATA){

        if( DATA.ERROR == true ){
            alert(DATA.MESSAGE);
            CloseProjectEditor();
        
        }else{
            sessionStorage.setItem("projectId", DATA.projectId);
            FocusOn("newProjectName");
            document.getElementById("newProjectName").value = DATA.projectName;
            document.getElementById("startDate").value      = DATA.startDate;
            document.getElementById("finishDate").value     = DATA.finishDate;
        }
    });
    
 }
 
 function EditProject(){
    var id          = sessionStorage.getItem("projectId");
    var name        = document.getElementById("newProjectName").value;
    var startDate   = document.getElementById("startDate").value;
    var finishDate  = document.getElementById("finishDate").value
  
    if( name === ""){
        alert("ERROR: El nombre del proyecto no puede estar vacio");
    
    }else if( startDate === "" ){
        alert("ERROR: La fecha de inicio puede estar vacia");
    
    }else if( finishDate === "" ){
        alert("ERROR: La fecha de termino puede estar vacia");
    
    }else if( finishDate <= startDate ){
        alert("ERROR: La fecha de termino no puede ser anterior o igual a la fecha de inicio del proyecto");
        document.getElementById("finishDate").value = "";
        
    }else{
        var Variables   = "id=" + id + "&name=" + name + "&startDate=" + startDate + "&finishDate=" + finishDate;
      
        $.post("php/updateProject.php", Variables, function(DATA){
            alert(DATA.MESSAGE);
            location.reload();
        });
    }
 }
 
 function DeleteProject(){
    var projectName = document.getElementById("projectNameToDelete").innerHTML;

    if( projectName === ""){
        alert("ERROR: El nombre del proyecto no puede estar vacio");
    
    }else{
        var Variables   = "projectName=" + projectName;
      
        $.post("php/deleteProject.php", Variables, function(DATA){
            alert(DATA.MESSAGE);
            location.reload();
        });
    }
 }
 
 function AssignProject(){
    var projectName = document.getElementById("projectNameToAssign").innerHTML;
    var aux         = document.getElementById("UsersList").value.split(" - ");
    var arrayUsers  = JSON.parse(sessionStorage.getItem("assignProjectToUser"));
    var username    = arrayUsers[aux[0] - 1];
    
    if( projectName === "" ){
        alert("ERROR: El nombre del proyecto no puede estar vacio");
    
    }else if( username == undefined ){
        alert("ERROR: Debes seleccionar un usuario para la asignaci贸n");
        
    }else{
        var Variables   = "projectName=" + projectName + "&username=" + username;
      
        $.post("php/assignProject.php", Variables, function(DATA){
            alert(DATA.MESSAGE);
            sessionStorage.setItem("assignProjectToUser", "");
            location.reload();
        });
    }
 }
 
 function GetProjectOwner(){
    var projectName = document.getElementById("projectNameToUnassign").innerHTML;
    var Variable    = "projectName=" + projectName;
    
    $.post("php/getProjectData.php", Variable, function(DATA){
        var username    = DATA.projectOwner;
        Variable        = "username=" + username;
        
        $.post("php/loadUser.php", Variable, function(DATA){
            
            if( DATA.nombre == undefined || DATA.apellido == undefined ){
                document.getElementById("usernameToUnassign").value = "No Registra";   
            }else{
                document.getElementById("usernameToUnassign").value = DATA.nombre + " " + DATA.apellido;
            }
        });    
    });
 }
 
 function UnassignProject(){
    var projectName = document.getElementById("projectNameToUnassign").innerHTML;
    var username    = document.getElementById("usernameToUnassign").value;
    
    if( username == "No Registra" ){
        alert("ERROR: No se puede desaginar un proyecto que no tiene encargado");
        CloseUnassignProject();
        
    }else{
        if( projectName === "" ){
            alert("ERROR: El nombre del proyecto no puede estar vacio");
            CloseUnassignProject();
        
        }else{
            var Variables   = "projectName=" + projectName;
          
            $.post("php/unassignProject.php", Variables, function(DATA){
                alert(DATA.MESSAGE);
                location.reload();
            });
        }    
    }
 }
 
 
 
 
 function LockButtons(){
    document.getElementById("OpenCreateProject").disabled       = true;
    document.getElementById("OpenProjectOptions").disabled      = true;
    document.getElementById("OpenLoadProducts").disabled       = true;
 }
 
 function UnlockButtons(){
    document.getElementById("OpenCreateProject").disabled       = false;
    document.getElementById("OpenProjectOptions").disabled      = false;
    document.getElementById("OpenLoadProducts").disabled       = false;
 }