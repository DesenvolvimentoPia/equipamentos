	<?php


	include "conexao.php";

	$sql = "SELECT * FROM relatorios_tipos WHERE id = '".$_POST['ultimo']."'";
	$res = sqlsrv_query($con, $sql);
	$row = sqlsrv_fetch_array($res);

	$tipo = $row['nome'];

 
	?>
	
	<div id="angularLicensas" ng-app="appAngularLicensas" ng-controller="myCtrlAngularLicensas">
	<h2 id="h2Licensas">Lista de Licenças: <?=$tipo;?></h2>
	
	<input placeholder="Pesquisa Rápida" name="pesquisarLicensas" id="pesquisarLicensas" type="text" ng-model="filtro"><a id="adicionarLicensa">Adicionar</a>

	<div class="tituloResultados">
	<a class="linkTitulo7 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo7" ng-click="ordenar('tipo');">Categoria</a><a  class="linkTitulo7" ng-click="ordenar('tipoLicensa');">Tipo</a><a  class="linkTitulo7" ng-click="ordenar('fabricante');">Fabricante</a><a  class="linkTitulo7" ng-click="ordenar('fornecedor');">Fornecedor</a><a  class="linkTitulo7" ng-click="ordenar('chave');">Chave</a><a  class="linkTitulo7" ng-click="ordenar('link');">Nota Fiscal</a>
	</div>

	<a class="linhaResultado7 {{x.tipo}}" ng-repeat="x in recordsLicensas | orderBy:myOrderBy | filter: filtro">
		<div data-cod="{{x.id}}" class="colunaResultado colunaId">{{x.id}}<span class='editar'> - Editar</span></div><div class="colunaResultado">{{x.tipo}}</div><div class="colunaResultado">{{x.tipoLicensa}}</div><div class="colunaResultado">{{x.fabricante}}</div><div class="colunaResultado">{{x.fornecedor}}</div><div class="colunaResultado">{{x.chave}}</div><div class="colunaResultado"><span data-abrir="{{x.link}}" onclick="window.open(this.dataset.abrir, '_blank')">Ver Nota</span></div>
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

	$sql = "SELECT relatorios_licensas.*, a.nome AS nomeFornecedor, b.nome AS nomeFabricante, c.nome AS nomeTipoLicensa, d.nome AS nomeTipo FROM relatorios_licensas LEFT JOIN relatorios_listas a ON relatorios_licensas.fornecedor = a.id AND a.tipo = 17 LEFT JOIN relatorios_listas b ON relatorios_licensas.fabricante = b.id LEFT JOIN relatorios_listas c ON relatorios_licensas.tipoLicensa = c.id LEFT JOIN relatorios_tipos d ON relatorios_licensas.tipo = d.id WHERE disponivel = '1' AND relatorios_licensas.tipo = '".$_POST['ultimo']."' ORDER BY id DESC";
	$res = sqlsrv_query($con, $sql);

	//echo $sql; 

	$i = 0;
	 while($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {

		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'fabricante': '".$row['nomeFabricante']."', 'tipoLicensa': '".$row['nomeTipoLicensa']."', 'tipo': '".$row['nomeTipo']."', 'fornecedor': '".$row['nomeFornecedor']."', 'chave': '".$row['chave']."', 'link': '".$row['link']."', 'data_nf': '".$row['data_nf']->format('d/m/Y')."' }";

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