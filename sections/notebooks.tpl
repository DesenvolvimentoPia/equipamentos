<h2>Lista de Notebooks</h2>

	<input placeholder="Pesquisa Rápida" name="pesquisarNotebooks" id="pesquisarNotebooks" type="text" ng-model="filtro"><a id="adicionarNotebook">Adicionar</a>

	<div class="tituloResultados">
	<a  class="linkTitulo7 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo7" ng-click="ordenar('marca');">Marca</a><a  class="linkTitulo7" ng-click="ordenar('modelo');">Modelo</a><a  class="linkTitulo7" ng-click="ordenar('usuario');">Usuário</a><a  class="linkTitulo7" ng-click="ordenar('patrimonio');">Patrimônio</a><a  class="linkTitulo7" ng-click="ordenar('setor');">Setor</a><a  class="linkTitulo7" ng-click="ordenar('unidade');">Unidade</a>
	</div>

	<a data-cod="{{x.id}}" class="linhaResultado7 {{x.situacao}}" title="{{x.situacao}} {{x.problema}}" ng-repeat="x in recordsNotebooks | orderBy:myOrderBy | filter: filtro">
		<div class="colunaResultado">{{x.id}}</div><div class="colunaResultado">{{x.marca}}</div><div class="colunaResultado">{{x.modelo}}</div><div class="colunaResultado">{{x.usuario}}</div><div class="colunaResultado">{{x.patrimonio}}</div><div class="colunaResultado">{{x.setor}}</div><div class="colunaResultado">{{x.unidade}}</div>
	</a>

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

	var app = angular.module("appNotebooks", []);
	app.controller("myCtrlNotebooks", function($scope) {
    
    $scope.recordsNotebooks = [

	<?php

	$sql = "SELECT * FROM relatorios_notebooks ORDER BY id DESC";
	$res = mysql_query($sql, $con);
	$num = mysql_num_rows($res);

	for($i = 0; $i < $num; $i++) {
	$row = mysql_fetch_array($res);
		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'marca': '".$row['marca']."', 'modelo': '".$row['modelo']."', 'situacao': '".$row['situacao']."', 'usuario': '".$row['usuario']."', 'patrimonio': '".$row['patrimonio']."', 'setor': '".$row['setor']."', 'unidade': '".$row['unidade']."', 'problema': '".$row['problema']."' }";
	}
	
	?>

    ];
      $scope.ordenar = function(x) {
      	if($scope.myOrderBy == x) x = "-"+x;
	    $scope.myOrderBy = x;
	  }

});


$(function () {
	$( "section" ).delegate( ".linhaResultado7", "click", function() {
	    var id = $(this).data('cod');
	    //alert("AQUI: "+id);
		//$('#notebooks').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "notebook.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#notebooks').html(data); // display data
		});

	});

	$('#adicionarNotebook').click(function() {

		//$('#notebooks').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "notebook.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  $('#notebooks').html(data); // display data
		});

	});
});

angular.bootstrap('#notebooks', ['appNotebooks']);
	
</script>