<?php

include "conexao.php";

if(!empty($_POST['hiddenCreate'])) {

		$chaves = array_keys($_POST);
		for($x = 0; $x < count($chaves); $x++){
			$chave = $chaves[$x];
			$_POST[$chave] = str_replace('"', "&quot;", $_POST[$chave]);
			$_POST[$chave] = str_replace("'", "&#039;", $_POST[$chave]);
		}


	if(!empty($_POST['hiddenNovoEquipamento'])) {


		$cortar = explode("/", $_POST['inputDataNotaFiscal']);
		if(isset($cortar['2'])) $dataNota = $cortar[2]."-".$cortar[1]."-".$cortar[0];
		else $dataNota = "";

		$pasta = "notas/";

		if(isset($_FILES['inputNotaFiscal']['name'])) {
			$notaFiscal = $pasta .$_POST['inputNumeroNota']."-". str_replace("'", "-", basename($_FILES['inputNotaFiscal']['name']));
			move_uploaded_file($_FILES['inputNotaFiscal']['tmp_name'], $notaFiscal);
		}

		$_POST['inputModelo'] = str_replace("'", '"', $_POST['inputModelo']);

		if(isset($_POST['inputDisponivel']) && $_POST['inputDisponivel'] == 1) $disponivel = 1;
		else $disponivel = 0;

		$patrimonios = explode(";", $_POST['inputPatrimonio']);
		$tags = explode(";", $_POST['inputTag']);

		for($i = 0; $i < count($patrimonios); $i++) {

			if(!isset($tags[$i])) $tags[$i] = "";

			$sql = "INSERT INTO relatorios_equipamentos (tipo, patrimonio, marca, modelo, tag, nota_fiscal, fornecedor, cnpj, data_nf, link, observacao, disponivel, garantia, status) VALUES ('".$_POST['inputTipo']."', '".$patrimonios[$i]."', '".$_POST['inputMarca']."', '".$_POST['inputModelo']."', '".$tags[$i]."', '".$_POST['inputNumeroNota']."', '".$_POST['inputFornecedor']."', '".$_POST['inputCnpj']."', '".$dataNota."', '".$notaFiscal."', '".$_POST['inputObservacao']."', '".$disponivel."', '".$_POST['inputGarantia']."','".$_POST['inputStatus']."')";
			$res = sqlsrv_query($con, $sql);		
			$resultado = "Equipamento Inserido com Sucesso!";	

			$lastRes = sqlsrv_query($con, "SELECT SCOPE_IDENTITY()");
			$lastId = sqlsrv_fetch_array($lastRes)[0];

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Equipamento Inserido', '".date("Y-m-d H:i:s")."', 'O Equipamento foi Inserido com Sucesso!', '".$_SESSION['userId']."', '7', '".$lastId."')";
			$res1= sqlsrv_query($con, $sql1);
			//echo $sql;

		}

			//echo $sql;

	}


	if(!empty($_POST['hiddenNovoLista'])) {

		if($_POST['inputTipo'] == 15) {
			$sql = "INSERT INTO relatorios_tipos (nome, tipo) VALUES ('".$_POST['inputNome']."', '".$_POST['inputTipoCategoria']."')";
		}

		else {
			$sql = "INSERT INTO relatorios_listas (nome, tipo) VALUES ('".$_POST['inputNome']."', '".$_POST['inputTipo']."')";
		}

		$res = sqlsrv_query($con, $sql);	

			$resultado = "Item de Lista Suspensa Inserido com Sucesso!";	

			$lastRes = sqlsrv_query($con, "SELECT SCOPE_IDENTITY()");
			$lastId = sqlsrv_fetch_array($lastRes)[0];
			

		if(isset($_POST['inputUnidade'])) {
			$sqlUnidade = "INSERT INTO relatorios_setores_unidades (id_setor, id_unidade) VALUES ('".$lastId."', '".$_POST['inputUnidade']."')";
			$resUnidade = sqlsrv_query($con, $sqlUnidade);		
		}	

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Item de Lista Suspensa Inserido', '".date("Y-m-d H:i:s")."', 'O Item de Lista Suspensa foi Inserido com Sucesso!', '".$_SESSION['userId']."', '7', '".$lastId."')";
			$res1= sqlsrv_query($con, $sql1);

			//echo $sql;

	}

	if(!empty($_POST['hiddenNovoLicensa'])) {


		$cortar = explode("/", $_POST['inputDataNotaFiscal']);
		$dataNota = $cortar[2]."-".$cortar[1]."-".$cortar[0];

		$pasta = "notas/";

		if(isset($_FILES['inputNotaFiscal']['name'])) {
			$notaFiscal = $pasta ."-".$_POST['inputNumeroNota']. basename($_FILES['inputNotaFiscal']['name']);
			move_uploaded_file($_FILES['inputNotaFiscal']['tmp_name'], $notaFiscal);
		}

		if(isset($_POST['inputDisponivel']) && $_POST['inputDisponivel'] == 1) $disponivel = 1;
		else $disponivel = 0;

			$sql = "INSERT INTO relatorios_licensas (tipo, tipoLicensa, chave, descricao, fabricante, nota_fiscal, fornecedor, cnpj, data_nf, observacoes, disponivel, link) VALUES ('".$_POST['inputTipo']."', '".$_POST['inputTipoLicensa']."', '".$_POST['inputChave']."', '".$_POST['inputDescricao']."', '".$_POST['inputFabricante']."', '".$_POST['inputNumeroNota']."', '".$_POST['inputFornecedor']."', '".$_POST['inputCnpj']."', '".$dataNota."', '".$_POST['inputObservacao']."', '".$disponivel."', '".$notaFiscal."')";
			$res = sqlsrv_query($con, $sql);		
			$resultado = "Licensa Inserido com Sucesso!";	

			$lastRes = sqlsrv_query($con, "SELECT SCOPE_IDENTITY()");
			$lastId = sqlsrv_fetch_array($lastRes)[0];

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Licença Inserida', '".date("Y-m-d H:i:s")."', 'A Licença foi Inserida com Sucesso!', '".$_SESSION['userId']."', '7', '".$lastId."')";
			$res1= sqlsrv_query($con, $sql1);

			//echo $sqlUnidade;
       
       }
   }