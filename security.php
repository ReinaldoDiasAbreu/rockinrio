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
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/security.css">
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
                <img class="logo" src="images/logo.png" alt="Rock In Rio">
                <div class="user">
                    <p>Segurança: <span> <?php echo $_SESSION['user']; ?> </span> </p>
                    <a href="php/exit.php" id="button"> Sair </a>
                </div>
            </header>
            <div class="main">

                <div class="busca">
                    <form action="#" method="GET">
                        <input type="text" name="cod" id="cod" placeholder="Código">
                        <input type="date" name="lineup" id="lineup" placeholder="LineUp" >
                        <input type="text" name="credencial" id="credencial"  maxlength=11 placeholder="CPF Segurança">
                        <input type="submit" class="button" value="Filtrar">
                        <a href="php/ocorrencia/cadastroocorrencia.php" id="button"> Nova </a>
                    </form>

                </div>

                <div class="resultados">
                    <table border="1px">
                        <tr style='text-align: center; font-weight: bolder; font-family: Arial'>
                            <td>Código</td>
                            <td>LineUp</td>
                            <td>Descrição</td>
                            <td>Segurança</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                        <?php
                            include ('bd/database.php');
                            
                            $conn = BD_connect();

                            $numero = isset($_GET['cod'])?$_GET['cod']:"";
                            $lineup = isset( $_GET['lineup'])? $_GET['lineup']:"";
                            $credencial = isset($_GET['credencial'])?$_GET['credencial']:""; 

                            if($conn != null){
                                $stmt = "SELECT numero, data, descricao, cpfprofissionalseg FROM OCORRENCIA";
                                if($numero != "" || $lineup != "" || $credencial != ""){
                                    $stmt = $stmt." WHERE";
                                    $prox = false;
                                    if($numero != ""){
                                        $stmt = $stmt." numero = $numero";
                                        $prox = true;
                                    }
                                    if($lineup != ""){
                                        $stmt = $prox ? $stmt." and":$stmt."";
                                        $stmt = $stmt." data = TO_DATE('".$lineup."', 'YYYY-MM-DD')";
                                        $prox = true;
                                    }
                                    if($credencial != ""){
                                        $stmt = $prox ? $stmt." and":$stmt."";
                                        $stmt = $stmt." cpfprofissionalseg = $credencial";
                                    }
                                }

                                $stmt = $stmt . " ORDER BY NUMERO";

                                //echo $stmt; // Descomente para exibir a consulta SQL.

                                $stid = oci_parse($conn, $stmt);

                                if( !oci_execute($stid) ) {
                                    $e = oci_error();
                                    echo htmlentities($e['message'], ENT_QUOTES);
                                    oci_close($conn);
                                }
                                else{
                                    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {                
                                        echo "<tr>\n";
                                        foreach ($row as $item) {
                                            echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                                        }
                                        echo "<td><form method='POST' action='php/ocorrencia/view.php'><button type='submit' name='cod' value=".$row["NUMERO"]." >Visualizar</button></form></td>";
                                        echo "<td><form method='POST' action='php/ocorrencia/update.php'><button type='submit' name='cod' value=".$row["NUMERO"]." >Atualizar</button></form></td>";
                                        if($row["CPFPROFISSIONALSEG"] == $_SESSION["user"]){
                                            echo "<td><form method='POST' action='php/ocorrencia/delete.php'><button type='submit' name='cod' value=".$row["NUMERO"]." >Excluir</button></form></td>";
                                        }else{
                                            echo "<td><button type='submit' name='cod' onclick='NotPermission()' >Excluir</button></form></td>";
                                        }
                                        echo "</tr>\n";
                                    
                                    }
 
                                    oci_close($conn);
                                }

                            }
                            else{
                                echo "<p>Erro na conexão com banco de dados!</p>";
                            }
                            
                        ?>

                    </table>
                </div>
            
            </div>

            <footer style="margin-top: 3rem; margin-bottom: 3rem; text-align: center;" > RockInRio &#169; Todos os direitos reservados.</footer>


        </div>


    </body>


</html>