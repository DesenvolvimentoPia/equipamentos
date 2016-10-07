<h2>Lista de Impressoras</h2>

	<input placeholder="Pesquisa Rápida" name="pesquisarImpressoras" id="pesquisarImpressoras" type="text" ng-model="filtro"><a id="adicionarImpressora">Adicionar</a>

	<div class="tituloResultados">
	<a  class="linkTitulo1 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo1" ng-click="ordenar('marca');">Marca</a><a  class="linkTitulo1" ng-click="ordenar('modelo');">Modelo</a><a  class="linkTitulo1" ng-click="ordenar('patrimonio');">IP</a><a  class="linkTitulo1" ng-click="ordenar('setor');">Setor</a><a  class="linkTitulo1" ng-click="ordenar('unidade');">Unidade</a>
	</div>

	<a data-cod="{{x.id}}" class="linhaResultado1 {{x.situacao}}" title="{{x.situacao}} {{x.problema}}" ng-repeat="x in recordsImpressoras | orderBy:myOrderBy | filter: filtro">
		<div class="colunaResultado">{{x.id}}</div><div class="colunaResultado">{{x.marca}}</div><div class="colunaResultado">{{x.modelo}}</div><div class="colunaResultado">{{x.patrimonio}}</div><div class="colunaResultado">{{x.setor}}</div><div class="colunaResultado">{{x.unidade}}</div>
	</a>

	<script>

	$(function() {
		$('.linkTitulo1').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo1');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo1";
		}

		this.className = "linkTitulo1 selecionado";

		});
	});

	var app = angular.module("appImpressoras", []);
	app.controller("myCtrlImpressoras", function($scope) {
    
    $scope.recordsImpressoras = [

	<?php

	$sql = "SELECT * FROM relatorios_impressoras WHERE disponivel = '1' ORDER BY id DESC";
	//echo $sql;
	$res = sqlsrv_query($con, $sql);

	$i = 0;
	 while($row = sqlsrv_fetch_array($res)) {
		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'marca': '".$row['tipo']."', 'modelo': '".$row['modelo']."', 'situacao': '".$row['situacao']."', 'usuario': '".$row['nome']."', 'patrimonio': '".$row['ip']."', 'setor': '".$row['setor']."', 'unidade': '".$row['unidade']."', 'problema': '".$row['lanpiaprn']."' }";
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
	$( "section" ).delegate( ".linhaResultado1", "click", function() {
	    var id = $(this).data('cod');
	    //alert("AQUI: "+id);
		//$('#impressoras').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "impressora.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#impressoras').html(data); // display data
		});

	});

	$('#adicionarImpressora').click(function() {

		//$('#impressoras').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "impressora.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  $('#impressoras').html(data); // display data
		});

	});
});

angular.bootstrap('#impressoras', ['appImpressoras']);
	
</script>