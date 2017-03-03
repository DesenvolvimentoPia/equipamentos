
<input name="buscaGlobalOculto" id="buscaGlobalOculto" type="hidden">
<input name="buscaGlobal" id="buscaGlobal" placeholder="Busca Global" onkeyup="checkPesquisa2()" onblur="fechaDinamico2()">
<div id="resultadoAjax2"></div>

<h1>EQUIPAMENTOS</h1>


<?php 

$sql = "SELECT * FROM relatorios_tipos WHERE tipo = '1' ORDER BY id";
//echo $sql;
$res = sqlsrv_query($con, $sql);

while($row = sqlsrv_fetch_array($res)) {

?><a class="subMenu<?php if(!empty($_POST['hiddenEquipamentoTipo']) && $_POST['hiddenEquipamentoTipo'] == $row['id']) echo ' selecionado';?>" data-cod="<?=$row['id']?>"><?=$row['nome']?></a><?php } ?>

<div id="equipamentoDinamico"></div>



<script type="text/javascript" language="javascript">
    $(function() {

        <?php if(!empty($_POST['hiddenEquipamento'])) { ?>

        $.ajax({
          url: "equipamento.php?id=<?=$_POST['hiddenEquipamento']?>"
        }).done(function(data) { // data what is sent back by the php page
          $('#equipamentoDinamico').html(data); // display data
        });

        <?php } ?>

        $(".subMenu").click(function() {
        	
		var elementos = document.getElementsByClassName('subMenu');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "subMenu";
		}

		this.className = "subMenu selecionado"; 

        	var ultimo = this.dataset.cod;

            $("#equipamentoDinamico").html('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');

            // Faz requisição ajax e envia o ID da Categoria via método POST
            $.post("dinamicos/equipamentos.php", {ultimo: ultimo}, function(resposta) {

               // Coloca a resposta na DIV
               setTimeout(function() { $("#equipamentoDinamico").html(resposta); }, 700);
           
            });
        });
    });




var botaoPesquisa2;

function checkPesquisa2() {
  if(botaoPesquisa2 != document.getElementById("buscaGlobal").value) {
      botaoPesquisa2 = document.getElementById("buscaGlobal").value;

    if(botaoPesquisa2.length > 2) {
          
          $("#resultadoAjax2").fadeIn();
          $("#resultadoAjax2").html('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');

                  // Faz requisição ajax e envia o ID da Categoria via método POST
              $.post("private/global.php", {usu: botaoPesquisa2}, function(resposta) {

                 // Coloca a resposta na DIV
                 setTimeout(function() { $("#resultadoAjax2").html(resposta); }, 700);
             
              });

      }

      if(botaoPesquisa2.length <= 2) $("#resultadoAjax2").fadeOut();
  }
}

function fechaDinamico2() {
  $("#resultadoAjax2").fadeOut(); 
  setTimeout(function() { if (document.getElementById('buscaGlobalOculto').value == '') document.getElementById('buscaGlobal').value = ''; }, 350);
}

</script>