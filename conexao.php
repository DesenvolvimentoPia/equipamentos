<?php

// Conexão com banco de Dados 
$db_server = '10.1.10.130\Teste'; // Inatância de Produção
$db_database = 'PROTHEUS_8080'; // Banco de dados "integracoes"
$db_user = 'gfe_consulta'; // Usuário com acesso nível Owner
$db_passwd = 'P3squ1s@'; // Senha

$connectionInfo = array("Database"=>$db_database, "UID"=>$db_user, "PWD"=>$db_passwd); // Seta os Parâmetros de Conexão
$conn = sqlsrv_connect($db_server, $connectionInfo); // Executa o Connect via SQLSRV


?>