<?php

    function BD_connect(){
        $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = grad.icmc.usp.br)(PORT = 15215)))(CONNECT_DATA=(SID=orcl)))" ;
        $user = "";
        $password = "";
        if($conn = oci_connect($user, $password, $db)){
            return $conn;
         }
         else{
            echo "<h3>Erro na conexão com banco de dados!</h3>";
            return null;
         }
    }

    function BD_returnrow($query){
        $conn = BD_connect();

        if($conn != null){
            $stid = oci_parse($conn, $query);

            if( !oci_execute($stid) ) {
                $e = oci_error();
                echo htmlentities($e['message'], ENT_QUOTES);
                oci_close($conn);
                return $e;
            }
            else{
                $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
                oci_close($conn);
                return $row;
            }
        }
        else{
            return null;
        }

    }

    function BD_returnrows($query){
        $conn = BD_connect();

        if($conn != null){
            $stid = oci_parse($conn, $query);

            if( !oci_execute($stid) ) {
                $e = oci_error();
                echo htmlentities($e['message'], ENT_QUOTES);
                oci_close($conn);
                return $e;
            }
            else{
                oci_close($conn);
                return $stid;
            }
        }
        else{
            return null;
        }

    }
     
    function BD_execute($query){
        $conn = BD_connect();

        if($conn != null){
            $stid = oci_parse($conn, $query);

            if( !oci_execute($stid) ) {
                $e = oci_error();
                echo htmlentities($e['message'], ENT_QUOTES);
                oci_close($conn);
                return $e;
            }
            else{
                // Commit the changes to both tables
                $r = oci_commit($conn);
                if (!$r) {
                    $e = oci_error($conn);
                    trigger_error(htmlentities($e['message']), E_USER_ERROR);
                }
                oci_close($conn);
                return $stid;
            }
        }
        else{
            return null;
        }

    }
        
?>
