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
        <link rel="stylesheet" href="../../styles/bilheteria.css">
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
                    $idingresso = isset($_POST['cod'])?$_POST['cod']:-1;
                    echo "<h3>Visualizar Ingresso: ".$idingresso."</h3>";
                    include ('../../bd/database.php');
                    $ingresso = BD_returnrow("SELECT NUMERO, VALOR, CPFESPECTADOR, PERTENCEDATALINEUP FROM INGRESSO WHERE NUMERO = $idingresso");
                    $pessoa = BD_returnrow("SELECT CPF, NOME, DATANASCIMENTO, CEP, BAIRRO, NUMERO, RUA FROM PESSOA WHERE CPF = (SELECT CPFESPECTADOR FROM INGRESSO WHERE NUMERO = $idingresso)");
                    
                ?>

                <form  action="#" class="form-cadastro">

                <fieldset id="dados">
                    <legend>Dados Ingresso</legend>
                    <label for='data'>Data: </label>
                    <select name='data' id='data' readonly>"
                        <?php echo "<option value=".$ingresso["PERTENCEDATALINEUP"]." selected> ".$ingresso['PERTENCEDATALINEUP'] ."</option>"; ?>
                    </select>
                    
                    <p>Valor: <input type="number" name="valor" id="valor" value="<?php echo $ingresso["VALOR"]; ?>" readonly></p>
                </fieldset>

                <fieldset id="pessoa">
                    <legend>Espectador</legend>

                    <div id="pessoaenvolvida">
                    
                    <?php 

                        echo "<p>Nome: <input type='text' maxlength='50' name='nome' id='nome' readonly value='".$pessoa['NOME']."'></p>";
                        echo "<p>CPF: <input type='text' maxlength='11' name='cpf' id='cpf' readonly value='".$pessoa['CPF']."'></p>";
                        echo "<p>Nascimento: <input type='date' name='datanascimento' id='datanascimento' readonly value='".date('Y-m-d', strtotime($pessoa['DATANASCIMENTO']))."'></p>";
                        echo "<p>Rua: <input type='text' maxlength='20' name='rua' id='rua' readonly value='".$pessoa['RUA']."'>
                                 Numero: <input type='number' name='numero' id='numero' readonly value='".$pessoa['NUMERO']."'></p>";
                        echo "<p>Bairro: <input type='text' maxlength='30' name='bairro' id='bairro' readonly value='".$pessoa['BAIRRO']."'></p>";
                        echo "<p>Cep: <input type='text' maxlength='8' name='cep' id='cep' readonly value='".$pessoa['CEP']."'></p>";
                    ?>
                    
                    </div>
                </fieldset>
                </form>
                            
            </div>
        </div>

        <script><?php echo "n=$count-1"; ?></script>
    </body>
</html>