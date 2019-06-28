
 window.onload  = StartupConfig;
 
 function StartupConfig(){
    RemoveElement("ContainerReturnMainMenu");
    document.getElementById("titlePage").innerHTML  = "Menú Principal"; 
    
    var aux         = JSON.parse(sessionStorage.getItem("PERMISSIONS"));
    var permissions = aux.split("");
    
    if( permissions.length  == "0" ){
        alert("ERROR: No tienes registro de permisos. Solicita permisos al administrador.");
        Logout();
    
    }else{
        
        /*  The permissions are:
            * 1) Admin
            * 2) Obra
            * 3) Supervisor
            * 4) Presupuesto
            * 5) Adquisiciones
        */
        
        if( permissions[0] == "1" ){
            CreateAccessToArea("OpenAdministration", "Gestión Administrativa", "containtAdministration", "img/adminUsers.jpg");
        
        }else if( permissions[0] != "0" ){
            PermissionDeniedError(permissions[0]);
        }
    
        if( permissions[1] == "2" ){
            CreateAccessToArea("OpenBuildsite", "Gestión de Obras", "containtBuildSite", "img/buildSite.jpg");
            
        }else if( permissions[1] != "0" ){
            PermissionDeniedError(permissions[1]);
        }
        
        
        if( permissions[2] == "3" ){
            CreateAccessToArea("OpenBudget", "Gestión de Presupuestos", "containtBudget", "img/budget.jpg");

        }else if( permissions[2] != "0" ){
            PermissionDeniedError(permissions[2]);
        }
        
        
        if( permissions[3] == "4" ){
//            alert("Vista de Supervisor");
        
        }else if( permissions[3] != "0" ){
            PermissionDeniedError(permissions[3]);
        }
        
        
        if( permissions[4] == "5" ){
            CreateAccessToArea("OpenAcquisition", "Gestión de Adquisiciones", "containtAcquisition", "img/acquisitions.jpg");
            
        }else if( permissions[4] != "0" ){
            PermissionDeniedError(permissions[4]);
        }
    }
 }
 
 function CreateAccessToArea(FunctionName, Title, ContainerID, sourceImg){
    var body    = document.getElementById(ContainerID);
    
    var Text            = Title.bold();
    var label           = document.createElement("label");
        label.innerHTML = Text;
        
    var button              = document.createElement("button");
        button.className    = "btn btn-default btn-circle";
        button.setAttribute("id", "button" + Title);
        button.setAttribute("onclick", FunctionName+"()");
        
    var imagen              = document.createElement("img");
        imagen.className    = "brand_logo";
        imagen.alt          = "Logo";
        imagen.src          = sourceImg;
    
    body.appendChild(label);
    button.appendChild(imagen);
    body.appendChild(button);
    
 }
 
 function PermissionDeniedError(permission){
    alert("ERROR: Usted tiene registrado un permiso no válido. Por Favor contáctese con el Administrador del Sistema");
    Logout();
 }
 
 function RemoveElement(id){
    var element = document.getElementById(id);
    element.parentNode.removeChild(element);
 }
 
 function OpenAdministration(){
     location.href = "adminUsers.php";
 }
 
 function OpenBuildsite(){
     location.href = "buildingSite.php";
 }
 
 function OpenBudget(){
     location.href = "budget.php";
 }
 
 function OpenAcquisition(){
     location.href = "acquisitions.php";
 }