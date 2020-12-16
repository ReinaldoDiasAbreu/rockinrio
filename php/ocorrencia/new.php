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
                    <p>Segurança: <span> <?php echo $_SESSION['user']; ?> </span> </p>
                    <a href="../exit.php" id="button"> Sair </a>
                </div>
            </header>

            <div id="navegacao"><a href="../../security.php">< Voltar</a></div>

            <div class="main">

                <?php
                    include ('../../bd/database.php');

                    $query = "SELECT MAX(NUMERO) AS QUANT FROM OCORRENCIA";
                    $result = BD_returnrow($query);
                    
                    $numero = ($result["QUANT"]+1);
                    $data = (isset($_POST["data"])?($_POST["data"]) : "");
                    $descricao = (isset($_POST["desc"])?($_POST["desc"]) : "");
                    $latitude = (isset($_POST["latitude"])?($_POST["latitude"]) : "");
                    $longitude = (isset($_POST["longitude"])?($_POST["longitude"]) : "");
                    $seguranca = (isset($_POST["seguranca"])?($_POST["seguranca"]) : "");

                    if($numero != "" && $seguranca != "" && $data != ""){

                        $query = "INSERT INTO OCORRENCIA VALUES ( $numero, TO_DATE('$data', 'DD-MM-YYYY'), '$descricao', $seguranca, $latitude, $longitude)";

                        $stid = BD_execute($query);
                    
                        if($stid != null){
                            $n = 0;
                            $pinsert = 0;
                            while(isset($_POST["cpfpessoa".(string) $n])?($_POST["cpfpessoa".(string) $n]):""!=""){
                                $cpf = $_POST["cpfpessoa".(string) $n];
                                
                                $queryp = "INSERT INTO ocorrenciapessoa VALUES ($cpf, $numero)";

                                $stid2 = BD_execute($queryp);
                                if($stid2 != null){
                                    $pinsert++;
                                }

                                $n++;
                            }

                            if($pinsert == $n){
                                echo "<p>Sucesso ao cadastrar ocorrência ;)</p><br>";
                                echo "<p>Ocorrência Número: $numero</p>";
                                echo "<p>Envolvidos: $pinsert cadastrados.</p>";
                                echo "<p>Descrição: $descricao</p>";
                                echo "<p>Localização: $latitude ° lat - $longitude ° long</p>";
                                echo "<p>Segurança CPF: $seguranca</p>";
                                
                            }

                        }
                        else{
                            echo "<p>Erro ao cadastrar ocorrência.</p>";
                        } 

                    }

                ?>

            </div>
        </div>
    </body>
</html>