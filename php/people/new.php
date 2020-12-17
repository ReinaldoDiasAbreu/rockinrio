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

                    // Tipo Pessoa (Funcionario/Espectador/Integrante)
                    $tipopessoa = (isset($_POST["tipopessoa"])?($_POST["tipopessoa"]) : "");
                    
                    $rua = (isset($_POST["rua"])?($_POST["rua"]) : "");
                    $bairro = (isset($_POST["bairro"])?($_POST["bairro"]) : "");
                    $numero = (isset($_POST["numero"])?($_POST["numero"]) : "");
                    $cep = (isset($_POST["cep"])?($_POST["cep"]) : "");

                    // Caso pessoa = Funcionario
                    $tipofuncionario =  (isset($_POST["tipofuncionario"])?($_POST["tipofuncionario"]) : "");
                    $cargo = (isset($_POST["cargo"])?($_POST["cargo"]) : "");

                    // Se Funcionario Segurança
                    $localizacao = (isset($_POST["localizacao"])?($_POST["localizacao"]) : "");
                    $empresaseg = (isset($_POST["empresaseg"])?($_POST["empresaseg"]) : "");

                    // Se Funcionario Medico
                    $crm = (isset($_POST["crm"])?($_POST["crm"]) : "");
                    $ambulatorio = (isset($_POST["ambulatorio"])?($_POST["ambulatorio"]) : "");

                    // Se for webmaster
                    $emailweb = (isset($_POST["emailweb"])?($_POST["emailweb"]) : "");
                    
                    // Checa se funcionario está cadastrado
                    $stdid = BD_returnrow("SELECT COUNT(CPF) as QUANT FROM PESSOA WHERE CPF = $cpf");
                    $q_people = ($stdid["QUANT"]);

                    if($cpf != "" && $q_people == 0){

                        $stid = BD_execute("INSERT INTO PESSOA VALUES ( '$cpf', '$tipopessoa',  TO_DATE('$datanascimento', 'YYYY-MM-DD'), '$nome', '$cep', '$bairro', $numero, '$rua')");
                    
                        if($stid != null){
                            // Insere os Telefones da Pessoa
                            $n = 0;
                            $pinsert = 0;
                            while(isset($_POST["telefone".(string) $n])?($_POST["telefone".(string) $n]):""!=""){
                                $telefone = $_POST["telefone".(string) $n];

                                $stid2 = BD_execute("INSERT INTO TELEFONEPESSOA VALUES ('$cpf', '$telefone')");
                                if($stid2 != null){
                                    $pinsert++;
                                }
                                $n++;
                            }

                    
                            echo "<p>Sucesso ao cadastrar pessoa ;)</p><br>";
                            echo "<h4>Dados Pessoais</h4>";
                            echo "<p>CPF: $cpf</p>";
                            echo "<p>Nome: $nome</p>";
                            echo "<p>Data Nascimento: $datanascimento</p>";
                            echo "<p>Tipo: $tipopessoa</p>";
                            echo "<p>Quant. telefones: $pinsert</p><br>";
                            
                            
                            switch($tipopessoa){
                                case "Funcionario":
                                    $stdid = BD_returnrow("SELECT NUMEROREGISTRO FROM (SELECT * FROM FUNCIONARIO ORDER BY NUMEROREGISTRO DESC)  WHERE ROWNUM = 1");
                                    $registro = ($stdid["NUMEROREGISTRO"] + 1);
                                    $cargo = "";
                                    switch($tipofuncionario){
                                        case "med":
                                            $cargo = "medico"; 
                                        break;
                                        case "seg":
                                            $cargo = "seguranca"; 
                                        break;
                                        case "web":
                                            $cargo = "webmaster"; 
                                        break;
                                    }

                                    $stid2 = BD_execute("INSERT INTO FUNCIONARIO VALUES ('$cpf', $registro, '$tipofuncionario', '$cargo')");
                                    if($stid2 == null){
                                        echo "<script language=javascript>alert( 'Erro ao cadastrar funcionário!' );</script>";
                                    }
                                    else{
                                        echo "<h4>Dados Funcionário</h4>";
                                        echo "<p>Registro: $registro</p>";
                                        echo "<p>Tipo Funcionário: $tipofuncionario</p>";
                                        echo "<p>Cargo: $cargo</p>";
                                    }
                                    switch($tipofuncionario){
                                        case "med":
                                            $stid2 = BD_execute("INSERT INTO MEDICO VALUES ($cpf, $crm, $ambulatorio)");
                                            if($stid2 == null){
                                                echo "<script language=javascript>alert( 'Erro ao cadastrar Médico!' );</script>";
                                            }else{
                                                echo "<p>CRM: $crm</p>";
                                                echo "<p>CNPJ Ambulatório: $ambulatorio</p>";
                                            }
                                            break;
                                        case "seg":
                                            $stdid = BD_returnrow("SELECT NROCREDENCIAL FROM (SELECT * FROM PROFISSIONALSEG ORDER BY NROCREDENCIAL DESC)  WHERE ROWNUM = 1");
                                            $credencial = ($stdid["NROCREDENCIAL"] + 1);
        
                                            $stid2 = BD_execute("INSERT INTO PROFISSIONALSEG VALUES ('$cpf', $credencial, '$localizacao', $empresaseg)");
                                            if($stid2 == null){
                                                echo "<script language=javascript>alert( 'Erro ao cadastrar Segurança!' );</script>";
                                            }else{
                                                echo "<p>Credencial: $credencial</p>";
                                                echo "<p>Localização: $localizacao</p>";
                                                echo "<p>Empresa Segurança: $empresaseg</p>";
                                            }
                                            break;
                                        case "web":
                                            $stid2 = BD_execute("INSERT INTO WEBMASTER VALUES ('$cpf', '$emailweb')");
                                            if($stid2 == null){
                                                echo "<script language=javascript>alert( 'Erro ao cadastrar Webmaster!' );</script>";
                                            }else{
                                                echo "<p>Email Webmaster: $emailweb</p>";
                                            }
                                        break;
                                    }
                                break;
                                case "Espectador":
                                    $stdid = BD_returnrow("SELECT CODIGO FROM (SELECT * FROM ESPECTADOR ORDER BY CODIGO DESC)  WHERE ROWNUM = 1");
                                    $codigo = ($stdid["CODIGO"] + 1);
                                    $queryp = "INSERT INTO ESPECTADOR VALUES ('$cpf', '$codigo')";
                                    $stid2 = BD_execute($queryp);

                                    if($stid2 == null || $stdid == null){
                                        echo "<script language=javascript>alert( 'Erro ao cadastrar espectador!' );</script>";
                                    }
                                    else{
                                        echo "<h4>Dados Espectador</h4>";
                                        echo "<p>Código: $codigo</p>";
                                    }
                                break;

                                case "Integrante":
                                    $queryp = "INSERT INTO INTEGRANTE VALUES ('$cpf')";
                                    $stid2 = BD_execute($queryp);
                                    if($stid2 == null){
                                        echo "<script language=javascript>alert( 'Erro ao cadastrar integrante!' );</script>";
                                    }
                                    else{
                                        echo "<p>Este funcionário é um integrante de banda.</p>";
                                    }
                                break;
                            }
                            
                        }
                        else{
                           echo "<p>Erro ao cadastrar pessoa.</p>";
                        } 
                        
                    }
                    else{
                        echo "<p>Valor de CPF inválido ou pessoa já cadastrada.</p>";
                    } 
                    
                ?>

            </div>
        </div>
    </body>
</html>