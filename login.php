<?php

session_start();

?>
<meta charset="UTF-8">
<?php

date_default_timezone_set('America/Sao_Paulo');

// Exibir Erros Oriundos do PHP
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

if(!empty($_SESSION['usuario'])) header("location: ./");

else {

include "conexao.php";

if(!empty($_POST)) {
	$sql = "SELECT * FROM relatorios_usuarios WHERE login LIKE '".$_POST['usuario']."' AND senha LIKE '".$_POST['senha']."' COLLATE sql_latin1_general_cp1_cs_as";
	$res = sqlsrv_query($con, $sql);
	//echo $sql;
	$num = sqlsrv_has_rows($res);
	if($num > 0) {
		$row = sqlsrv_fetch_array($res);
		$_SESSION['usuario'] = $row['login'];
		$_SESSION['nome'] = $row['nome'];
		$_SESSION['userId'] = $row['id'];
		$_SESSION['acesso'] = $row['acesso'];
		
		$sql = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Login Usuário', '".date("Y-m-d H:i:s")."', 'Login Realizado com Sucesso.', '".$row['id']."', '0', '0')";
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

