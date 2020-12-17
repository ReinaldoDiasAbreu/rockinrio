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
                    $idocorrencia = isset($_POST['cod'])?$_POST['cod']:-1;
                    echo "<h3>Visualizar Ocorrência: ".$idocorrencia."</h3>";
                    include ('../../bd/database.php');
                    $ocorrencia = BD_returnrow("SELECT NUMERO, DATA, DESCRICAO, CPFPROFISSIONALSEG, LATITUDE, LONGITUDE FROM OCORRENCIA WHERE NUMERO = $idocorrencia");
                    $pessoas = BD_returnrows("SELECT CPF, NOME, DATANASCIMENTO, TIPOPESSOA, RUA, NUMERO, BAIRRO, CEP FROM PESSOA WHERE PESSOA.CPF in (SELECT CPFPESSOA FROM OCORRENCIAPESSOA WHERE NUMEROOCORENCIA =  $idocorrencia)");
                   
                ?>

                <form  action="#" class="form-cadastro">

                <fieldset id="dados">
                    <legend>Dados Gerais</legend>
                    <label for='data'>Data: </label> <select name='data' id='data' readonly>"
                    <?php echo "<option value=".$ocorrencia["DATA"]." selected> ".$ocorrencia['DATA'] ."</option>"; ?>
                   </select>

                    <p id="text-box">Descrição: <textarea id="desc" name="desc" rows="2" cols="40" maxlength="50" readonly><?php echo $ocorrencia["DESCRICAO"]; ?></textarea></p>
                    <p>Latitude: <input type="number" name="latitude" id="latitude" value="<?php echo $ocorrencia["LATITUDE"]; ?>" readonly>
                    Longitude: <input type="number" name="longitude" id="longitude" value="<?php echo $ocorrencia["LONGITUDE"]; ?>" readonly></p>
                    <p>Segurança: <input type="number" name="seguranca" id="seguranca" value="<?php echo $ocorrencia["CPFPROFISSIONALSEG"]; ?>"  readonly></p>
                </fieldset>

                <fieldset id="pessoas">
                    <legend>Envolvidos</legend>

                    <div id="pessoasenvolvidas">
                    
                    <?php 
                        $count = 1; 
                        while ($row = oci_fetch_array($pessoas, OCI_ASSOC+OCI_RETURN_NULLS)) {  
                            $cpf = $row['CPF'];
                            $nome = $row['NOME'];
                            $nasc = $row['DATANASCIMENTO'];
                            $tipo = $row['TIPOPESSOA'];
                            $rua = $row['RUA'];
                            $numero = $row['NUMERO'];
                            $bairro = $row['BAIRRO'];
                            $cep = $row['CEP']; 
                            echo "<fieldset> <legend>Pessoa ".$count.":</legend>";
                            echo "<p>CPF: <input type='text' maxlength='11' name='cpf' id='cpf' readonly value='".($cpf)."'></p>";
                            echo "<p>Nome: <input type='text' maxlength='50' name='nome' id='nome' readonly value='".($nome)."'></p>";
                            echo "<p>Nascimento: <input type='date' name='datanascimento' id='datanascimento' readonly value='".date('Y-m-d', strtotime($nasc))."'></p>";
                            echo "<p>Tipo: <input type='text' maxlength='21' name='tipo' id='tipo' readonly value='".($tipo)."'></p>";
                            echo "<p>Rua: <input type='text' maxlength='21' name='rua' id='rua' readonly value='".($rua)."'></p>";
                            echo "<p>Numero: <input type='number' name='num' id='num' readonly value='".($numero)."'></p>";
                            echo "<p>Bairro: <input type='text' maxlength='31' name='bairro' id='bairro' readonly value='".($bairro)."'></p>";
                            echo "<p>CEP: <input type='text' maxlength='9' name='cep' id='cep' readonly value='".($cep)."'></p>";
                            echo "</fieldset>";
                            $count++;
                        }
                    ?>
                    
                    </div>
                </fieldset>
                </form>
                            
            </div>
        </div>

        <script><?php echo "n=$count-1"; ?></script>
    </body>
</html>