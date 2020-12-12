<?php 

    function erro_login(){
        session_unset();
        session_destroy();
        echo "<script language=javascript>alert( 'Acesso negado ao sistema!' );	</script>";
        echo "<script language=javascript>window.location.replace('../index.html');</script>";  
    }

     include ('../bd/database.php');
     $func = isset($_POST["funcionario"])?$_POST["funcionario"]:"";
     $user = isset($_POST["user"])?$_POST["user"]:"";
     
     if($func != "" && $user != ""){
        if($func == "seguranca"){
            $query = "SELECT COUNT(*) QUANT FROM FUNCIONARIO WHERE CPFPESSOA = $user AND TIPOFUNCIONARIO = 'seg'";
            $result = BD_returnrow($query);

            if( $result ) {
               if($result["QUANT"] == 1){
                    if (session_status() != PHP_SESSION_ACTIVE) 
                        session_start();
                    $_SESSION['user'] = $user;
                    header('location:../security.php');
               }
               else{  
                erro_login();  
                }
            }
            else{ 
                erro_login();  
            }
        }
        else if($func == "bilheteria"){
            $query = "SELECT COUNT(*) QUANT FROM FUNCIONARIO WHERE CPFPESSOA = $user";
            $result = BD_returnrow($query);

            if( $result ) {
               if($result["QUANT"] == 1){
                    if (session_status() != PHP_SESSION_ACTIVE) 
                        session_start();
                    $_SESSION['user'] = $user;
                    header('location: ../bilheteria.php');
               }
               else{  
                erro_login();  
                }
            }
            else{  
                erro_login();  
            }
        }
     }
     else{
        session_unset();
		session_destroy();
		echo "<script language=javascript>alert( 'Acesso negado ao sistema!' );	</script>";
		echo "<script language=javascript>window.location.replace('../index.html');</script>";
     }


?>