<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

// Exibir Erros Oriundos do PHP
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

if(!empty($_SESSION['usuario'])) header("location: ./");

else {

$db_server = '10.1.10.130\Teste';
$db_database = 'integracoes';
$db_user = 'soa';
$db_passwd = 'Fr@m3work';

$connectionInfo = array("Database"=>$db_database, "UID"=>$db_user, "PWD"=>$db_passwd);
$con = sqlsrv_connect($db_server, $connectionInfo);

if(!empty($_POST)) {
	$sql = "SELECT * FROM relatorios_usuarios WHERE login LIKE '".$_POST['usuario']."' AND senha LIKE '".$_POST['senha']."'";
	$res = sqlsrv_query($con, $sql);
	//echo $sql;
	$num = sqlsrv_has_rows($res);
	if($num > 0) {
		$row = sqlsrv_fetch_array($res);
		$_SESSION['usuario'] = $row['login'];
		$_SESSION['nome'] = $row['nome'];
		$_SESSION['userId'] = $row['id'];
		$_SESSION['acesso'] = $row['acesso'];
		
		$sql = "INSERT INTO relatorios_historico VALUES ('', 'Login Usuário', '".date("Y-m-d H:i:s")."', 'Login Realizado com Sucesso.', '".$row['id']."', '0')";
		$res = sqlsrv_query($con, $sql);
		
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

