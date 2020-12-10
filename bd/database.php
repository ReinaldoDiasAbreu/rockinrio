<?php
     
    function BD_connect(){
        $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = grad.icmc.usp.br)(PORT = 15215)))(CONNECT_DATA=(SID=orcl)))" ;

        if($conn = oci_connect("G7m22129", "password", $db)){
            return $conn;
         }
         else{
            return null;
         }
    }
     
        
?>