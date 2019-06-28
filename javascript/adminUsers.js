 
 window.onload    = LoadConfiguration;
 
 function LoadConfiguration(){
    document.getElementById("titlePage").innerHTML  = "Gestión Administrativa";
    
    $('#bttnCloseUpdateUser').click(function(){
        $('#SearchResultsForm').modal('toggle');
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
 
 function AddUser(){

    var status      = isValidRut("addUname");
    
    if( status === true ){
        var rut         = document.getElementById("addUname").value;
        var username    = ParseRut(rut);
        var permissions = VerifyPermissions();
        
        if( permissions == "0" ){
            alert("ERROR: Debes seleccionar almenos un permiso");
        
        }else{
            var name        = NormalizeString(document.getElementById("addName").value);
            status          = isValidName(name, "nombre");
            
            if( status === true ){
                var lastname    = NormalizeString(document.getElementById("addLastname").value);
                status          = isValidName(lastname, "apellido");
                
                if( status  === true ){
                    var email   = document.getElementById("addEmail").value;
                    status      = isValidEmail(email);
                    
                    if( status === true ){
                        
                        var phone       = document.getElementById("addPhone").value;
                        var Variables   = "username=" + username + "&permissions=" + permissions + "&name=" + name + "&lastname=" + lastname + "&email=" + email + "&phone=" + phone;
                        
                        $.post("php/addUser.php", Variables, function(DATA){
                            
                            if( DATA.ERROR  === true ){
                                alert(DATA.MESSAGE);    

                                $('#addUname').val('');
                                $("#AdminType").prop("checked", false);
                                $("#BuildsiteType").prop("checked", false);
                                $("#SupervisorType").prop("checked", false);
                                $("#BudgetType").prop("checked", false);
                                $("#AcquisitionType").prop("checked", false);
                                $('#addName').val('');
                                $('#addLastname').val('');
                                $('#addEmail').val('');
                                $('#addPhone').val('');

                            }else{
                                
                                alert(DATA.MESSAGE);
                                
                                CloseModal('#AddUserForm');
                                
                                $('#addUname').val('');
                                $("#AdminType").prop("checked", false);
                                $("#BuildsiteType").prop("checked", false);
                                $("#SupervisorType").prop("checked", false);
                                $("#BudgetType").prop("checked", false);
                                $("#AcquisitionType").prop("checked", false);
                                $('#addName').val('');
                                $('#addLastname').val('');
                                $('#addEmail').val('');
                                $('#addPhone').val('');
                                
                            }
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
                
                $('#searchUname').val('');
                $('#usernamePrevious').val(rut);
                
                $('#usernamePrevious').attr('readonly', true);
                $('#usernamePrevious').attr('disabled', true);
                
                SetPermissions(DATA.permisos.split(""));
                
                $('#resultName').val(DATA.nombre);
                $('#resultLastname').val(DATA.apellido);
                $('#resultEmail').val(DATA.correo);
                $('#resultPhone').val(DATA.telefono);
                
                $('#SearchResultsForm').modal('show');
                
                sessionStorage.setItem("idUsername", DATA.id);
            }else{
                alert(DATA.MESSAGE);
                $('#searchUname').val('');
            }
        });
    }
 }
 
 function SetPermissions(permissions){
    if( permissions[0] == "1" ){
        $("#AdminPermission").prop("checked", true);
    }
    
    if( permissions[1] == "2" ){
        $("#BuildsitePermission").prop("checked", true);
    }
    
    if( permissions[2] == "3" ){
        $("#SupervisorPermission").prop("checked", true);
    }
    
    if( permissions[3] == "4" ){
        $("#BudgetPermission").prop("checked", true);
    }
    
    if( permissions[4] == "5" ){
        $("#AcquisitionPermission").prop("checked", true);
    }
 }
 
 function UpdateUser(){
    var id          = sessionStorage.getItem("idUsername");
    var status      = isValidRut("usernamePrevious");
    
    if( status === true ){
        var rut         = document.getElementById("usernamePrevious").value;
        var username    = ParseRut(rut);
        var permissions = GetPermissions();
        
        if( permissions == "0" ){
            alert("ERROR: Debes seleccionar almenos un permiso");
        
        }else{
            
            var name        = NormalizeString(document.getElementById("resultName").value);
            status          = isValidName(name, "nombre");
            
            if( status === true ){
                var lastname    = NormalizeString(document.getElementById("resultLastname").value);
                status          = isValidName(lastname, "apellido");
                
                if( status  === true ){
                    var email   = document.getElementById("resultEmail").value;
                    status      = isValidEmail(email);
                    
                    if( status === true ){
                        
                        var phone       = document.getElementById("resultPhone").value;
                        var Variables   = "id=" + id + "&username=" + username + "&permissions=" + permissions + "&name=" + name + "&lastname=" + lastname + "&email=" + email + "&phone=" + phone;
            
                        $.post("php/updateUser.php", Variables, function(DATA){
                            
                            if( DATA.ERROR === false ){
                                alert(DATA.MESSAGE);
                                
                                CloseModal('#SearchResultsForm');

                            }else{
                                alert(DATA.MESSAGE);
                            }
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
            
            if( DATA.ERROR === false ){
                alert(DATA.MESSAGE);
            
                CloseModal('#DeleteUserForm');
                $('#deleteUname').val('');
            
            }else{
                alert(DATA.MESSAGE);
                $('#deleteUname').val('');
            }
            
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
    
    ClearTable("ListUsers");
     
    $.post("php/listUsers.php", "",function(DATA){
        
        // Create the Table´s Body
	    var table       = document.getElementById("ListUsers");
	    var bodyTable   = document.createElement("tbody");
	 
	 
	    // Create the rows
	    for (var i = 0; i < DATA.count; i++){

	        // Here is created every row
	        var row             = document.createElement("tr");
	 
	 	    // Here is created every cell
	 	    var numUserCell     = document.createElement("td");
	 	    var usernameCell    = document.createElement("td");
	 	    var typeCell	    = document.createElement("td");
	        var nameCell	    = document.createElement("td");
	        var lastnameCell    = document.createElement("td");
	        var emailCell 		= document.createElement("td");
	        var phoneCell		= document.createElement("td");
	  
	        // Here is storaged the content into a node
	        var numUser         = document.createTextNode( i + 1 );
	        var username		= document.createTextNode( GenerateRut(DATA[i].username) );
		    var name 			= document.createTextNode( DATA[i].name );
		    var lastname 		= document.createTextNode( DATA[i].lastname );
		    var email 		    = document.createTextNode( DATA[i].email );
		    var phone 			= document.createTextNode( DATA[i].phone );
		
	        // Here is inserted the content into the cells
	        numUserCell.appendChild(numUser);
    	    usernameCell.appendChild(username);
    	    typeCell.appendChild( GeneratePermissionsList( DATA[i].permissions ) );
    	    nameCell.appendChild(name);
    	    lastnameCell.appendChild(lastname);
    	    emailCell.appendChild(email);
    	    phoneCell.appendChild(phone);
	    
	        // Here is inserted the cells into a row
	        row.appendChild(numUserCell);
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
     });
     
     $('#ListUsersForm').modal('show');
 }