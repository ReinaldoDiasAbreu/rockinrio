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
            function addPessoa() {
                // Clona o nodo
                const newFieldContainer = document.querySelector("#cpfpessoa".concat(String(n))).cloneNode(true);
                const newFieldContainer2 = document.querySelector("#lblcpfpessoa".concat(String(n))).cloneNode(true);
  
                n = n + 1
                newFieldContainer.id = "cpfpessoa".concat(String(n));
                newFieldContainer2.id = "lblcpfpessoa".concat(String(n));
                newFieldContainer.name = "cpfpessoa".concat(String(n));
                newFieldContainer2.htmlFor = "cpfpessoa".concat(String(n));
                
                newFieldContainer.nodeValue = "";

                // Adiciona o clone como filho
                document.querySelector("#pessoasenvolvidas").appendChild(newFieldContainer2);
                document.querySelector("#pessoasenvolvidas").appendChild(newFieldContainer);
                
            }

            function removePeople(id){
                alert("Removendo: "+ id);
                p = id+1;
                while(document.querySelector("#cpfpessoa".concat(String(p)))){
                    const FieldContainer = document.querySelector("#cpfpessoa".concat(String(p)));
                    const FieldContainer2 = document.querySelector("#lblcpfpessoa".concat(String(p)));
                    FieldContainer.id = "cpfpessoa".concat(String(p-1));
                    FieldContainer2.id = "lblcpfpessoa".concat(String(p-1));
                    FieldContainer.name = "cpfpessoa".concat(String(p-1));
                    FieldContainer2.htmlFor = "cpfpessoa".concat(String(p-1));
                    p++;
                }

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
                <?php
                    $idocorrencia = isset($_POST['cod'])?$_POST['cod']:-1;
                    echo "<h3>Atualizar Ocorrência: ".$idocorrencia."</h3>";
                    include ('../../bd/database.php');
                    $ocorrencia = BD_returnrow("SELECT NUMERO, DATA, DESCRICAO, CPFPROFISSIONALSEG, LATITUDE, LONGITUDE FROM OCORRENCIA WHERE NUMERO = $idocorrencia");
                    $pessoas = BD_returnrows("SELECT CPF, NOME, DATANASCIMENTO FROM (SELECT CPFPESSOA FROM OCORRENCIAPESSOA WHERE NUMEROOCORENCIA =  $idocorrencia) PO, PESSOA WHERE PESSOA.CPF = PO.CPFPESSOA");
                ?>

                <form method="POST" action="update.php" class="form-cadastro">

                <fieldset id="dados">
                    <legend>Dados Gerais</legend>
                   
                    <?php 
                        echo " <p>Numero: <input type='number' name='numero' id='numero' readonly value='$idocorrencia'></p>";
                        $stid = BD_returnrows("SELECT DATA FROM LINEUP");
                        echo "<label for='data'>Data: </label>
                        <select name='data' id='data' required>
                        <optgroup id='data' label='LineUps'>";
                        echo "<option value=".$ocorrencia["DATA"]." selected> ".$ocorrencia['DATA'] ."</option>";
                        if($stid != null){
                            while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {     
                                echo "<option value=".$row['DATA'].">".$row['DATA']."</option>" ;
                            }
                        }
                        echo "</optgroup></select>";     
                    ?>

                    <p id="text-box">Descrição: <textarea id="desc" name="desc" rows="2" cols="40" maxlength="50" required><?php echo $ocorrencia["DESCRICAO"]; ?></textarea></p>
                    <p>Latitude: <input type="number" name="latitude" id="latitude" required value="<?php echo $ocorrencia["LATITUDE"]; ?>">
                    Longitude: <input type="number" name="longitude" id="longitude" required value="<?php echo $ocorrencia["LONGITUDE"]; ?>"></p>
                    <p>Segurança: <input type="number" name="seguranca" id="seguranca" value="<?php echo $ocorrencia["CPFPROFISSIONALSEG"]; ?>" required readonly></p>
                </fieldset>

                <fieldset id="pessoas">
                    <legend>Envolvidos</legend>
                    
                        <div id="botoes">
                            <a onclick="addPessoa()" class="button" id="button">Adicionar</a>
                            <a href="../people/cadastrarpessoa.php" target="_blank" class="button" id="button">Cadastrar Pessoa</a>
                        </div>  

                    <div id="pessoasenvolvidas">
                    <?php 
                        $count = 0; 
                        while ($row = oci_fetch_array($pessoas, OCI_ASSOC+OCI_RETURN_NULLS)) {     
                            echo "<label for='cpfpessoa".$count."' id='lblcpfpessoa".$count."'>CPF Pessoa: </label> <select name='cpfpessoa".$count."' id='cpfpessoa".$count."'> <optgroup id='cpf' label='Pessoas cadastradas'>";
                            $cpf = $row['CPF'];
                            $nome = $row['NOME'];
                            $nasc = $row['DATANASCIMENTO'];
                            echo "<option value='-1' style={text-aling: center;} ></option>" ;
                            echo "<option value=".$cpf." style={text-aling: center;} selected>".$nome." | ".$cpf." | ".$nasc."</option>" ;
                            $stid = BD_returnrows("SELECT CPF, NOME, DATANASCIMENTO FROM PESSOA WHERE CPF != $cpf ORDER BY NOME");
                            if($stid != null){
                                while ($all = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {     
                                    echo "<option value=".$all['CPF']." style={text-aling: center;}>".$all['NOME']." | ".$all['CPF']." | ".$all['DATANASCIMENTO']."</option>" ;
                                }
                            }
                            else{
                                echo "<p>Erro na conexão com banco de dados!</p>";
                            }
                            echo "</optgroup> </select>";
                            $count++;
                        }
                    ?>
                    </div>
                </fieldset>

                <div id="btn-enviar">
                        <input type="submit" class="button" id="botaoenviar" value="Atualizar">
                </div>
                
                </form>
                            
            </div>
        </div>

        <script><?php echo "n=$count-1"; ?></script>
    </body>
</html>