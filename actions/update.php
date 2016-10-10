<?php

include "conexao.php";

if(!empty($_POST['hiddenUpdate'])) {


	if(!empty($_POST['hiddenNovoEquipamento'])) {


		$cortar = explode("/", $_POST['inputDataNotaFiscal']);
		$dataNota = $cortar[2]."-".$cortar[1]."-".$cortar[0];

		$pasta = "notas/";

		if(isset($_FILES['inputNotaFiscal'])) {
			$notaFiscal = $pasta . basename($_FILES['inputNotaFiscal']['name']);
			move_uploaded_file($_FILES['inputNotaFiscal']['tmp_name'], $notaFiscal);
		}

		if(isset($_POST['inputDisponivel']) && $_POST['inputDisponivel'] == 1) $disponivel = 1;
		else $disponivel = 0;

			$sql = "INSERT INTO relatorios_equipamentos (tipo
      ,patrimonio
      ,marca
      ,modelo
      ,tag
      ,nota_fiscal
      ,fornecedor
      ,cnpj
      ,data_nf
      ,link
      ,observacao
      ,disponivel) VALUES ('".$_POST['inputTipo']."', '".$_POST['inputPatrimonio']."', '".$_POST['inputMarca']."', '".$_POST['inputModelo']."', '".$_POST['inputTag']."', '0', '".$_POST['inputFornecedor']."', '".$_POST['inputCnpj']."', '".$dataNota."', '".$notaFiscal."', '".$_POST['inputObservacao']."', '".$disponivel."')";
			$res = sqlsrv_query($con, $sql);		
			$resultado = "Equipamento Inserido com Sucesso!";		

			$sql1 = "INSERT INTO relatorios_historico VALUES ('', 'Equipamento Inseridoa', '".date("Y-m-d H:i:s")."', 'O Equipamento foi Inserido com Sucesso!', '".$_SESSION['userId']."', '3')";
			$res1= sqlsrv_query($con, $sql1);

			//echo $sql;

	}

}