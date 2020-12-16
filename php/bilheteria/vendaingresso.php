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
            
                <form method="POST" action="new.php" class="form-cadastro">

                    <fieldset id="dados">
                        <legend>Venda Ingresso</legend>

                        <?php 
                            include ('../../bd/database.php');

                            $query = "SELECT DATA FROM LINEUP";
                            $stid = BD_returnrows($query);

                            echo "<label for='data'>Data: </label>
                            <select name='data' id='data' required >
                            <optgroup id='data' label='LineUps'>";
                            echo "<option value=''></option>";
                            if($stid != null){
                                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {     
                                    echo "<option value=".$row['DATA'].">".$row['DATA']."</option>" ;
                                }
                            }
                            echo "</optgroup></select>";       
                                    
                        ?>

                        <p>Valor: <input type="number" min="0" name="valor" id="valor" required></p>
                    </fieldset>

                    <fieldset id="pessoas">
                        <legend>Espectador</legend>
                        
                            <div id="botoes">
                                <!--<a onclick="addPessoa()" class="button" id="button">Adicionar</a>-->
                                <a href="../people/new.php" target="_blank" class="button" id="button">Cadastrar Espectador</a>
                            </div>  

                        <div id="dadosespectador">
                            
                            <label for="espectador" id="lblespectador">Dados Espectador: </label>
                            <select name="espectador" id="espectador">
                                <optgroup label="Espectadores cadastrados">
                                    <option value=""></option>
                                    
                                    <?php
                                    $query = "SELECT CPF, NOME, DATANASCIMENTO FROM PESSOA WHERE CPF IN (SELECT CPF FROM ESPECTADOR) ORDER BY NOME";
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
                        <input type="submit" class="button" id="botaoenviar" value="Cadastrar">
                    </div>
                    
                </form>

            </div>

        </div>
    </body>
</html>