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
	
	<div id="angularLicensas" ng-app="appAngularLicensas" ng-controller="myCtrlAngularLicensas">
	<h2 id="h2Licensas">Lista de Licensas: <?=$tipo;?></h2>
	
	<input placeholder="Pesquisa Rápida" name="pesquisarLicensas" id="pesquisarLicensas" type="text" ng-model="filtro"><a id="adicionarLicensa">Adicionar</a>

	<div class="tituloResultados">
	<a class="linkTitulo7 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo7" ng-click="ordenar('fabricante');">Marca</a><a class="linkTitulo7" ng-click="ordenar('tipoLicensa');">Modelo</a><a  class="linkTitulo7" ng-click="ordenar('fornecedor');">Fornecedor</a><a  class="linkTitulo7" ng-click="ordenar('fabricante');">Fabricante</a><a  class="linkTitulo7" ng-click="ordenar('chave');">TAG</a><a  class="linkTitulo7" ng-click="ordenar('link');">Nota Fiscal</a>
	</div>

	<a class="linhaResultado7 {{x.tipo}}" ng-repeat="x in recordsLicensas | orderBy:myOrderBy | filter: filtro">
		<div data-cod="{{x.id}}" class="colunaResultado colunaId">{{x.id}}</div><div class="colunaResultado">{{x.fabricante}}</div><div class="colunaResultado">{{x.tipoLicensa}}</div><div class="colunaResultado">{{x.fornecedor}}</div><div class="colunaResultado">{{x.fabricante}}</div><div class="colunaResultado">{{x.chave}}</div><div class="colunaResultado"><span data-abrir="{{x.link}}" onclick="window.open(this.dataset.abrir, '_blank')">Ver Nota</span></div>
	</a>

	<div class="semResultados" ng-if="!recordsLicensas[0]">Nenhum Resultado.</div>

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

	var app = angular.module("appAngularLicensas", []);
	app.controller("myCtrlAngularLicensas", function($scope) {
    
    $scope.recordsLicensas = [

	<?php

	$sql = "SELECT relatorios_licensas.*, relatorios_fornecedores.nome AS nomeFornecedor FROM relatorios_licensas LEFT JOIN relatorios_fornecedores ON relatorios_licensas.fornecedor = relatorios_fornecedores.id WHERE disponivel = '1' AND tipo = '".$_POST['ultimo']."' ORDER BY id DESC";
	$res = sqlsrv_query($con, $sql);

	//echo $sql; 

	$i = 0;
	 while($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {

		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'fabricante': '".$row['fabricante']."', 'tipoLicensa': '".$row['tipoLicensa']."', 'tipo': '".$row['tipo']."', 'fornecedor': '".$row['nomeFornecedor']."', 'chave': '".$row['chave']."', 'link': '".$row['link']."', 'data_nf': '".$row['data_nf']->format('d/m/Y')."' }";

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
		//$('#licensaDinamico').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "licensa.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#licensaDinamico').html(data); // display data
		});

	});

	$('#adicionarLicensa').click(function() {

		//$('#licensaDinamico').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "licensa.php?id=novo&tipo=<?=$tipo?>"
		}).done(function(data) { // data what is sent back by the php page
		  $('#licensaDinamico').html(data); // display data
		});

	});
});

angular.bootstrap('#angularLicensas', ['appAngularLicensas']);
	
</script>