<?php 
     include ('../bd/database.php');
     $func = isset($_POST["funcionario"])?$_POST["funcionario"]:"";
     $user = isset($_POST["user"])?$_POST["user"]:"";

     if($func != "" && $user != ""){
        
        if($func = "seguranca"){
            $query = "SELECT COUNT(*) QUANT FROM FUNCIONARIO WHERE CPFPESSOA = $user AND TIPOFUNCIONARIO = 'seg'";
            $result = BD_returnrow($query);

            if( $result ) {
               if($result["QUANT"] == 1){
                    if (session_status() != PHP_SESSION_ACTIVE) 
                        session_start();
                    $_SESSION['user'] = $user;
                    header('location:../security.php');
               }
            }
            else{  
                session_unset();
                session_destroy();
                oci_close($conn);
                echo "<script language=javascript>alert( 'Acesso negado ao sistema!' );	</script>";
                echo "<script language=javascript>window.location.replace('../index.html');</script>";  
            }
        }
        else if($func = "bilheteria"){

        }
     }else{
        session_unset();
		session_destroy();
		echo "<script language=javascript>alert( 'Acesso negado ao sistema!' );	</script>";
		echo "<script language=javascript>window.location.replace('../index.html');</script>";
     }


?>