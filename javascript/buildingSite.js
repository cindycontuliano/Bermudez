 
 window.onload    = StartupConfig;
 
 function StartupConfig(){
     
    document.getElementById("titlePage").innerHTML  = "Build Site";
    
//    LoadProducts();
    LoadStages();
    
 }
 



 function OpenCreateSPM(){
    var pop  = document.getElementById("SPMForm");
    pop.style.display    = "block";
    
    LockButtons();
 }
 
 
 function CloseSPMForm(){
    var pop  = document.getElementById("SPMForm");
    pop.style.display    = "none";
    
    UnlockButtons();
 }
 
 
 function LoadStages(){
    var username    = sessionStorage.getItem("USERNAME");
    var Variables   = "username=" + username;
    
    $.post("php/loadStages.php", Variables, function(DATA){

        if( DATA.ERROR === true ){
            alert(DATA.MESSAGE);
         
        }else{
            var count       = 0;
            var listStages  = document.getElementById("listStages");
            
            while( count < DATA.count ){
                var option          = document.createElement("option");
                option.text         = DATA[count].stageName;
                listStages.add(option);
                
                count++;
            }
            listStages.value   = "";
        }
    });
 }
 
 function LoadProducts(){
    
    $.post("php/loadProducts.php", "", function(DATA){
        console.log(DATA);
    });
 }
 
 
 function LockButtons(){
    document.getElementById("OpenCreateSPM").disabled     = true;
 }
 
 function UnlockButtons(){
    document.getElementById("OpenCreateSPM").disabled     = false;
 }