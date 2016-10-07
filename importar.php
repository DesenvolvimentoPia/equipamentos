<meta charset="uft-8">

<?php

include "../conexao.php";
$arquivo = explode("
", file_get_contents("linhasDados2.csv"));

for($x = 0; $x < count($arquivo); $x++){
	$item = explode(";",  $arquivo[$x]);

	echo "<p>";

		$linha = substr($item[0], 0, 2)." ".substr($item[0], 2, 4)." ".substr($item[0], 6);
		echo $linha;
		if($item[1] == "SIM") $situacao = "Em uso";
		else $situacao = "Estoque";
		echo $situacao;
		$item[3] = substr($item[3], 1);
		$numero = substr($item[3], 0, 5)." ".substr($item[3], 5, 5)." ".substr($item[3], 10, 5)." ".substr($item[3], 15, 5);
		echo $numero;



		$sqlLinha = "SELECT * FROM relatorios_linhas WHERE numero = '".$linha."'";
		$resLinha = sqlsrv_query($sqlLinha, $con);
		$numLinha = sqlsrv_num_rows($resLinha);

		echo " A Linha existe: ".$numLinha;

		$sql = "INSERT INTO relatorios_linhas VALUES ('', '".$linha."', '".$situacao."', 'Voz')";
		$res = sqlsrv_query($con, $sql);

		$sqlId = "SELECT *FROM relatorios_linhas ORDER BY id DESC";
		$resId = sqlsrv_query($sqlId, $con);
		$rowId = sqlsrv_fetch_array($resId);

		$sqlChip = "SELECT * FROM relatorios_chips WHERE numero = '".$numero."'";
		$resChip = sqlsrv_query($sqlChip, $con);
		$numChip = sqlsrv_num_rows($resChip);

		echo " Número de Linhas: ".$numChip;

		if ($numChip > 0) {
			$rowChip = sqlsrv_fetch_array($resChip);
			$sql = "UPDATE relatorios_chips VALUES  numero = '".$numero."', id_linha = '".$rowId['id']."', situacao = '".$situacao."' WHERE id =".$rowChip['id'];
			$res = sqlsrv_query($con, $sql);
		}


		else {
			if (strlen($numero) > 10) {
				$sql = "INSERT INTO relatorios_chips VALUES ('', '".$numero."', '', '', '', '".$rowId['id']."', '".$situacao."')";
				$res = sqlsrv_query($con, $sql);
			}
		}


	echo"</p>";

}
