<?php

include "conexao.php";

if(!empty($_POST['hiddenUpdate'])) {

		$chaves = array_keys($_POST);
		for($x = 0; $x < count($chaves); $x++){
			$chave = $chaves[$x];
			$_POST[$chave] = str_replace('"', "&quot;", $_POST[$chave]);
			$_POST[$chave] = str_replace("'", "&#039;", $_POST[$chave]);
		}


	if(!empty($_POST['hiddenEquipamento'])) {


		$cortar = explode("/", $_POST['inputDataNotaFiscal']);
		$dataNota = $cortar[2]."-".$cortar[1]."-".$cortar[0];

		$pasta = "notas/";
		
		$_POST['inputModelo'] = str_replace("'", '"', $_POST['inputModelo']);

		if(isset($_FILES['inputNotaFiscal']) && !empty($_FILES['inputNotaFiscal']) && isset($_FILES['inputNotaFiscal']['tmp_name']) && !empty($_FILES['inputNotaFiscal']['tmp_name'])) {
			$notaFiscal = $pasta ."-".$_POST['inputNumeroNota']. basename($_FILES['inputNotaFiscal']['name']);
			move_uploaded_file($_FILES['inputNotaFiscal']['tmp_name'], $notaFiscal);
		}

		if(empty($notaFiscal)) $notaFiscal = $_POST['inputNotaAtual'];

		if(isset($_POST['inputDisponivel']) && $_POST['inputDisponivel'] == 1) $disponivel = 1;
		else $disponivel = 0;

			$sql = "UPDATE relatorios_equipamentos SET tipo = '".$_POST['inputTipo']."', patrimonio = '".$_POST['inputPatrimonio']."', marca = '".$_POST['inputMarca']."', modelo = '".$_POST['inputModelo']."', tag = '".$_POST['inputTag']."', nota_fiscal = '".$_POST['inputNumeroNota']."', fornecedor = '".$_POST['inputFornecedor']."', cnpj = '".$_POST['inputCnpj']."', data_nf = '".$dataNota."', link = '".$notaFiscal."', observacao = '".$_POST['inputObservacao']."', garantia = '".$_POST['inputGarantia']."', status = '".$_POST['inputStatus']."', disponivel = '".$disponivel."' WHERE id = '".$_POST['hiddenEquipamento']."'";
			$res = sqlsrv_query($con, $sql);		
			$resultado = "Equipamento alterado com Sucesso!";		

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Equipamento Alterado', '".date("Y-m-d H:i:s")."', 'O Equipamento ".$_POST['hiddenEquipamento']." foi Alterado com Sucesso!', '".$_SESSION['userId']."', '7', '".$_POST['hiddenEquipamento']."')";
			$res1= sqlsrv_query($con, $sql1);

			//echo $sql1;

	}


	if(!empty($_POST['hiddenLicensa'])) {


		$cortar = explode("/", $_POST['inputDataNotaFiscal']);
		$dataNota = $cortar[2]."-".$cortar[1]."-".$cortar[0];

		$pasta = "notas/";

		if(isset($_FILES['inputNotaFiscal']) && !empty($_FILES['inputNotaFiscal']) && isset($_FILES['inputNotaFiscal']['tmp_name']) && !empty($_FILES['inputNotaFiscal']['tmp_name'])) {
			$notaFiscal = $pasta ."-".$_POST['inputNumeroNota']. basename($_FILES['inputNotaFiscal']['name']);
			move_uploaded_file($_FILES['inputNotaFiscal']['tmp_name'], $notaFiscal);
		}

		if(empty($notaFiscal)) $notaFiscal = $_POST['inputNotaAtual'];

		if(isset($_POST['inputDisponivel']) && $_POST['inputDisponivel'] == 1) $disponivel = 1;
		else $disponivel = 0;

			$sql = "UPDATE relatorios_licensas SET tipo = '".$_POST['inputTipo']."', tipoLicensa = '".$_POST['inputTipoLicensa']."', chave = '".$_POST['inputChave']."', descricao = '".$_POST['inputDescricao']."', fabricante = '".$_POST['inputFabricante']."', nota_fiscal = '".$_POST['inputNumeroNota']."', fornecedor = '".$_POST['inputFornecedor']."', cnpj = '".$_POST['inputCnpj']."', data_nf = '".$dataNota."', link = '".$notaFiscal."', observacoes = '".$_POST['inputObservacao']."', disponivel = '".$disponivel."' WHERE id = '".$_POST['hiddenLicensa']."'";
			$res = sqlsrv_query($con, $sql);		
			$resultado = "Licensa alterada com Sucesso!";		

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Licença Alterada', '".date("Y-m-d H:i:s")."', 'A Licença ".$_POST['hiddenLicensa']." foi alterada com Sucesso!', '".$_SESSION['userId']."', '7', '".$_POST['hiddenLicensa']."')";
			$res1= sqlsrv_query($con, $sql1);

			//echo $sql;

	}


	if(!empty($_POST['hiddenLista'])) {

		if($_POST['inputTipo'] == 15) {
			$sql = "UPDATE relatorios_tipos SET nome = '".$_POST['inputNome']."', tipo = '".$_POST['inputTipoCategoria']."' WHERE id =".$_POST['hiddenLista'];
		}

		else {
			$sql = "UPDATE relatorios_listas SET nome = '".$_POST['inputNome']."', tipo = '".$_POST['inputTipo']."' WHERE id = ".$_POST['hiddenLista'];
		}

		$res = sqlsrv_query($con, $sql);	

			$resultado = "Item de Lista Suspensa Alterado com Sucesso!";	

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Item de Lista Suspensa Alterado', '".date("Y-m-d H:i:s")."', 'O Item de Lista Suspensa ".$_POST['hiddenLista']." foi Alterado com Sucesso!', '".$_SESSION['userId']."', '7', '".$_POST['hiddenLista']."')";
			$res1= sqlsrv_query($con, $sql1);

			//echo $sql;

	}

}