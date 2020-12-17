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
                    echo "<h3>Atualizar Ingresso: ".$idingresso."</h3>";
                    include ('../../bd/database.php');
                    $ingresso = BD_returnrow("SELECT NUMERO, VALOR, CPFESPECTADOR, PERTENCEDATALINEUP FROM INGRESSO WHERE NUMERO = $idingresso");
                    $pessoa = BD_returnrow("SELECT CPF, NOME, DATANASCIMENTO, CEP, BAIRRO, NUMERO, RUA FROM PESSOA WHERE CPF = (SELECT CPFESPECTADOR FROM INGRESSO WHERE NUMERO = $idingresso)");
                ?>

                <form method="POST" action="update.php" class="form-cadastro">

                <fieldset id="dados">
                    <legend>Dados Ingresso</legend>
                   
                    <?php 
                        echo " <p>Numero: <input type='number' name='numero' id='numero' readonly value=$idingresso></p>";
                        $stid = BD_returnrows("SELECT DATA FROM LINEUP");
                        
                        echo "<label for='data'>Data: </label>
                        <select name='data' id='data' required>
                        <optgroup id='data' label='LineUps'>";
                        echo "<option value=".$ingresso['PERTENCEDATALINEUP']." selected> ".$ingresso['PERTENCEDATALINEUP'] ."</option>";
                        if($stid != null){
                            while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {     
                                echo "<option value=".$row['DATA'].">".$row['DATA']."</option>" ;
                            }
                        }
                        echo "</optgroup></select>";     
                    ?>
    
                    <p>Valor: <input type="number" name="valor" id="valor" required value="<?php echo $ingresso["VALOR"]; ?>"></p>                
                </fieldset>

                <fieldset id="pessoas">
                    <legend>Espectador</legend>
                    
                    <div id="dadosespectador">
                            
                            <label for="espectador" id="lblespectador">Espectador: </label>
                            <select name="espectador" id="espectador">
                                <optgroup label="Espectadores cadastrados">

                                    <?php
                                    echo "<option value=".$pessoa['CPF']." style={text-aling: center;} selected>".$pessoa['NOME']." | ".$pessoa['CPF']." | ".$pessoa['DATANASCIMENTO']."</option>";

                                    $query = "SELECT CPF, NOME, DATANASCIMENTO FROM PESSOA WHERE CPF IN (SELECT CPFPESSOA FROM ESPECTADOR) ORDER BY NOME";
                                    $stid = BD_returnrows($query);
                                    
                                    if($stid != null){
                                        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {     
                                            echo "<option value=".$row['CPF']." style={text-aling: center;}>".$row['NOME']." | ".$row['CPF']." | ".$row['DATANASCIMENTO']."</option>" ;
                                        }
                                    }
                                    else{
                                        echo "<p>Erro na conexão com banco de dados!</p>";
                                    }
                                        
                                    ?>

                                </optgroup>
                                
                            </select>
                        </div>
                </fieldset>

                <div id="btn-enviar">
                        <input type="submit" class="button" id="botaoenviar" value="Atualizar">
                </div>
                
                </form>
                            
            </div>
        </div>
    </body>
</html>