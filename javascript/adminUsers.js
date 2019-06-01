 
 window.onload    = LoadConfiguration;
 
 function LoadConfiguration(){
    document.getElementById("ButtonModifyUser").addEventListener("click", function(){
        ModifyUser();
    });
    
    FormatRut("addUname");
    FormatRut("searchUname");
    FormatRut("usernamePrevious");
    FormatRut("deleteUname");
    
    EventToPressEnter("LoadUser", "searchUname");
    EventToPressEnter("DeleteUser", "deleteUname");
    
    EventToChangeInput("addUname");
    EventToChangeInput("searchUname");
    EventToChangeInput("usernamePrevious");
    EventToChangeInput("deleteUname");
 }
 


 function OpenAddUser(){
    var pop  = document.getElementById("AddUserForm");
    pop.style.display    = "block";
    
    FocusOn("addUname");
    LockButtons();
 }
 
 function OpenLoadUser(){
    var pop  = document.getElementById("LoadUserForm");
    pop.style.display    = "block";
    
    FocusOn("searchUname");
    LockButtons();
 }
 
 function OpenSearchResults(){
    var pop  = document.getElementById("SearchResultsForm");
    pop.style.display    = "block";
    
    LockButtons();
 }

 function OpenDeleteUser(){
    var pop  = document.getElementById("DeleteUserForm");
    pop.style.display    = "block";
    
    document.getElementById("deleteUname").focus();
    LockButtons();
 }
 
 function OpenListUsers(){
    var pop  = document.getElementById("ListUsersForm");
    pop.style.display    = "block";
    
    LockButtons();
    GetListUsers();
 }
 
 

 function CloseAddUser(){
    var pop  = document.getElementById("AddUserForm");
    pop.style.display    = "none";
    
    document.getElementById("addUname").value       = "";
    ClearPermissions();
    document.getElementById("addName").value        = "";
    document.getElementById("addLastname").value    = "";
    document.getElementById("addEmail").value       = "";
    document.getElementById("addPhone").value       = "";
    
    UnlockButtons();
 }
 
 function CloseLoadUser(){
    var pop  = document.getElementById("LoadUserForm");
    pop.style.display    = "none";

    document.getElementById("searchUname").value       = "";
    UnlockButtons();
 }
 
 function CloseSearchResults(){
    var pop  = document.getElementById("SearchResultsForm");
    pop.style.display    = "none";
    
    document.getElementById("searchUname").readOnly     = false;
    document.getElementById("searchUname").disabled     = false;
    
    sessionStorage.setItem("resultUsername", "");
    
    ClearPermissions();
    document.getElementById("resultName").value         = "";
    document.getElementById("resultLastname").value     = "";
    document.getElementById("resultEmail").value        = "";
    document.getElementById("resultPhone").value        = "";
    
    UnlockButtons();
 }
 
 function CloseDeleteUser(){
    var pop  = document.getElementById("DeleteUserForm");
    pop.style.display    = "none";
    
    document.getElementById("deleteUname").value    = "";
    
    UnlockButtons();
 }
 
 function CloseSearchUsers(){
    var pop  = document.getElementById("SearchUsersForm");
    pop.style.display    = "none";
    
    UnlockButtons();
 }
 
 function CloseListUsers(){
    var pop  = document.getElementById("ListUsersForm");
    pop.style.display    = "none";
    
    CleanListUSers();
    UnlockButtons();
 }
 
 
 
 

 function AddUser(){

    var status      = isValidRut("addUname");
    
    if( status === true ){
        var rut         = document.getElementById("addUname").value;
        var username    = ParseRut(rut);
        var permissions = VerifyPermissions();
        
        if( permissions == "0" ){
            alert("ERROR: Debes seleccionar almenos un permiso");
        
        }else{
            var name        = document.getElementById("addName").value;
            status          = isValidName(name, "nombre");
            
            if( status === true ){
                var lastname    = document.getElementById("addLastname").value;
                status          = isValidName(lastname, "apellido");
                
                if( status  === true ){
                    var email   = document.getElementById("addEmail").value;
                    status      = isValidEmail(email);
                    
                    if( status === true ){
                        name            = DeleteWhiteSpace(name);
                        lastname        = DeleteWhiteSpace(lastname);
                        
                        var phone       = document.getElementById("addPhone").value;
                        var Variables   = "username=" + username + "&permissions=" + permissions + "&name=" + name + "&lastname=" + lastname + "&email=" + email + "&phone=" + phone;
                        
                        $.post("php/addUser.php", Variables, function(DATA){
                            alert(DATA.MESSAGE);
                            CloseAddUser();
                        });
                    }
                }
            }
        }
    }
 }
 
 function VerifyPermissions(){
    var permissions     = "";
    var error           = true;
    
    var AdminType       = document.getElementById("AdminType").checked;
    var BuildsiteType   = document.getElementById("BuildsiteType").checked;
    var SupervisorType  = document.getElementById("SupervisorType").checked;
    var BudgetType      = document.getElementById("BudgetType").checked;
    var AcquisitionType = document.getElementById("AcquisitionType").checked;
    
    if( AdminType === true ){
        permissions += "1";
        error        = false;
    }else{
        permissions += "0";
    }
    
    if( BuildsiteType === true ){
        permissions += "2";
        error        = false;
    }else{
        permissions += "0";
    }
    
    if( SupervisorType === true ){
        permissions += "3";
        error        = false;
    }else{
        permissions += "0";
    }
    
    if( BudgetType === true ){
        permissions += "4";
        error        = false;
    }else{
        permissions += "0";
    }
    
    if( AcquisitionType === true ){
        permissions += "5";
        error        = false;
    }else{
        permissions += "0";
    }
    
    
    
    if( error === false){
        return permissions;
    }else{
        return 0;
    }
    
 }
 
 function ClearPermissions(){
    document.getElementById("AdminType").checked                = false;
    document.getElementById("BuildsiteType").checked            = false;
    document.getElementById("SupervisorType").checked           = false;
    document.getElementById("BudgetType").checked               = false;
    document.getElementById("AcquisitionType").checked          = false; 
     
    document.getElementById("AdminPermission").checked          = false;
    document.getElementById("BuildsitePermission").checked      = false;
    document.getElementById("SupervisorPermission").checked     = false;
    document.getElementById("BudgetPermission").checked         = false;
    document.getElementById("AcquisitionPermission").checked    = false;

 }
 
 function GetPermissions(){
       var permissions     = "";
    var error           = true;
    
    var AdminType       = document.getElementById("AdminPermission").checked;
    var BuildsiteType   = document.getElementById("BuildsitePermission").checked;
    var SupervisorType  = document.getElementById("SupervisorPermission").checked;
    var BudgetType      = document.getElementById("BudgetPermission").checked;
    var AcquisitionType = document.getElementById("AcquisitionPermission").checked;
    
    if( AdminType === true ){
        permissions += "1";
        error        = false;
    }else{
        permissions += "0";
    }
    
    if( BuildsiteType === true ){
        permissions += "2";
        error        = false;
    }else{
        permissions += "0";
    }
    
    if( SupervisorType === true ){
        permissions += "3";
        error        = false;
    }else{
        permissions += "0";
    }
    
    if( BudgetType === true ){
        permissions += "4";
        error        = false;
    }else{
        permissions += "0";
    }
    
    if( AcquisitionType === true ){
        permissions += "5";
        error        = false;
    }else{
        permissions += "0";
    }
    
    
    
    if( error === false){
        return permissions;
    }else{
        return 0;
    }
 }
 
 function LoadUser(){
    
    var status      = isValidRut("searchUname");
    
    if( status === true ){
        var rut         = document.getElementById("searchUname").value;
        var username    = ParseRut(rut);
        var Variables   = "username=" + username;
        
        $.post("php/loadUser.php", Variables, function(DATA){
            if( DATA.ERROR === false ){
                CloseLoadUser();
                OpenSearchResults();
                
                document.getElementById("searchUname").readOnly     = true;
                document.getElementById("searchUname").disabled     = true;
                
                SetPermissions(DATA.permisos.split(""));
                document.getElementById("usernamePrevious").value   = rut;
                document.getElementById("resultName").value         = DATA.nombre;
                document.getElementById("resultLastname").value     = DATA.apellido;
                document.getElementById("resultEmail").value        = DATA.correo;
                document.getElementById("resultPhone").value        = DATA.telefono;
                
                sessionStorage.setItem("idUsername", DATA.id);
            
            }else{
                alert(DATA.MESSAGE);
                CloseSearchUser();
            }
        });
    }
 }
 
 function SetPermissions(permissions){

    if( permissions[0] == "1" ){
        document.getElementById("AdminPermission").checked   = true;
    }
    
    if( permissions[1] == "2" ){
        document.getElementById("BuildsitePermission").checked   = true;
    }
    
    if( permissions[2] == "3" ){
        document.getElementById("SupervisorPermission").checked   = true;
    }
    
    if( permissions[3] == "4" ){
        document.getElementById("BudgetPermission").checked   = true;
    }
    
    if( permissions[4] == "5" ){
        document.getElementById("AcquisitionPermission").checked   = true;
    }
 }
 
 function ModifyUser(){
    var id          = sessionStorage.getItem("idUsername");
    var status      = isValidRut("usernamePrevious");
    
    if( status === true ){
        var rut         = document.getElementById("usernamePrevious").value;
        var username    = ParseRut(rut);
        var permissions = GetPermissions();
        
        if( permissions == "0" ){
            alert("ERROR: Debes seleccionar almenos un permiso");
        
        }else{
            
            var name        = document.getElementById("resultName").value;
            status          = isValidName(name, "nombre");
            
            if( status === true ){
                var lastname    = document.getElementById("resultLastname").value;
                status          = isValidName(lastname, "apellido");
                
                if( status  === true ){
                    var email   = document.getElementById("resultEmail").value;
                    status      = isValidEmail(email);
                    
                    if( status === true ){
                        name            = DeleteWhiteSpace(name);
                        lastname        = DeleteWhiteSpace(lastname);
                        
                        var phone       = document.getElementById("resultPhone").value;
                        var Variables   = "id=" + id + "&username=" + username + "&permissions=" + permissions + "&name=" + name + "&lastname=" + lastname + "&email=" + email + "&phone=" + phone;
            
                        $.post("php/modifyUser.php", Variables, function(DATA){
                            alert(DATA.MESSAGE);
                            CloseSearchResults();
                        });
                    }
                }
            }
        }
    }
 }
 
 function DeleteUser(){
    
    var status      = isValidRut("deleteUname");
    
    if( status === true ){
        var rut         = document.getElementById("deleteUname").value;
        var username    = ParseRut(rut);
        var Variables   = "username=" + username;
        
        $.post("php/deleteUser.php", Variables, function(DATA){
            alert(DATA.MESSAGE);
            CloseDeleteUser();
        });        
    }

 }
 
 function GeneratePermissionsList(permissions){
     
    var arrayPermissions    = permissions.split("");
    var Select              = document.createElement("select");
    
    for( var i=0; i<arrayPermissions.length; i++){
        var option      = document.createElement("option");
        option.text = ParsePermission(arrayPermissions[i]);
        
        if( option.text != "" ){
            Select.add(option);    
        }
    }
    Select.selectedIndex = "0";  
    return Select;
 }
 
 function GetListUsers(){
     $.post("php/listUsers.php", "",function(DATA){
        
        // Create the Table´s Body
	    var table       = document.getElementById("ListUsers");
	    var bodyTable   = document.createElement("tbody");
	 
	 
	    // Create the rows
	    for (var i = 0; i < DATA.count; i++){

	        // Here is created every row
	        var row             = document.createElement("tr");
	 
	 	    // Here is created every cell
	 	    var usernameCell    = document.createElement("td");
	 	    var typeCell	    = document.createElement("td");
	        var nameCell	    = document.createElement("td");
	        var lastnameCell    = document.createElement("td");
	        var emailCell 		= document.createElement("td");
	        var phoneCell		= document.createElement("td");
	  
	        // Here is storaged the content into a node
	        var username		= document.createTextNode( GenerateRut(DATA[i].username) );
		    var name 			= document.createTextNode( DATA[i].name );
		    var lastname 		= document.createTextNode( DATA[i].lastname );
		    var email 		    = document.createTextNode( DATA[i].email );
		    var phone 			= document.createTextNode( DATA[i].phone );
		
	        // Here is inserted the content into the cells
    	    usernameCell.appendChild(username);
    	    typeCell.appendChild( GeneratePermissionsList( DATA[i].permissions ) );
    	    nameCell.appendChild(name);
    	    lastnameCell.appendChild(lastname);
    	    emailCell.appendChild(email);
    	    phoneCell.appendChild(phone);
	    
	        // Here is inserted the cells into a row
	        row.appendChild(usernameCell);
	        row.appendChild(typeCell);
	        row.appendChild(nameCell);
	        row.appendChild(lastnameCell);
	        row.appendChild(emailCell);
	        row.appendChild(phoneCell);
	 
	        // Here is inserted the row into the table´s body
	        bodyTable.appendChild(row);
	  }
	 
	  // Here is inserted the body´s table into the table
	  table.appendChild(bodyTable);

	  // Here is modificated the table´s attributes "border", and set it in 2px.
	  table.setAttribute("border", "2");

     });
 }
 
 function CleanListUSers(){
    var count       = document.getElementById("ListUsers").rows.length;
    
    for( var i = 0; i < count - 1; i++){
        document.getElementById("ListUsers").deleteRow(1);
    }
 }
 
 function LockButtons(){
    document.getElementById("OpenAddUser").disabled     = true;
    document.getElementById("OpenModifyUser").disabled  = true;
    document.getElementById("OpenDeleteUser").disabled  = true;
    document.getElementById("OpenListUsers").disabled   = true;
 }
 
 function UnlockButtons(){
    document.getElementById("OpenAddUser").disabled     = false;
    document.getElementById("OpenModifyUser").disabled  = false;
    document.getElementById("OpenDeleteUser").disabled  = false;
    document.getElementById("OpenListUsers").disabled   = false;
 }