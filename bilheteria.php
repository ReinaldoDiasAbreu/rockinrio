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
        <link rel="stylesheet" href="styles/bilheteria.css">
        <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&amp;family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet">

    </head>
    <body id="painel">
        <div id="container">
            
            <header>
                <img class="logo" src="images/logo.png" alt="Rock In Rio">
                <div class="user">
                    <p>Funcionário: <span> <?php echo $_SESSION['user']; ?> </span> </p>
                    <a href="php/exit.php" id="button"> Sair </a>
                </div>
            </header>
            <div class="main">

                <div class="busca">
                    <form action="#" method="GET">
                        <input type="text" name="cod" id="cod" maxlength=11 placeholder="Número">
                        <!--<input type="date" name="lineup" id="lineup" placeholder="LineUp">-->
                        
                            <?php 
                                include ('bd/database.php');

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
                        
                        <input type="text" name="cpfespectador" id="cpfespectador"  maxlength=11 placeholder="CPF Espectador">
                        <input type="submit" class="button" value="Filtrar">
                        <a href="php/bilheteria/vendaingresso.php" id="button"> Vender Ingresso </a>
                    </form>

                </div>

                <div class="resultados">
                    <table border="1px">
                        <tr style='text-align: center; font-weight: bolder; font-family: Arial'>
                            <td>Número</td>
                            <td>Valor</td>
                            <td>Espectador</td>
                            <td>Lineup</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                        <?php
                            /*include ('bd/database.php');*/
                            
                            $conn = BD_connect();

                            $numero = isset($_GET['cod'])?$_GET['cod']:"";
                            $lineup = isset( $_GET['data'])? $_GET['data']:"";
                            $cpfespectador = isset($_GET['cpfespectador'])?$_GET['cpfespectador']:""; 

                            if($conn != null){
                                $stmt = "SELECT numero, valor, cpfespectador, pertencedatalineup FROM INGRESSO";
                                if($numero != "" || $lineup != "" || $cpfespectador != ""){
                                    $stmt = $stmt." WHERE";
                                    $prox = false;
                                    if($numero != ""){
                                        $stmt = $stmt." numero = $numero";
                                        $prox = true;
                                    }
                                    if($lineup != ""){
                                        $stmt = $prox ? $stmt." and":$stmt."";
                                        $stmt = $stmt." pertencedatalineup = TO_DATE('".$lineup."')";
                                        $prox = true;
                                    }
                                    if($cpfespectador != ""){
                                        $stmt = $prox ? $stmt." and":$stmt."";
                                        $stmt = $stmt." cpfespectador = $cpfespectador";
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
                                        echo "<td><form method='POST' action='php/bilheteria/view.php'><button type='submit' name='cod' value=".$row["NUMERO"]." >Visualizar</button></form></td>";
                                        echo "<td><form method='POST' action='php/bilheteria/atualizaringresso.php'><button type='submit' name='cod' value=".$row["NUMERO"]." >Atualizar</button></form></td>";
                                        echo "<td><form method='POST' action='php/bilheteria/delete.php'><button type='submit' name='cod' value=".$row["NUMERO"]." >Excluir</button></form></td>";

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