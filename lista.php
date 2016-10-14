<?php

session_start();

// Exibir Erros Oriundos do PHP
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

if(empty($_SESSION['usuario'])) header("location: ./login.php");

else {

	//echo "AQUI: ".$_GET['tipo'];

//if(!empty($_GET['tipo'])) $_SESSION['tipoAtual'] = $_GET['tipo'];

// Incluindo Cabeçalho Padrão
if($_GET['id'] == 'novo') include "includes/novoLista.html";
else include "includes/lista.html";

}

