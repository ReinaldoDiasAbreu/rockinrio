<?php
	# Página de saída e finalização da sessão
	session_start();
	unset( $_SESSION['user'] );
    session_destroy();
	echo "<script language=javascript>alert( 'Saindo do sistema!' );</script>";
	echo "<script language=javascript>window.location.replace('../index.html');</script>";
?>