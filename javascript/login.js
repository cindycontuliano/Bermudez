
 window.onload  = StartupConfig;
 
 function StartupConfig(){
    FocusOn("uname");
    FormatRut("uname");
    EventToPressEnter("Validate", "");
    EventToChangeInput("uname");
 }


 function Validate(){
     
    var status      = isValidRut("uname");
    
    if( status === true ){
        var rut         = document.getElementById("uname").value;
        var username    = ParseRut(rut);
        var password    = document.getElementById("psw").value;
    
        if( password === "" ){
            alert("ERROR: Debes ingresar tu clave");
            document.getElementById("uname").style.borderColor = "white";
            document.getElementById("psw").style.borderColor = "red";
            document.getElementById("psw").focus();
            
        
        }else{
            var Variables   = "username="+username + "&password="+password;
        
            $.post("php/login.php", Variables, function(DATA){
        
                if( DATA.ERROR === false ){
                    
                    sessionStorage.setItem("USERNAME", username);
                    sessionStorage.setItem("NAME", DATA.name);
                    sessionStorage.setItem("LASTNAME", DATA.lastname);
                    sessionStorage.setItem("PERMISSIONS", JSON.stringify(DATA.permissions));
                    
                    var permissions = DATA.permissions.split("");
                    var status      = false;
                    var count       = 0;
                    
                    for( var i=0; i<permissions.length; i++){
                        if( permissions[i] != "0" ){
                            count++;
                        }
                    }
                    
                    if( count > 1 ){
                        location.href   = "mainMenu.php";
                    
                    }else{
                     
                        for( i=0; i<permissions.length; i++){
                            if( permissions[i] != "0" ){
                                switch(i+1){
                                    case 1:
                                        location.href   = "adminUsers.php";
                                        break;
                                    
                                    case 2:
                                        location.href   = "buildingSite.php";
                                        break;
                                        
                                    case 3:
                                        location.href   = "budget.php";
                                        break;
                                        
                                    case 4:
                                        location.href   = "mainMenu.php";
                                        break;
                                    
                                    case 5:
                                        location.href   = "acquisitions.php";
                                        break;
                                }  
                            }
                        }
                     
                    }
                    
                }else{
                    switch(DATA.MESSAGE){
                        case 1:
                            alert("ERROR: Clave incorrecta");
                            document.getElementById("psw").focus();
                            document.getElementById("psw").value    = "";
                            document.getElementById("psw").style.borderColor = "red";
                            document.getElementById("uname").style.borderColor = "white";
                            break;
                        case 2:
                            alert("ERROR: El usuario "+username+ " no está registrado");
                            CleanInputs();
                            document.getElementById("uname").focus();
                            document.getElementById("uname").style.borderColor = "red";
                            document.getElementById("psw").style.borderColor = "white";
                            break;
                    }
                }
                
            });
        }    
    }
 }
