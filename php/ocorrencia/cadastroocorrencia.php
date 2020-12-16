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
        <script>
            n = 0;
            function addPessoa() {
                // Clona o nodo
                const newFieldContainer = document.querySelector("#cpfpessoa".concat(String(n))).cloneNode(true);
                const newFieldContainer2 = document.querySelector("#lblcpfpessoa".concat(String(n))).cloneNode(true);
  
                n = n + 1
                newFieldContainer.id = "cpfpessoa".concat(String(n));
                newFieldContainer2.id = "lblcpfpessoa".concat(String(n));
                newFieldContainer.name = "cpfpessoa".concat(String(n));
                newFieldContainer2.htmlFor = "cpfpessoa".concat(String(n));
                
                // Adiciona o clone como filho
                document.querySelector("#pessoasenvolvidas").appendChild(newFieldContainer2);
                document.querySelector("#pessoasenvolvidas").appendChild(newFieldContainer);
                
            }
        </script>

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
                <h3>Cadastrar Ocorrência</h3>
                <form method="POST" action="new.php" class="form-cadastro">

                    <fieldset id="dados">
                        <legend>Dados Gerais</legend>

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

                        <p id="text-box">Descrição: <textarea id="desc" name="desc" rows="2" cols="40" maxlength="50" required></textarea></p>
                        <p>Latitude: <input type="number" name="latitude" id="latitude" required>
                        Longitude: <input type="number" name="longitude" id="longitude" required></p>
                        <p>Segurança: <input type="number" name="seguranca" id="seguranca" value="<?php echo $_SESSION['user'];  ?>" required readonly></p>
                    </fieldset>

                    <fieldset id="pessoas">
                        <legend>Envolvidos</legend>
                        
                            <div id="botoes">
                                <a onclick="addPessoa()" class="button" id="button">Adicionar</a>
                                <a href="../people/cadastrarpessoa.php" target="_blank" class="button" id="button">Cadastrar Pessoa</a>
                            </div>  

                        <div id="pessoasenvolvidas">
                            
                            <label for="cpfpessoa0" id="lblcpfpessoa0">CPF Pessoa: </label>
                            <select name="cpfpessoa0" id="cpfpessoa0">
                                <optgroup id="cpf" label="Pessoas cadastradas">
                                    <option value=""></option>
                                    
                                    <?php
                                    $query = "SELECT CPF, NOME, DATANASCIMENTO FROM PESSOA ORDER BY NOME";
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