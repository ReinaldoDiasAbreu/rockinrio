<?php 
     include ('../bd/database.php');
     $func = isset($_POST["funcionario"])?$_POST["funcionario"]:"";
     $user = isset($_POST["user"])?$_POST["user"]:"";

     if($func != "" && $user != ""){
        $conn = BD_connect();

        if($func = "seguranca"){
            
            $stmt = "SELECT COUNT(*) FROM FUNCIONARIO WHERE CPFPESSOA = $user AND TIPOFUNCIONARIO = 'seg'";
            $stid = oci_parse($conn, $stmt);

            if( !oci_execute($stid) ) {
                $e = oci_error();
                echo htmlentities($e['message'], ENT_QUOTES);
                oci_close($conn);
            }
            else{  
                if( oci_fetch_row($stid)[0] == 1){
                    if (session_status() != PHP_SESSION_ACTIVE) 
                        session_start();
                    oci_close($conn);
                    $_SESSION['user'] = $user;
                    header('location:../security.php');
                }
                else{
                    session_unset();
                    session_destroy();
                    oci_close($conn);
                    echo "<script language=javascript>alert( 'Acesso negado ao sistema!' );	</script>";
                    echo "<script language=javascript>window.location.replace('../index.html');</script>";
                }
                
            }
        }
        else if($func = "bilheteria"){

        }
        oci_close($conn);
     }else{
        session_unset();
		session_destroy();
		echo "<script language=javascript>alert( 'Acesso negado ao sistema!' );	</script>";
		echo "<script language=javascript>window.location.replace('../index.html');</script>";
     }


?>