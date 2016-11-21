<h1>EQUIPAMENTOS ALMOX TI</h1>


<?php 

$sql = "SELECT * FROM relatorios_tipos WHERE tipo = '1' ORDER BY id";
//echo $sql;
$res = sqlsrv_query($con, $sql);

while($row = sqlsrv_fetch_array($res)) {

?><a class="subMenu<?php if(!empty($_POST['hiddenEquipamentoTipo']) && $_POST['hiddenEquipamentoTipo'] == $row['id']) echo ' selecionado';?>" data-cod="<?=$row['id']?>"><?=$row['nome']?></a><?php } ?>

<div id="almoxDinamico"></div>



<script type="text/javascript" language="javascript">
    $(function() {

    $(".subMenu").click(function() {
        	
		var elementos = document.getElementsByClassName('subMenu');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "subMenu";
		}

		this.className = "subMenu selecionado"; 

        	var ultimo = this.dataset.cod;

            $("#almoxDinamico").html('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');

            // Faz requisição ajax e envia o ID da Categoria via método POST
            $.post("dinamicos/almox.php", {ultimo: ultimo}, function(resposta) {

               // Coloca a resposta na DIV
               setTimeout(function() { $("#almoxDinamico").html(resposta); }, 700);
           
            });
        });
    });
</script>