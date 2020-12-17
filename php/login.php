<?php 

    function erro_login(){
        session_start();
        unset( $_SESSION['user'] );
        session_destroy();
        echo "<script language=javascript>alert( 'Acesso negado ao sistema!' );	</script>";
        echo "<script language=javascript>window.location.replace('../index.html');</script>";  
    }

     include ('../bd/database.php');
     $func = isset($_POST["funcionario"])?$_POST["funcionario"]:"";
     $user = isset($_POST["user"])?$_POST["user"]:"";
     
     if($func != "" && $user != ""){

         switch($func){
            case "seguranca":
                $query = "SELECT COUNT(*) QUANT FROM FUNCIONARIO WHERE CPFPESSOA = $user AND TIPOFUNCIONARIO = 'seg'";
                $result = BD_returnrow($query);

                if( $result != null ) {
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
            break;
            case "bilheteria":
                $query = "SELECT COUNT(*) QUANT FROM FUNCIONARIO WHERE CPFPESSOA = $user";
                $result = BD_returnrow($query);
    
                if( $result != null) {
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
            break;
            case "relatorio":
                $query = "SELECT COUNT(*) QUANT FROM FUNCIONARIO WHERE CPFPESSOA = $user";
                $result = BD_returnrow($query);
    
                if( $result != null) {
                   if($result["QUANT"] == 1){
                        if (session_status() != PHP_SESSION_ACTIVE) 
                            session_start();
                            $_SESSION['user'] = $user;
                            header('location: ../php/relatorio.php');
                   }
                   else{  
                    erro_login();  
                    }
                }
                else{  
                    erro_login();  
                }
            break;
         }
        
     }
     else{
        echo "<script language=javascript>alert( 'Erro loguin!' );</script>";
        echo "<script language=javascript>window.location.replace('../index.html');</script>";
     }


?>