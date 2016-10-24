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

	<a class='totais' ng-click="filtro='Alocado'" title="{{porcento2}}%" ng-bind="alocados"></a><a class='totais' title="{{porcento1}}%" ng-bind="completos" ng-click="filtro='Completo'"></a><a class='totais' ng-bind="total" ng-click="filtro=''"></a>

	<div class="tituloResultados">
	<a class="linkTitulo7 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo7" ng-click="ordenar('marca');">Marca</a><a class="linkTitulo7" ng-click="ordenar('modelo');">Modelo</a><a  class="linkTitulo7" ng-click="ordenar('fornecedor');">Fornecedor</a><a  class="linkTitulo7" ng-click="ordenar('patrimonio');">Patrimônio</a><a  class="linkTitulo7" ng-click="ordenar('tag');">TAG</a><a  class="linkTitulo7" ng-click="ordenar('link');">Nota Fiscal</a>
	</div>

	<a class="linhaResultado7 {{x.tipo}}" ng-repeat="x in recordsEquipamentos | orderBy:myOrderBy | filter: filtro | filter: filtro2">
		<div class="{{x.completo}}" title="Item Completo"></div><div class="{{x.setor}}" title="Item Alocado"></div><div data-cod="{{x.id}}" class="colunaResultado colunaId status{{x.status}}" title="{{x.titulo}}">{{x.id}}<span class='editar'> - Editar</span></div><div class="colunaResultado">{{x.marca}}</div><div class="colunaResultado">{{x.modelo}}</div><div class="colunaResultado">{{x.fornecedor}}</div><div class="colunaResultado">{{x.patrimonio}}</div><div class="colunaResultado">{{x.tag}}</div><div class="colunaResultado"><span data-abrir="{{x.link}}" onclick="window.open(this.dataset.abrir, '_blank')">Ver Nota</span></div>
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

	$sql = "SELECT relatorios_equipamentos.*, a.nome AS nomeMarca, b.nome AS nomeFornecedor, d.nome AS setor FROM relatorios_equipamentos 
	LEFT JOIN relatorios_listas a ON relatorios_equipamentos.marca = a.id AND a.tipo = 18 
	LEFT JOIN relatorios_listas b ON relatorios_equipamentos.fornecedor = b.id AND b.tipo = 17 
	LEFT JOIN relatorios_itens_setores c ON relatorios_equipamentos.id = c.id_item
	LEFT JOIN relatorios_listas d ON c.id_setor = d.id
	WHERE relatorios_equipamentos.disponivel = '1' AND relatorios_equipamentos.tipo = '".$_POST['ultimo']."' ORDER BY relatorios_equipamentos.id DESC";
	$res = sqlsrv_query($con, $sql);

	//echo $sql;

	$i = 0;
	$alocados = 0;
	$completos = 0;
	 while($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {

	if($row['status'] == 2) $titulo = "Entregue";
	else if($row['status'] == 1) $titulo = "Almox";
	else $titulo = "Baixa";

	$row['modelo'] = str_replace('&quot;', '"', $row['modelo']);
	$row['modelo'] = str_replace('&#039;', '"', $row['modelo']);

	if(!empty($row['setor'])) {
		$setor = "itemAlocado";
		$alocados++;
	}
	else $setor = "";

	if(!empty($row['setor']) && !empty($row['tag']) && !empty($row['modelo']) && !empty($row['data_nf'])) {
		$completo = "itemCompleto";
		$completos++;
	}
	else $completo = "";

		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'marca': '".$row['nomeMarca']."', 'modelo': '".$row['modelo']."', 'tipo': '".$row['tipo']."', 'fornecedor': '".$row['nomeFornecedor']."', 'patrimonio': '".$row['patrimonio']."', 'cnpj': '".$row['cnpj']."', 'status': '".$row['status']."', 'titulo': '".$titulo."', 'tag': '".$row['tag']."', 'link': '".$row['link']."', 'setor': '".$setor."', 'completo': '".$completo."', 'data_nf': '".$row['data_nf']->format('d/m/Y')."' }";

		$i++;
	}
	
	?>

    ];

      $scope.total = "TOTAL: <?=$i;?>";
      $scope.completos = "COMPLETOS: <?=$completos;?>";
      $scope.alocados = "ALOCADOS: <?=$alocados;?>";
      $scope.porcento1 = (<?=$completos;?>/<?=$i;?>)*100;
      $scope.porcento2 = (<?=$alocados;?>/<?=$i;?>)*100;
      $scope.porcento1 = $scope.porcento1.toFixed(2);
      $scope.porcento2 = $scope.porcento2.toFixed(2);

      $scope.filtro2 = "";
      $scope.ordenar = function(x) {
      	if($scope.myOrderBy == x) x = "-"+x;
	    $scope.myOrderBy = x;
	  }

	  $scope.exibirBaixas = function () {
		    $scope.filtro2 = x.status != "Baixa";
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