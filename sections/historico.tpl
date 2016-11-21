<h1>CONSULTAR HISTÓRICO</h1>

    <pagination total-items="totalItems" ng-model="currentPage" ng-change="pageChanged()" max-size="16" class="pagination-sm" items-per-page="itemsPerPage"></pagination>

	<div class="tituloResultados">
		<a class="linkTitulo2 selecionado" ng-click="ordenar2('id');">Dia e Hora</a><a  class="linkTitulo2" ng-click="ordenar2('evento');">Evento</a><a  class="linkTitulo2" ng-click="ordenar2('descricao');">Descrição</a><a  class="linkTitulo2" ng-click="ordenar2('usuario');">Usuário</a>
	</div>

	<div class="linhaResultado" ng-repeat="y in recordsHistorico.slice(((currentPage-1)*itemsPerPage), ((currentPage)*itemsPerPage)) | orderBy:myOrderBy2">
		<div class="colunaResultado2">{{y.diaHora}}</div><div class="colunaResultado2">{{y.evento}}</div><div class="colunaResultado2">{{y.descricao}}</div><div class="colunaResultado2">{{y.usuario}}</div>
	</div>

    <pagination total-items="totalItems" ng-model="currentPage" ng-change="pageChanged()" max-size="16" class="pagination-sm" items-per-page="itemsPerPage"></pagination>

	<script>

	$(function() {
		$('.linkTitulo2').click(function() {
			alert("Teste");
			var elementos = document.getElementsByClassName('linkTitulo2');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo2";
		}

		this.className = "linkTitulo2 selecionado";

		});
	});

	var appHistorico = angular.module("appHistorico", ['ui.bootstrap'])
	.controller("myCtrlHistorico", function($scope) {
   
    $scope.recordsHistorico = [
 
	<?php

	$sql = "SELECT TOP 2500 relatorios_historico.id, relatorios_historico.nome, relatorios_historico.hora, relatorios_historico.descricao, relatorios_usuarios.nome AS usuario FROM relatorios_historico LEFT JOIN relatorios_usuarios ON relatorios_historico.id_usuario = relatorios_usuarios.id  WHERE relatorios_historico.sistema = 7 AND relatorios_historico.id_usuario != 0 ORDER BY relatorios_historico.id DESC ";
	$res = sqlsrv_query($con, $sql);

	//echo $sql;

	$i = -1;
	 while($row = sqlsrv_fetch_array($res)) {
	 	$i++;
		if($i == 0) echo "{";
		else echo ", {";
		echo "'diaHora': '".$row['hora']->format('d/m/Y')."', 'evento': '".$row['nome']."', 'id': '".$row['id']."', 'descricao': '".$row['descricao']."', 'usuario': '".$row['usuario']."' }";
	}
	
	?>

    ];

      $scope.viewby = 50;
	  $scope.totalItems = $scope.recordsHistorico.length;
	  $scope.currentPage = 1;
	  $scope.itemsPerPage = $scope.viewby;
	  $scope.maxSize = 5; //Number of pager buttons to show

	  $scope.setPage = function (pageNo) {
	    $scope.currentPage = pageNo;
	  };

	  $scope.pageChanged = function() {
	    console.log('Page changed to: ' + $scope.currentPage);
	  };

	  $scope.setItemsPerPage = function(num) {
		  $scope.itemsPerPage = num;
		  $scope.currentPage = 1; //reset to first paghe
		}


      $scope.ordenar2 = function(y) {
      	if($scope.myOrderBy2 == y) y = "-"+y;
	    $scope.myOrderBy2 = y;
	  }
});

angular.bootstrap('#historico', ['appHistorico']);


</script>