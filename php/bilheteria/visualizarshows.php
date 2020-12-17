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
        <link rel="stylesheet" href="../../styles/relatorio.css">
        <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&amp;family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet">

    </head>
    <body id="painel">
        <div id="container">
            
            <header>
                <img class="logo" src="../../images/logo.png" alt="Rock In Rio">
            </header>

            <div class="main">
                    <h3>Shows Line Up</h3>

                        <?php 

                        $data =  isset($_GET['data'])?$_GET['data']:"";
            
                        if($data != "" && $data != null){

                            include ('../../bd/database.php');

                            echo "<table border='1px' id='relatorio'>
                            <tr style='text-align: center; font-weight: bolder; font-family: Arial'>
                                <td>LINE UP</td>
                                <td>LOCAL</td>
                                <td>NOME BANDA</td>
                                <td>SITE</td>
                            </tr>";

                            $cons = "SELECT S.DATALINEUP, S.NOMELOCAL, B.NOME AS NOMEBANDA, B.SITE FROM BANDA B, (SELECT DATALINEUP, NOMELOCAL, HORAINICIO FROM SHOW) S
                                    WHERE S.DATALINEUP = TO_DATE('$data') AND B.NOMELOCALSHOW = S.NOMELOCAL AND B.HORAINICIOSHOW = S.HORAINICIO ORDER BY B.NOME";

                            $result = BD_returnrows( $cons );

                            while ($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) {  
                                echo "<tr>\n";
                                foreach ($row as $item) {
                                    echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                                }
                                echo "</tr>\n";
                            }
                            echo "</table>";

                        }   
                   ?>
                     
            </div>
            <footer style="margin-top: 3rem; margin-bottom: 3rem; text-align: center;" > RockInRio &#169; Todos os direitos reservados.</footer>


        </div>


    </body>


</html>