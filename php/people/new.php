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

                    $cpf = (isset($_POST["cpf"])?($_POST["cpf"]) : "");
                    $nome = (isset($_POST["nome"])?($_POST["nome"]) : "");
                    $datanascimento = (isset($_POST["datanascimento"])?($_POST["datanascimento"]) : "");
                    $tipopessoa = (isset($_POST["tipopessoa"])?($_POST["tipopessoa"]) : "");
                    $rua = (isset($_POST["rua"])?($_POST["rua"]) : "");
                    $bairro = (isset($_POST["bairro"])?($_POST["bairro"]) : "");
                    $numero = (isset($_POST["numero"])?($_POST["numero"]) : "");
                    $cep = (isset($_POST["cep"])?($_POST["cep"]) : "");

                    if($cpf != ""){

                        $query = "INSERT INTO PESSOA VALUES ( '$cpf', '$tipopessoa',  TO_DATE('$datanascimento', 'YYYY-MM-DD'), '$nome', '$cep', '$bairro', $numero, '$rua')";
                        
                        $stid = BD_insert($query);
                    
                        if($stid != null){
                            $n = 0;
                            $pinsert = 0;
                            while(isset($_POST["telefone".(string) $n])?($_POST["telefone".(string) $n]):""!=""){
                                $telefone = $_POST["telefone".(string) $n];
                                
                                $queryp = "INSERT INTO TELEFONEPESSOA VALUES ('$cpf', '$telefone')";
                                echo $queryp;
                                $stid2 = BD_insert($queryp);
                                if($stid2 != null){
                                    $pinsert++;
                                }
                                $n++;
                            }

                            if($pinsert == $n){
                                echo "<p>Sucesso ao cadastrar pessoa ;)</p><br>";
                                echo "<p>CPF: $cpf</p>";
                                echo "<p>Nome: $nome</p>";
                                echo "<p>Data Nascimento: $datanascimento</p>";
                                echo "<p>Tipo: $tipopessoa</p>";
                                echo "<p>Quant. telefones: $pinsert</p>";
                            }

                        }
                        else{
                           echo "<p>Erro ao cadastrar pessoa.</p>";
                        } 

                    }

                ?>

            </div>
        </div>
    </body>
</html>