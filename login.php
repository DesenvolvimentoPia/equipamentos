<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

// Exibir Erros Oriundos do PHP
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

if(!empty($_SESSION['usuario'])) header("location: ./");

else {

include "conexao.php";

if(!empty($_POST)) {
	$sql = "SELECT * FROM relatorios_usuarios WHERE login = '".$_POST['usuario']."' AND senha = '".$_POST['senha']."'";
	$res = mysql_query($sql, $con);
	$num = mysql_num_rows($res);
	if($num > 0) {
		$row = mysql_fetch_array($res);
		$_SESSION['usuario'] = $row['login'];
		$_SESSION['nome'] = $row['nome'];
		$_SESSION['userId'] = $row['id'];
		$_SESSION['acesso'] = $row['acesso'];
		
		$sql = "INSERT INTO relatorios_historico VALUES ('', 'Login Usuário', '".date("Y-m-d H:i:s")."', 'Login Realizado com Sucesso.', '".$row['id']."', '0')";
		$res = mysql_query($sql, $con);
		
		header("location: ./");
	}

	else $erro = "Usuário ou Senha Inconrretos!";
}

echo "<body id='login'>";

// Incluindo Corpo
include "includes/login.html";

// Incluindo rodapé Padrão
include "includes/rodape.html";

echo "</body>";

}

