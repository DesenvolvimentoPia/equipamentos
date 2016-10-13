<h1>LICENÇAS</h1>


<?php 

$sql = "SELECT * FROM relatorios_tipos WHERE tipo = '2' ORDER BY id";
//echo $sql;
$res = sqlsrv_query($con, $sql);

while($row = sqlsrv_fetch_array($res)) {

?><a class="subMenu2" data-cod="<?=$row['id']?>"><?=$row['nome']?></a><?php } ?>

<div id="licensaDinamico"></div>




<script type="text/javascript" language="javascript">
    $(function() {

        $(".subMenu2").click(function() {

		var elementos = document.getElementsByClassName('subMenu2');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "subMenu2";
		}

		this.className = "subMenu2 selecionado";        	

        	var ultimo = this.dataset.cod;

            $("#licensaDinamico").html('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');

            // Faz requisição ajax e envia o ID da Categoria via método POST
            $.post("dinamicos/licensas.php", {ultimo: ultimo}, function(resposta) {

               // Coloca a resposta na DIV
              setTimeout(function() { $("#licensaDinamico").html(resposta); }, 700);
           
            });
        });
    });
</script>