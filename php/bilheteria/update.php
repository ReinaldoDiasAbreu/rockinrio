<?php
session_start();
if(empty($_SESSION['user'])) {
    echo "<script language=javascript>alert( 'Acesso Bloqueado!' );</script>";
    echo "<script language=javascript>window.location.replace('../../index.html');</script>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rock in Rio</title>
        <meta name="theme-color" content="#8257E5">
        <link rel="stylesheet" href="../../styles/main.css">
        <link rel="stylesheet" href="../../styles/security.css">
        <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&amp;family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet">

    </head>
    <body id="painel">
        <div id="container">
            
            <header>
                <img class="logo" src="../../images/logo.png" alt="Rock In Rio">
                <div class="user">
                    <p>Funcionário: <span> <?php echo $_SESSION['user']; ?> </span> </p>
                    <a href="../exit.php" id="button"> Sair </a>
                </div>
            </header>
            <div id="navegacao"><a href="../../bilheteria.php">< Voltar</a></div>
            <div class="main">
                
            <?php
                    include ('../../bd/database.php');
                    $numero =  (isset($_POST["numero"])?($_POST["numero"]) : "-1");
                    $data = (isset($_POST["data"])?($_POST["data"]) : "");
                    $valor = (isset($_POST["valor"])?($_POST["valor"]) : "");
                    $espectador = (isset($_POST["espectador"])?($_POST["espectador"]) : "");

                    if($numero != "-1" && $espectador != "" && $data != ""){

                        $query = "UPDATE INGRESSO SET VALOR = $valor, CPFESPECTADOR = $espectador, PERTENCEDATALINEUP = TO_DATE('$data') WHERE NUMERO = $numero";

                        $stid = BD_execute($query);
                    
                        if($stid != null){

                            echo "<p>Sucesso ao atualizar ingresso ;)</p><br>";
                            echo "<p>Número: $numero</p>";
                            echo "<p>Valor: $valor</p>";
                            echo "<p>CPF Espectador: $espectador</p>";

                        }
                        else{
                            echo "<p>Erro ao atualizar ingresso.</p>";
                        }
                    }
                ?>

            </div>
        </div>

        <script><?php echo "n=$count-1"; ?></script>
    </body>
</html>