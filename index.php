<?php

session_start();

include "../sisti/conexao.php";

if(empty($_GET['url'])) {

	$sql = "SELECT * FROM  relatorios_usuarios_aplicativos WHERE id_aplicativo = 4 AND id_usuario = ".$_SESSION['userId'];
	$res = sqlsrv_query($con, $sql);
	$has = sqlsrv_has_rows($res);

	if($has) $_SESSION['provisionado'] = 1;
	else {
		header('location: ../');
	}

	$sqlAcessos = "UPDATE relatorios_aplicativos SET ultimo = '".date('Y-m-d')."' WHERE id = 4";
	$resAcessos = sqlsrv_query($con, $sqlAcessos);

	$sqlAcessos = "SELECT * FROM relatorios_aplicativos_acessos WHERE id_aplicativo = 4 AND data = '".date('Y-m-d')."'";
	$resAcessos = sqlsrv_query($con, $sqlAcessos);
	$hasAcessos = sqlsrv_has_rows($resAcessos);

	if($hasAcessos) {
		$rowAcessos = sqlsrv_fetch_array($resAcessos);
		$tot = $rowAcessos['total'] + 1;
		$sqlAlterar = "UPDATE relatorios_aplicativos_acessos SET total = ".$tot." WHERE id = ".$rowAcessos['id'];
	}

	else $sqlAlterar = "INSERT INTO relatorios_aplicativos_acessos (id_aplicativo, data, total) VALUES (4, '".date('Y-m-d')."', 1)";

	//echo $sqlAlterar;
	$resAlterar = sqlsrv_query($con, $sqlAlterar);

}

// Exibir Erros Oriundos do PHP
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

if(empty($_SESSION['usuario']) && !($_SESSION['acesso'] == 9 || $_SESSION['acesso'] == 2)) header("location: ../sisti/login.php");

else {

// Incluindo Cabeçalho Padrão
include "includes/cabecalho.html";

// Incluindo Corpo
include "includes/conteudo.html";

// Incluindo Scripts
include "includes/scripts.html";

// Incluindo rodapé Padrão
include "includes/rodape.html";

}

