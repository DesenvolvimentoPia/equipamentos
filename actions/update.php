<?php

include "conexao.php";

if(!empty($_POST['hiddenUpdate'])) {

		$chaves = array_keys($_POST);
		for($x = 0; $x < count($chaves); $x++){
			$chave = $chaves[$x];
			$_POST[$chave] = str_replace('"', "&quot;", $_POST[$chave]);
			$_POST[$chave] = str_replace("'", "&#039;", $_POST[$chave]);
		}

	if(!empty($_POST['selectAddSetor'])) {
		$sqlCompare = "SELECT * FROM relatorios_itens_setores WHERE id_item = ".$_POST['hiddenEquipamento']." AND id_categoria = ".$_POST['hiddenEquipamentoTipo'];
		$resCompare = sqlsrv_query($con, $sqlCompare);
		$numCompare = sqlsrv_has_rows($resCompare);

		if($numCompare) {
			$rowCompare = sqlsrv_fetch_array($resCompare);
			$sql = "UPDATE relatorios_itens_setores SET id_setor = ".$_POST['selectAddSetor']." WHERE id = ".$rowCompare['id'];
			$res = sqlsrv_query($con, $sql);

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Equipamento - Setor Alterado', '".date("Y-m-d H:i:s")."', 'O Equipamento ".$_POST['hiddenEquipamento']." Teve o Setor Alterado de ".$rowCompare['id_setor']." para ".$_POST['selectAddSetor'].".', '".$_SESSION['userId']."', '7', '".$_POST['hiddenEquipamento']."')";
			$res1= sqlsrv_query($con, $sql1);	
		}

		else {
			$sql = "INSERT INTO relatorios_itens_setores (id_item, id_setor, id_categoria) VALUES ('".$_POST['hiddenEquipamento']."', '".$_POST['selectAddSetor']."', '".$_POST['hiddenEquipamentoTipo']."')";
			$res = sqlsrv_query($con, $sql);

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Equipamento - Setor Inserido', '".date("Y-m-d H:i:s")."', 'O Equipamento ".$_POST['hiddenEquipamento']." Teve o Setor ".$_POST['selectAddSetor']." Inserido com Sucesso', '".$_SESSION['userId']."', '7', '".$_POST['hiddenEquipamento']."')";
			$res1= sqlsrv_query($con, $sql1);	
		}
			$resultado = "Equipamento alterado com Sucesso!";

	}



	if(!empty($_POST['selectAddResponsavel'])) {
		
			$sql = "INSERT INTO relatorios_itens_responsaveis (id_item, id_setor, id_categoria) VALUES ('".$_POST['hiddenEquipamento']."', '".$_POST['selectAddResponsavel']."', '".$_POST['hiddenEquipamentoTipo']."')";
			$res = sqlsrv_query($con, $sql);

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Equipamento - Responsável Inserido', '".date("Y-m-d H:i:s")."', 'O Equipamento ".$_POST['hiddenEquipamento']." Teve o Responsável ".$_POST['selectAddResponsavel']." Inserido com Sucesso', '".$_SESSION['userId']."', '7', '".$_POST['hiddenEquipamento']."')";
			$res1= sqlsrv_query($con, $sql1);	

			$resultado = "Equipamento alterado com Sucesso!";

	}





	if(!empty($_POST['hiddenEquipamento']) && empty($_POST['selectAddSetor'])) {


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

			$sqlCompare = "SELECT * FROM relatorios_equipamentos WHERE id = ".$_POST['hiddenEquipamento'];
			$resCompare = sqlsrv_query($con, $sqlCompare);
			$rowCompare = sqlsrv_fetch_array($resCompare);

			$sql = "UPDATE relatorios_equipamentos SET tipo = '".$_POST['inputTipo']."', patrimonio = '".$_POST['inputPatrimonio']."', marca = '".$_POST['inputMarca']."', modelo = '".$_POST['inputModelo']."', tag = '".$_POST['inputTag']."', nota_fiscal = '".$_POST['inputNumeroNota']."', fornecedor = '".$_POST['inputFornecedor']."', cnpj = '".$_POST['inputCnpj']."', data_nf = '".$dataNota."', link = '".$notaFiscal."', observacao = '".$_POST['inputObservacao']."', garantia = '".$_POST['inputGarantia']."', status = '".$_POST['inputStatus']."', disponivel = '".$disponivel."' WHERE id = '".$_POST['hiddenEquipamento']."'";
			$res = sqlsrv_query($con, $sql);		
			$resultado = "Equipamento alterado com Sucesso!";

			$alterado = "";
			if($_POST['inputTipo'] != $rowCompare['tipo']) $alterado .= "O Campo TIPO foi Alterado de ".$rowCompare['tipo']." para ".$_POST['inputTipo'].". ";
			if($_POST['inputPatrimonio'] != $rowCompare['patrimonio']) $alterado .= "O Campo PATRIMÔNIO foi Alterado de ".$rowCompare['patrimonio']." para ".$_POST['inputPatrimonio'].". ";
			if($_POST['inputMarca'] != $rowCompare['marca']) $alterado .= "O Campo MARCA foi Alterado de ".$rowCompare['marca']." para ".$_POST['inputMarca'].". ";
			if($_POST['inputModelo'] != $rowCompare['modelo']) $alterado .= "O Campo MODELO foi Alterado de ".$rowCompare['modelo']." para ".$_POST['inputModelo'].". ";
			if($_POST['inputTag'] != $rowCompare['tag']) $alterado .= "O Campo TAG foi Alterado de ".$rowCompare['tag']." para ".$_POST['inputTag'].". ";
			if($_POST['inputNumeroNota'] != $rowCompare['nota_fiscal']) $alterado .= "O Campo NOTA FISCAL foi Alterado de ".$rowCompare['nota_fiscal']." para ".$_POST['inputNumeroNota'].". ";
			if($_POST['inputFornecedor'] != $rowCompare['fornecedor']) $alterado .= "O Campo FORNECEDOR foi Alterado de ".$rowCompare['fornecedor']." para ".$_POST['inputFornecedor'].". ";
			if($_POST['inputCnpj'] != $rowCompare['cnpj']) $alterado .= "O Campo CNPJ foi Alterado de ".$rowCompare['cnpj']." para ".$_POST['inputCnpj'].". ";
			if($dataNota != $rowCompare['data_nf']->format("Y-m-d")) $alterado .= "O Campo DATA NOTA FISCAL foi Alterado de ".$rowCompare['data_nf']->format("Y-m-d")." para ".$dataNota.". ";
			if($notaFiscal != $rowCompare['link']) $alterado .= "O Campo LINK DA NOTA FISCAL foi Alterado de ".$rowCompare['link']." para ".$notaFiscal.". ";
			if($_POST['inputObservacao'] != $rowCompare['observacao']) $alterado .= "O Campo OBSERVAÇÃO foi Alterado de ".$rowCompare['observacao']." para ".$_POST['inputObservacao'].". ";
			if($_POST['inputGarantia'] != $rowCompare['garantia']) $alterado .= "O Campo GARANTIA foi Alterado de ".$rowCompare['garantia']." para ".$_POST['inputGarantia'].". ";
			if($_POST['inputStatus'] != $rowCompare['status']) $alterado .= "O Campo STATUS foi Alterado de ".$rowCompare['status']." para ".$_POST['inputStatus'].". ";
			if($disponivel != $rowCompare['disponivel']) $alterado .= "O Campo DISPONIBILIDADE foi Alterado de ".$rowCompare['disponivel']." para ".$disponivel.". ";

			$alterado = str_replace(" .", " VAZIO.", $alterado);
			$alterado = str_replace("  ", " VAZIO ", $alterado);



			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Equipamento Alterado', '".date("Y-m-d H:i:s")."', 'O Equipamento ".$_POST['hiddenEquipamento']." foi Alterado com Sucesso. ".$alterado."', '".$_SESSION['userId']."', '7', '".$_POST['hiddenEquipamento']."')";
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

			

		if(isset($_POST['inputUnidade'])) {

			$sqlUnidade = "UPDATE relatorios_setores_unidades SET id_unidade = '".$_POST['inputUnidade']."' WHERE id_setor = ".$_POST['hiddenLista'];

			$resUnidade = sqlsrv_query($con, $sqlUnidade);		
		}	

			$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Item de Lista Suspensa Alterado', '".date("Y-m-d H:i:s")."', 'O Item de Lista Suspensa ".$_POST['hiddenLista']." foi Alterado com Sucesso!', '".$_SESSION['userId']."', '7', '".$_POST['hiddenLista']."')";
			$res1= sqlsrv_query($con, $sql1);

			//echo $sql;

	}

}