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
	
	<div id="angularEquipamentos" ng-app="appAngularEquipamentos" ng-controller="myCtrlAngularEquipamentos">
	<h2 id="h2Equipamentos">Lista de Equipamentos: <?=$tipo;?></h2>
	
	<input placeholder="Pesquisa Rápida" name="pesquisarEquipamentos" id="pesquisarEquipamentos" type="text" ng-model="filtro"><a id="adicionarEquipamento">Adicionar</a>

	<div class="tituloResultados">
	<a class="linkTitulo7 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo7" ng-click="ordenar('marca');">Marca</a><a class="linkTitulo7" ng-click="ordenar('modelo');">Modelo</a><a  class="linkTitulo7" ng-click="ordenar('fornecedor');">Fornecedor</a><a  class="linkTitulo7" ng-click="ordenar('patrimonio');">Patrimônio</a><a  class="linkTitulo7" ng-click="ordenar('tag');">TAG</a><a  class="linkTitulo7" ng-click="ordenar('link');">Nota Fiscal</a>
	</div>

	<a class="linhaResultado7 {{x.tipo}}" ng-repeat="x in recordsEquipamentos | orderBy:myOrderBy | filter: filtro">
		<div data-cod="{{x.id}}" class="colunaResultado colunaId">{{x.id}}</div><div class="colunaResultado">{{x.marca}}</div><div class="colunaResultado">{{x.modelo}}</div><div class="colunaResultado">{{x.fornecedor}}</div><div class="colunaResultado">{{x.patrimonio}}</div><div class="colunaResultado">{{x.tag}}</div><div class="colunaResultado"><span data-abrir="{{x.link}}" onclick="window.open(this.dataset.abrir, '_blank')">Ver Nota</span></div>
	</a>

	<div class="semResultados" ng-if="!recordsEquipamentos[0]">Nenhum Resultado.</div>

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

	var app = angular.module("appAngularEquipamentos", []);
	app.controller("myCtrlAngularEquipamentos", function($scope) {
    
    $scope.recordsEquipamentos = [

	<?php

	$sql = "SELECT relatorios_equipamentos.*, relatorios_marcas.nome AS nomeMarca, relatorios_fornecedores.nome AS nomeFornecedor FROM relatorios_equipamentos LEFT JOIN relatorios_marcas ON relatorios_equipamentos.marca = relatorios_marcas.id LEFT JOIN relatorios_fornecedores ON relatorios_equipamentos.fornecedor = relatorios_fornecedores.id WHERE disponivel = '1' AND tipo = '".$_POST['ultimo']."' ORDER BY id DESC";
	$res = sqlsrv_query($con, $sql);

	//print_r($res);

	$i = 0;
	 while($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {

		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'marca': '".$row['nomeMarca']."', 'modelo': '".$row['modelo']."', 'tipo': '".$row['tipo']."', 'fornecedor': '".$row['nomeFornecedor']."', 'patrimonio': '".$row['patrimonio']."', 'tag': '".$row['tag']."', 'link': '".$row['link']."', 'data_nf': '".$row['data_nf']->format('d/m/Y')."' }";

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
		//$('#equipamentoDinamico').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "equipamento.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#equipamentoDinamico').html(data); // display data
		});

	});

	$('#adicionarEquipamento').click(function() {

		//$('#equipamentoDinamico').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "equipamento.php?id=novo&tipo=<?=$tipo?>"
		}).done(function(data) { // data what is sent back by the php page
		  $('#equipamentoDinamico').html(data); // display data
		});

	});
});

angular.bootstrap('#angularEquipamentos', ['appAngularEquipamentos']);
	
</script>