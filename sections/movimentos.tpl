<h2>Consultar Movimentos</h2>

<input placeholder="Pesquisa Rápida" name="pesquisarMovimentos" id="pesquisarMovimentos" type="text" ng-model="filtroMovimento"><a id="adicionarMovimento">Movimentar</a>


	<div class="tituloResultados">
		<a class="linkTitulo6 selecionado" ng-click="ordenar2('id');">ID</a><a class="linkTitulo6" ng-click="ordenar2('diaHora');">Dia e Hora</a><a  class="linkTitulo6" ng-click="ordenar2('tipo_item');">Tipo</a><a  class="linkTitulo6" ng-click="ordenar2('id_item');">Item</a><a  class="linkTitulo6" ng-click="ordenar2('direcao');">Direção</a><a  class="linkTitulo6" ng-click="ordenar2('usuario');">Responsável</a>
	</div>

	<a data-cod="{{y.id}}"  class="linhaResultado6 {{y.situacao}" ng-repeat="y in records.sort | orderBy:myOrderBy2 | filter: filtroMovimento">
		<div class="colunaResultado">{{y.id}}</div><div class="colunaResultado">{{y.diaHora}}</div><div class="colunaResultado">{{y.tipo_item}}</div><div class="colunaResultado">{{y.id_item}}</div><div class="colunaResultado">{{y.direcao}}</div><div class="colunaResultado">{{y.usuario}}</div>
	</a>

	<script>

	$(function() {
		$('.linkTitulo6').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo6');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo6";
		}

		this.className = "linkTitulo6 selecionado";

		});
	});

	var appMovimentos = angular.module("appMovimentos", [])
	.controller("myCtrlMovimentos", function($scope) {
    
    $scope.records = { "sort" : [

	<?php

	$sql = "SELECT * FROM relatorios_movimentos ORDER BY id DESC";
	$res = mysql_query($sql, $con);
	$num = mysql_num_rows($res);

	for($i = 0; $i < $num; $i++) {
	$row = mysql_fetch_array($res);
		if($i == 0) echo "{";
		else echo ", {";
		echo "'diaHora': '".$row['data']."', 'direcao': '".$row['direcao']."', 'id': ".$row['id'].", 'usuario': '".$row['usuario']."', 'tipo_item': '".$row['tipo_item']."', 'id_item': ".$row['id_item']." }";
	}
	
	?>

    ] }

      $scope.ordenar2 = function(y) {
      	if($scope.myOrderBy2 == y) y = "-"+y;
	    $scope.myOrderBy2 = y;
	  }
});




$(function () {
	$('#adicionarMovimento').click(function() {

		//$('#movimentos').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "movimento.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  $('#movimentos').html(data); // display data
		});

	});
});

angular.bootstrap('#movimentos', ['appMovimentos']);

</script>