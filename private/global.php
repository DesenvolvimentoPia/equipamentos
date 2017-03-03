<?php

//echo "AQUI: ".$_POST['usu'];

include "../../sisti/conexao.php";

?>

<div id='buscaDinamica'>
	
<?php 
$sql = "SELECT a.*, b.nome as nomeTipo, c.nome as nomeMarca FROM relatorios_equipamentos a

LEFT JOIN relatorios_tipos b ON 
a.tipo = b.id

LEFT JOIN relatorios_listas c ON 
a.marca = c.id

WHERE 
a.id LIKE '%".$_POST['usu']."%' OR 
a.modelo LIKE '%".$_POST['usu']."%' OR
c.nome LIKE '%".$_POST['usu']."%' OR
a.patrimonio LIKE '%".$_POST['usu']."%' OR 
a.tag LIKE '%".$_POST['usu']."%' OR 
a.nomeRede LIKE '%".$_POST['usu']."%' OR 
a.status LIKE '%".$_POST['usu']."%' ORDER BY id DESC";
$res = sqlsrv_query($con, $sql);
$has = sqlsrv_has_rows($res);

if(!$has) echo "<div class='semResultados'>Nenhum Resultado Encontrado!</div>";
$i = 0;
while($row = sqlsrv_fetch_array($res)) { if($i < 16) { $i++; ?>
<div class='resultadosDinamicos' data-cod='<?=$row['id']?>' data-nome='<?=$row['id']?> - <?=$row['nomeTipo']?> <?=$row['nomeMarca']?> - <?=$row['modelo']?> - <?=$row['patrimonio']?>'><?=$row['id']?> - <?=$row['nomeTipo']?> <?=$row['nomeMarca']?> - <b>Modelo:</b> <?=$row['modelo']?> - <b>Patrimônio:</b> <?=$row['patrimonio']?></div>
<?php  } } ?>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script>

$(function() {

	$('.resultadosDinamicos').click(function(){
		//alert("AQUI");
		document.getElementById('buscaGlobalOculto').value = this.dataset.cod;
		document.getElementById('buscaGlobal').value = this.dataset.nome;

		$("#equipamentoDinamico").html('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
		
		$.ajax({
          url: "./equipamento.php?id="+this.dataset.cod
        }).done(function(data) { // data what is sent back by the php page
          setTimeout(function() { $('#equipamentoDinamico').html(data); }, 700);
        });
		$("#resultadoAjax2").fadeOut();
	});

});

</script>