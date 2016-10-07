<?php


$db_server = '10.1.10.130\Teste';
$db_database = 'integracoes';
$db_user = 'soa';
$db_passwd = 'Fr@m3work';

$connectionInfo = array("Database"=>$db_database, "UID"=>$db_user, "PWD"=>$db_passwd, "CharacterSet" => "UTF-8");
$con = sqlsrv_connect($db_server, $connectionInfo);


?>