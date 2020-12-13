<?php
session_start();
if(empty($_SESSION['user'])) {
    echo "<script language=javascript>alert( 'Acesso Bloqueado!' );</script>";
    echo "<script language=javascript>window.location.replace('index.html');</script>";
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
        <link rel="stylesheet" href="../../styles/people.css">
        <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&amp;family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet">
        <script>
            n = 0;
            function addTel() {
                // Clona o nodo
                const newFieldContainer = document.querySelector("#telefone".concat(String(n))).cloneNode(true);
                const newFieldContainer2 = document.querySelector("#lbltelefone".concat(String(n))).cloneNode(true);
  
                n = n + 1
                newFieldContainer.id = "telefone".concat(String(n));
                newFieldContainer2.id = "lbltelefone".concat(String(n));
                newFieldContainer.name = "telefone".concat(String(n));
                newFieldContainer2.htmlFor = "telefone".concat(String(n));
                
                // Adiciona o clone como filho
                document.querySelector("#telefonespessoa").appendChild(newFieldContainer2);
                document.querySelector("#telefonespessoa").appendChild(newFieldContainer);
                
            }

            function selectedFunc(value){
                var func = document.getElementsByClassName('funcionario');

                if(value == "Funcionario"){
                    func[0].style.display = 'block';
                }
                else{
                    func[0].style.display = 'none';
                }

            }

            function selectedTipoFunc(value){
                var seg = document.getElementsByClassName('seguranca');
                var med = document.getElementsByClassName('medico');
                var web = document.getElementsByClassName('webmaster');

                if(value == "med"){
                    med[0].style.display = 'block';
                }
                else{
                    med[0].style.display = 'none';
                }

                if(value == "seg"){
                    seg[0].style.display = 'block';
                }
                else{
                    seg[0].style.display = 'none';
                }

                if(value == "web"){
                    web[0].style.display = 'block';
                }
                else{
                    web[0].style.display = 'none';
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
                
                <form method="POST" action="new.php" class="form-cadastro">

                    <fieldset id="dados">
                        <legend>Dados Pessoais</legend>

                        <p>CPF: <input type="text" maxlength="11" name="cpf" id="cpf" required></p>
                        <p>Nome: <input type="text" maxlength="50" name="nome" id="nome" max="50" required></p>
                        <p>Nascimento: <input type="date" name="datanascimento" id="datanascimento" required></p>

                        <label for="tipopessoa">Tipo Pessoa: </label>
                        <select name="tipopessoa" id="tipopessoa" required onclick="selectedFunc(this.value)">
                            <optgroup>
                                <option value="Espectador" selected>Espectador</option>
                                <option value="Integrante">Integrante</option>
                                <option value="Funcionario">Funcionário</option>
                            </optgroup>
                        </select>
                        
                    </fieldset>

                    <fieldset>
                        <legend>Endereço</legend>
                        <p>Rua: <input type="text" maxlength="20" name="rua" id="rua" required></p>
                        <p>Bairro: <input type="text" maxlength="30" name="bairro" id="bairro" required></p>
                        <p>Numero: <input type="number" min="0" name="numero" id="numero" required></p>
                        <p>CEP: <input type="number" min="0" name="cep" id="cep" placeholder="Somente números" required></p>
                    </fieldset>

                    <fieldset id="telefones">
                        <legend>Telefones</legend>
                        
                        <div id="botoes">
                            <a onclick="addTel()" class="button" id="button">Adicionar Outro</a>
                        </div>  

                        <div id="telefonespessoa">
                            <label for="telefone0" id="lbltelefone0">Telefone: </label> 
                            <input type="text" name="telefone0" id="telefone0" maxlength="11" placeholder="Somente números">                       
                        </div>

                    </fieldset>

                    <fieldset class="funcionario" style="display: none;">
                        <legend>Funcionário</legend>
                        <p>Registro: <input type="number" name="registro" id="registro"></p>
                        <label for="tipofuncionario">Tipo Pessoa: </label>
                        <select name="tipofuncionario" id="tipofuncionario" onclick="selectedTipoFunc(this.value)">
                            <optgroup>
                                <option value="" selected></option>
                                <option value="med">Médico</option>
                                <option value="seg">Segurança</option>
                                <option value="web">Webmaster</option>
                            </optgroup>
                        </select>
                        <p>Cargo: <input type="text" name="cargo" id="cargo" maxlength="10"></p>
                    </fieldset>

                    <fieldset class="seguranca" style="display: none;">
                        <legend>Segurança</legend>
                        <p>Credencial: <input type="number" name="credencial" id="credencial"></p>
                        <p>Localização: <input type="text" name="localizacao" id="localizacao" maxlength="50"></p>
                        <?php 
                            include ('../../bd/database.php');

                            $query = "SELECT CNPJSERVICO, NOME FROM SEGURANCA";
                            $stid = BD_returnrows($query);

                            echo "<label for='data'>Empresa: </label>
                            <select name='empresaseg' id='empresaseg' >
                            <optgroup id='empresaseg'>";
                            echo "<option value=''></option>";
                            if($stid != null){
                                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {     
                                    echo "<option value=".$row['CNPJSERVICO'].">".$row['CNPJSERVICO']." - ".$row['NOME']."</option>" ;
                                }
                            }
                            echo "</optgroup></select>";  
                        
                        ?> 
                    </fieldset>

                    <fieldset class="medico" style="display: none;">
                        <legend>Médico</legend>
                        <p>CRM: <input type="number" name="crm" id="crm"></p>
                        <?php 
                            $query = "SELECT CNPJSERVICO, NOME FROM AMBULATORIO";
                            $stid = BD_returnrows($query);

                            echo "<label for='data'>Ambulatório: </label>
                            <select name='ambulatorio' id='ambulatorio' >
                            <optgroup id='ambulatorio'>";
                            echo "<option value=''></option>";
                            if($stid != null){
                                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {     
                                    echo "<option value=".$row['CNPJSERVICO'].">".$row['CNPJSERVICO']." - ".$row['NOME']."</option>" ;
                                }
                            }
                            echo "</optgroup></select>";  
                        
                        ?> 
                    </fieldset>

                    <fieldset class="webmaster" style="display: none;">
                        <legend>Websmaster</legend>
                        <p>Email: <input type="mail" name="emailweb" id="emailweb"></p>
                    </fieldset>

                    <div id="btn-enviar">
                        <input type="submit" class="button" id="botaoenviar" value="Cadastrar">
                    </div>

                    </form>
                
            </div>

            <footer style="margin-top: 3rem; margin-bottom: 3rem; text-align: center;" > RockInRio &#169; Todos os direitos reservados.</footer>


        </div>


    </body>


</html>