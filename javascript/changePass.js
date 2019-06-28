
 window.onload  = StartupConfig;
 
 function StartupConfig(){
    HideDropdown();
    FormatRut("uname");
    EventToPressEnter("ChangePass", "");
    FocusOn("uname");
 }

 function HideDropdown(){
    var element         = document.getElementById("containerDropdown");
    element.className   = "d-none";
 }

 function ChangePass(){
     
    var status      = isValidRut("uname");
    
    if( status === true ){
        var rut         = document.getElementById("uname").value;
        var username    = ParseRut(rut);
        var Variables   = "username="+username;
    
        $.post("php/changePass.php", Variables, function(DATA){

            if( DATA.ERROR === false ){
                alert(DATA.MESSAGE);
                location.href = ("index.php");
                
            }else{
                alert(DATA.MESSAGE);
                document.getElementById("uname").value  = "";
                FocusOn("uname");
            }
            
        });
    
    }
 }
 
 function ReturnMainMenu(){
    location.href = "index.php";
 }