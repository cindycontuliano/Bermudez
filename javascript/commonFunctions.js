
 function FocusOn(id){
     document.getElementById(id).focus();
 }

 function ParsePermission(permission){
    permission          = parseInt(permission);
    var auxPermission   = "";
	        
    switch( permission ){
        case(1):
            auxPermission   = "Administrador";
            break;
            
        case(2):
            auxPermission   = "Obra";
            break;
            
        case(3):
            auxPermission   = "Supervisor";
            break;
       
        case(4):
            auxPermission   = "Presupuesto";
            break;
       
        case(5):
            auxPermission   = "Adquisiciones";
            break;
        
        default:
            auxPermissions  = "ERROR";
    }
    
    return auxPermission;
 }
 
 function ReturnMainMenu(){
    var aux         = JSON.parse(sessionStorage.getItem("PERMISSIONS"));
    var permissions = aux.split("");
    var status      = false;
    var count       = 0;
    
    for( var i=0; i<permissions.length; i++){
        if( permissions[i] != "0" ){
            count++;
        }
    }
    
    if( count == 1 ){
        location.href   = "index.php";
    
    }else{
        location.href   = "mainMenu.php";
    }
    
 }
 
 function Logout(){
    
    sessionStorage.setItem("USERNAME", "");
    sessionStorage.setItem("NAME", "");
    sessionStorage.setItem("LASTNAME", "");
    sessionStorage.setItem("PERMISSIONS", "");
    
    $.post("php/logout.php","",function(DATA){
        alert(DATA.MESSAGE);
        location.href = "index.php";
    });
 }
 
 function OpenChangePassword(){
    var containerPasswordForm   = document.getElementById("ChangePasswordForm");
    containerPasswordForm.style.display = "block";
 }

 function CloseChangePassword(){
    var containerPasswordForm   = document.getElementById("ChangePasswordForm");
    containerPasswordForm.style.display = "none";
 }
 
 function ChangePassword(){
    var rut                 = sessionStorage.getItem("USERNAME");
    var username            = ParseRut(rut);
    var oldPassword         = document.getElementById("oldPassword").value;
    var newPassword         = document.getElementById("newPassword").value;
    var confirmNewPassword  = document.getElementById("confirmNewPassword").value;
    
    if( oldPassword === "" ){
        alert("ERROR: Debes ingresar tu clave antigua");
        document.getElementById("oldPassword").style.borderColor    = "red";
        FocusOn("oldPassword");
      
    }else if( newPassword === "" ){
        alert("ERROR: Debes ingresar tu clave nueva");
        document.getElementById("oldPassword").style.borderColor = "white";
        document.getElementById("newPassword").style.borderColor = "red";
        FocusOn("newPassword");
    
    }else if( confirmNewPassword === "" ){
        alert("ERROR: Debes confirmar tu clave nueva");
        document.getElementById("oldPassword").style.borderColor = "white";
        document.getElementById("newPassword").style.borderColor = "white";
        document.getElementById("confirmNewPassword").style.borderColor = "red";
        FocusOn("confirmNewPassword");
    
    }else if( newPassword != confirmNewPassword ){
        alert("ERROR: Las claves nuevas no coinciden");
        
        document.getElementById("newPassword").value        = "";
        document.getElementById("confirmNewPassword").value = "";
    
        document.getElementById("oldPassword").style.borderColor = "white";
        document.getElementById("newPassword").style.borderColor = "red";
        FocusOn("newPassword");
    
    }else{
        
        var Variables   = "username=" + username + "&oldPassword=" + oldPassword + "&newPassword=" + newPassword;
    
        $.post("php/changePassword.php", Variables, function(DATA){
            
            if( DATA.ERROR === false ){
                alert(DATA.MESSAGE);
                CloseChangePassword();
                Logout();
                
            }else{
                alert(DATA.MESSAGE);
                CloseChangePassword();
            }
            
        });
    }
 }
 
 function EventToPressEnter(Function, id){
     
    if( id === "" ){
        document.addEventListener("keypress", function(event){
            if (event.which == 13 || event.keyCode == 13){
                window[Function]();
            }
        });
        
    }else{
        document.getElementById(id).addEventListener("keypress", function(event){
            if (event.which == 13 || event.keyCode == 13){
                window[Function]();
            }
        });
    }
 }

  function EventToChangeInput(id){
     
    document.getElementById(id).addEventListener("change", function(event){
        var status  = isValidRut(id);
    });
 }


 function isValidName(String, Name){
    var regex   = /([a-zA-Z\ \u00C0-\u00FF]){1,30}$/;
    
    if( !regex.test(String) ){
        alert("ERROR: El " + Name + " ingresado tiene caracteres no válidos");
        return false;
    }else{
        return true;
    }
 }
 
  function isValidExcel(Filename, id){
    var regex   = /([a-zA-Z\ \u00C0-\u00FF]){1,30}\.(xlsx|xls)/g;
    
    if( !regex.test(Filename) ){
        alert("ERROR: El archivo no es un archivo excel");
        document.getElementById(id).value  = "";
        return false;
        
    }else{
        return true;
    }
 }
 
 function isValidEmail(Email){
    var regex       = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
     
    if( !regex.test(Email) ){
        alert("ERROR: El correo ingresado no es válido");
        return false;
    }else{
        return true;
    }
 }
 
 function DeleteWhiteSpace(String){
    var aux    = String.split(" ");
    return aux[0];
 }
 
  function ParseRut(rut){
      var spliterRut    = rut.split("-");
      var username      = spliterRut[0].replace(/\./g,"");
      return username;
  }

 function FormatRut(id){
     
    document.getElementById(id).addEventListener("keypress", function(event){
        var x       = event.which || event.keyCode;
        
        if (event.which != 13 || event.keyCode != 13){
            var char        = String.fromCharCode(x);
            var input       = document.getElementById(id).value;
            
            if( input === "" ){
                
            }else if( input.length == 1 ){
                document.getElementById(id).value = input + "-";
                
            }else{
                var valPrevious     = input.split("-");
                    valPrevious[0]  = clearFormat(valPrevious[0]);
                
                if( valPrevious[1] === undefined ){
                    var digits      = valPrevious[0].split("");
                    var DV          = digits[digits.length - 1];
                    
                    var rut             = "";
                    var count           = 0;
                    
                    for( var i=digits.length; i>0; i--){
                        
                        if( count == 3 ){
                            rut     = digits[i -1] + "." + rut;
                            count   = 1;
                        
                        }else{
                            rut     = digits[i - 1] + rut;
                            count++;
                        }
                    }
                    
                    document.getElementById(id).value = rut + "-" + DV;                   
                }else{
                    var value           = valPrevious[0] + "" + valPrevious[1];
                    var valueArray      = value.split("");
                    var rut             = "";
                    var count           = 0;
                    
                    for( var i=valueArray.length; i>0; i--){
                        
                        if( count == 3 ){
                            rut     = valueArray[i -1] + "." + rut;
                            count   = 1;
                        
                        }else{
                            rut     = valueArray[i - 1] + rut;
                            count++;
                        }
                    }
                    
                    document.getElementById(id).value = rut + "-" ;
                }
                
            }
        }
    });
 }
 
 function GenerateRut(Value){
    var dv      = computeDv(Value);
    Value       = Value.toString();
    var aux     = Value.split("");
    var digit1, digit2, digit3;
    
    if( aux.length == 7 ){
        digit1  = aux[0];
        digit2  = aux[1] + aux[2] + aux[3];
        digit3  = aux[4] + aux[5] + aux[6];
    
        return digit1 + "." + digit2 + "." + digit3 + "-" + dv;
    
    }else if( aux.length == 8 ){
        digit1  = aux[0] + aux[1];
        digit2  = aux[2] + aux[3] + aux[4];
        digit3  = aux[5] + aux[6] + aux[7];
    
        return digit1 + "." + digit2 + "." + digit3 + "-" + dv;
    
    }else{
        return "ERROR";
    }
    
     
 }
 
 function clearFormat(value){
	return value.replace(/[\.\-]/g, "");
 }
 
 function isValidRut(id){
	
	var rut     = document.getElementById(id).value;
	var regex   = /([1-9]{1,2})\.([0-9]{3})\.([0-9]{3})\-((K|k|[0-9])){1}$/;
	
	if( !regex.test(rut) ){ 
	    alert("ERROR: El rut ingresado no es válido");
	    document.getElementById(id).value   = "";
	    return false;
	}
	
	var cRut    = clearFormat(rut);
	var cDv     = cRut.charAt(cRut.length - 1).toUpperCase();
	var nRut    = parseInt(cRut.substr(0, cRut.length - 1));

    if( computeDv(nRut).toString().toUpperCase() === cDv ){
        return true;
        
    }else{
        alert("ERROR: El dígito verificador no coincide");
	    return false;
    }

 }

 function computeDv(rut) {
	var suma	= 0;
	var mul		= 2;
	
	if(typeof(rut) !== 'number') { return; }
	
	rut = rut.toString();
	
	for(var i=rut.length -1;i >= 0;i--) {
		suma = suma + rut.charAt(i) * mul;
		mul = ( mul + 1 ) % 8 || 2;
	}
	
	switch(suma % 11) {
		case 1	: return 'k';
		case 0	: return 0;
		default	: return 11 - (suma % 11);
	}
 }
