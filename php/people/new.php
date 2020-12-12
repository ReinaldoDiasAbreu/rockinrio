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
        <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&amp;family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet">
        <script>
            function NotPermission(){
               alert( 'Você não pode excluir ocorrências dos demais seguranças!');
            }
        </script>
    </head>
    <body id="painel">
        <div id="container">
            
            <header>
                <img class="logo" src="../../images/logo.png" alt="Rock In Rio">
                <div class="user">
                    <p>Segurança: <span> <?php echo $_SESSION['user']; ?> </span> </p>
                    <a href="../php/exit.php" id="button"> Sair </a>
                </div>
            </header>

            <div class="main">
            <form method="POST" action="#" class="form-cadastro">

                <fieldset id="dados">
                    <legend>Dados Pessoais</legend>

                    <p>CPF: <input type="text" maxlength="11"></p>
                    
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