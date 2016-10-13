<h1>LISTAS SUSPENSAS</h1>


<?php 

$sql = "SELECT * FROM relatorios_tipos WHERE tipo = '3' ORDER BY id";
//echo $sql;
$res = sqlsrv_query($con, $sql);

while($row = sqlsrv_fetch_array($res)) {

?><a class="subMenu3" data-cod="<?=$row['id']?>"><?=$row['nome']?></a><?php } ?>

<div id="listaDinamico"></div>




<script type="text/javascript" language="javascript">
    $(function() {

        $(".subMenu3").click(function() {

		var elementos = document.getElementsByClassName('subMenu3');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "subMenu3";
		}

		this.className = "subMenu3 selecionado";        	

        	var ultimo = this.dataset.cod;

            $("#listaDinamico").html('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');

            // Faz requisição ajax e envia o ID da Categoria via método POST
            $.post("dinamicos/listas.php", {ultimo: ultimo}, function(resposta) {

               // Coloca a resposta na DIV
              setTimeout(function() { $("#listaDinamico").html(resposta); }, 700);
           
            });
        });
    });
</script>