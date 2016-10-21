	<?php


	$db_server = '10.1.10.130\Teste';
	$db_database = 'integracoes';
	$db_user = 'soa';
	$db_passwd = 'Fr@m3work';

	$connectionInfo = array("Database"=>$db_database, "UID"=>$db_user, "PWD"=>$db_passwd, "CharacterSet" => "UTF-8");
	$con = sqlsrv_connect($db_server, $connectionInfo);

	$sql = "SELECT * FROM relatorios_tipos WHERE id = '".$_POST['ultimo']."'";
	$res = sqlsrv_query($con, $sql);
	$row = sqlsrv_fetch_array($res);

	$tipo = $row['nome'];


	?>

	<?php if($_POST['ultimo'] == 19) { ?>
	<style>

	#listaDinamico a.linhaResultado7 div:nth-child(2), #listaDinamico div.tituloResultados a:nth-child(2) {
	    width: 50%;
	}

	.tituloResultados a:nth-child(3), .linhaResultado7 .colunaResultado:nth-child(3) {
	    width: 36%;
	}

	</style>
	<?php } ?>
	
	<div id="angularListas" ng-app="appAngularListas" ng-controller="myCtrlAngularListas">
	<h2 id="h2Listas">Lista Suspensa: <?=$tipo;?></h2>
	
	<input placeholder="Pesquisa Rápida" name="pesquisarListas" id="pesquisarListas" type="text" ng-model="filtro"><a id="adicionarLista">Adicionar</a>

	<div class="tituloResultados">
	<a class="linkTitulo7 selecionado" ng-click="ordenar('id');">ID</a><a class="linkTitulo7" ng-click="ordenar('nome');">Nome do Item</a><?php if($_POST['ultimo'] == 19) { ?><a class="linkTitulo7" ng-click="ordenar('unidade');">Unidade</a><?php } ?>
	</div>

	<a class="linhaResultado7 {{x.tipo}}" ng-repeat="x in recordsListas | orderBy:myOrderBy | filter: filtro">
		<div data-cod="{{x.id}}" class="colunaResultado colunaId">{{x.id}}</div><div class="colunaResultado">{{x.nome}}</div><?php if($_POST['ultimo'] == 19) { ?><div class="colunaResultado">{{x.unidade}}</div><?php } ?>
	</a>

	<div class="semResultados" ng-if="!recordsListas[0]">Nenhum Resultado.</div>

	</div>

	<script>

	$(function() {
		$('.linkTitulo7').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo7');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo7";
		}

		this.className = "linkTitulo7 selecionado";

		});
	});

	var app = angular.module("appAngularListas", []);
	app.controller("myCtrlAngularListas", function($scope) {
    
    $scope.recordsListas = [

	<?php

	if($_POST['ultimo'] == "15") $sql = "SELECT * FROM relatorios_tipos WHERE tipo < 3 ORDER BY id DESC";
	else if($_POST['ultimo'] != "19") $sql = "SELECT * FROM relatorios_listas WHERE tipo = '".$_POST['ultimo']."' ORDER BY id DESC";
	else $sql = "SELECT a.*, c.nome as unidade FROM relatorios_listas a 
		LEFT JOIN relatorios_setores_unidades b ON
		a.id = b.id_setor
		LEFT JOIN relatorios_listas c ON
		b.id_unidade = c.id
	WHERE a.tipo = '".$_POST['ultimo']."' ORDER BY a.id DESC";
	$res = sqlsrv_query($con, $sql);

	//echo $sql; 

	$i = 0;
	 while($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {

		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'nome': '".$row['nome']."', 'unidade': '".$row['unidade']."' }";

		$i++;
	}
	
	?>

    ];
      $scope.ordenar = function(x) {
      	if($scope.myOrderBy == x) x = "-"+x;
	    $scope.myOrderBy = x;
	  }

});


$(function () {
	$( "section" ).delegate( ".colunaId", "click", function() {
	    var id = $(this).data('cod');
	    //alert("AQUI: "+id);
		//$('#listaDinamico').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "lista.php?id="+id+"&tipo=<?=$tipo?>"
		}).done(function(data) { // data what is sent back by the php page
		  $('#listaDinamico').html(data); // display data
		});

	});

	$('#adicionarLista').click(function() {

		//$('#listaDinamico').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "lista.php?id=novo&tipo=<?=$tipo?>"
		}).done(function(data) { // data what is sent back by the php page
		  $('#listaDinamico').html(data); // display data
		});

	});
});

angular.bootstrap('#angularListas', ['appAngularListas']);
	
</script>