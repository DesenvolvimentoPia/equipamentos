<p>Olá, <strong><?=$_SESSION['nome']?></strong>. Use o Menu Superior para Navegar.</p>


<div style="text-align: center;">

<div class="divHome">
	<div class="tituloHome">Monitores</div>
	<div class="totalHome"><?php
		$sql = "SELECT tipo, count(*) as qtd FROM relatorios_equipamentos WHERE tipo = '2' GROUP BY tipo ORDER BY tipo";
		//echo $sql;
		$res2 = sqlsrv_query($con, $sql);
		$row2 = sqlsrv_fetch_array($res2);
		echo $row2['qtd'];
	?></div>
</div><div class="divHome">
	<div class="tituloHome">Desktops</div>	
	<div class="totalHome"><?php
		$sql = "SELECT tipo, count(*) as qtd FROM relatorios_equipamentos WHERE tipo = '1' GROUP BY tipo ORDER BY tipo";
		//echo $sql;
		$res2 = sqlsrv_query($con, $sql);
		$row2 = sqlsrv_fetch_array($res2);
		echo $row2['qtd'];
	?></div>
</div><div class="divHome">
	<div class="tituloHome">Notebooks</div>	
	<div class="totalHome"><?php
		$sql = "SELECT tipo, count(*) as qtd FROM relatorios_equipamentos WHERE tipo = '3' GROUP BY tipo ORDER BY tipo";
		//echo $sql;
		$res2 = sqlsrv_query($con, $sql);
		$row2 = sqlsrv_fetch_array($res2);
		echo $row2['qtd'];
	?></div>
</div><div class="divHome">
	<div class="tituloHome">Thin Clients</div>	
	<div class="totalHome"><?php
		$sql = "SELECT tipo, count(*) as qtd FROM relatorios_equipamentos WHERE tipo = '4' GROUP BY tipo ORDER BY tipo";
		//echo $sql;
		$res2 = sqlsrv_query($con, $sql);
		$row2 = sqlsrv_fetch_array($res2);
		echo $row2['qtd'];
	?></div>
</div><div class="divHome">
	<div class="tituloHome">Total</div>	
	<div class="totalHome"><?php
		$sql = "SELECT disponivel, count(*) as qtd FROM relatorios_equipamentos WHERE disponivel = '1' GROUP BY disponivel ORDER BY disponivel";
		//echo $sql;
		$res2 = sqlsrv_query($con, $sql);
		$row2 = sqlsrv_fetch_array($res2);
		echo $row2['qtd'];
	?></div>
</div>


<script src="charts/node_modules/chart.js/dist/Chart.bundle.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

 <div class="holderCanvas" id="canvas-holder">
 <h3>Equipamentos por Tipo</h3>
        <div style="width: 70%; margin-left: 15%; opacity: 0.79"><canvas id="chart-area" width="300" height="300" /></div>
    </div>
   
    <script>
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };
    var randomColorFactor = function() {
        return Math.round(Math.random() * 255);
    };
    var randomColor = function(opacity) {
        return 'rgba(' + randomScalingFactor() + ',' + randomScalingFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
    };

    var cor = ["#DD7932", "#CC7016", "#DDAA23", "#EC7B16", "#BB9a25", "#CC7707", "#ECa832", "#BB9952", "#ee9932", "#cc9952", "#be8a52", "#f07a53", "#DC8a23", "#AA8a23", "#cCAA23", "#Fe7016", "#AAA032", "#AB5234", "#ce8a23"];

    var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    <?php 

              $sql = "SELECT * FROM relatorios_tipos WHERE tipo = '1' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
             $sql = "SELECT tipo, count(*) as qtd FROM relatorios_equipamentos WHERE tipo = '".$row['id']."' GROUP BY tipo ORDER BY tipo";
			//echo $sql;
			$res2 = sqlsrv_query($con, $sql);
			$row2 = sqlsrv_fetch_array($res2);
			
				if($i == 0) {?>"<?=$row2['qtd']?>"<?php }
				else { ?>, "<?=$row2['qtd']?>"<?php } $i++; } ?>
                ],
                backgroundColor: [
                    <?php 

              $sql = "SELECT * FROM relatorios_tipos WHERE tipo = '1' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
             $sql = "SELECT tipo, count(*) as qtd FROM relatorios_equipamentos WHERE tipo = '".$row['id']."' GROUP BY tipo ORDER BY tipo";
			//echo $sql;
			$res2 = sqlsrv_query($con, $sql);
			$row2 = sqlsrv_fetch_array($res2);
			
				if($i == 0) {?>cor[<?=$i?>]<?php }
				else { ?>, cor[<?=$i?>]<?php } $i++; } ?>
				

                ],
            }],
            labels: [
             <?php 
             $sql = "SELECT * FROM relatorios_tipos WHERE tipo = '1' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
				if($i == 0) {?>"<?=$row['nome']?>"<?php }
				else { ?>, "<?=$row['nome']?>"<?php } $i++; } ?>
            ]
        },
        options: {
        legend: {
            display: false
        },
            responsive: true,
            header: false
        }
    };


    </script>










<div class="holderCanvas" id="canvas-holder2">
 <h3>Equipamentos por Fornecedor</h3>
        <div style="width: 70%; margin-left: 15%; opacity: 0.79"><canvas id="chart-area2" width="300" height="300" /></div>
    </div>
   
    <script>

    var config2 = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    <?php 

              $sql = "SELECT * FROM relatorios_listas WHERE tipo = '17' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
             $sql = "SELECT fornecedor, count(*) as qtd FROM relatorios_equipamentos WHERE fornecedor = '".$row['id']."' GROUP BY fornecedor ORDER BY fornecedor";
			//echo $sql;
			$res2 = sqlsrv_query($con, $sql);
			$row2 = sqlsrv_fetch_array($res2);
			
				if($i == 0) {?>"<?=$row2['qtd']?>"<?php }
				else { ?>, "<?=$row2['qtd']?>"<?php } $i++; } ?>
                ],
                backgroundColor: [
                    <?php 

              $sql = "SELECT * FROM relatorios_listas WHERE tipo = '17' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
             $sql = "SELECT fornecedor, count(*) as qtd FROM relatorios_equipamentos WHERE fornecedor = '".$row['id']."' GROUP BY fornecedor ORDER BY fornecedor";
			//echo $sql;
			$res2 = sqlsrv_query($con, $sql);
			$row2 = sqlsrv_fetch_array($res2);
			
				if($i == 0) {?>cor[<?=$i?>]<?php }
				else { ?>, cor[<?=$i?>]<?php } $i++; } ?>
				

                ],
            }],
            labels: [
             <?php 
             $sql = "SELECT * FROM relatorios_listas WHERE tipo = '17' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
				if($i == 0) {?>"<?=$row['nome']?>"<?php }
				else { ?>, "<?=$row['nome']?>"<?php } $i++; } ?>
            ]
        },
        options: {
        legend: {
            display: false
        },
            responsive: true,
            header: false
        }
    };

    </script>










<div class="holderCanvas" id="canvas-holder3">
 <h3>Equipamentos por Marca</h3>
        <div style="width: 70%; margin-left: 15%; opacity: 0.79"><canvas id="chart-area3" width="300" height="300" /></div>
    </div>
   
    <script>

    var config3 = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    <?php 

              $sql = "SELECT * FROM relatorios_listas WHERE tipo = '18' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
             $sql = "SELECT marca, count(*) as qtd FROM relatorios_equipamentos WHERE marca = '".$row['id']."' GROUP BY marca ORDER BY marca";
			//echo $sql;
			$res2 = sqlsrv_query($con, $sql);
			$row2 = sqlsrv_fetch_array($res2);
			
				if($i == 0) {?>"<?=$row2['qtd']?>"<?php }
				else { ?>, "<?=$row2['qtd']?>"<?php } $i++; } ?>
                ],
                backgroundColor: [
                    <?php 

              $sql = "SELECT * FROM relatorios_listas WHERE tipo = '18' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
             $sql = "SELECT marca, count(*) as qtd FROM relatorios_equipamentos WHERE marca = '".$row['id']."' GROUP BY marca ORDER BY marca";
			//echo $sql;
			$res2 = sqlsrv_query($con, $sql);
			$row2 = sqlsrv_fetch_array($res2);
			
				if($i == 0) {?>cor[<?=$i?>]<?php }
				else { ?>, cor[<?=$i?>]<?php } $i++; } ?>
				

                ],
            }],
            labels: [
             <?php 
             $sql = "SELECT * FROM relatorios_listas WHERE tipo = '18' ORDER BY id";
			//echo $sql;
			$res = sqlsrv_query($con, $sql);
			$i = 0;
			while($row = sqlsrv_fetch_array($res)) {
				if($i == 0) {?>"<?=$row['nome']?>"<?php }
				else { ?>, "<?=$row['nome']?>"<?php } $i++; } ?>
            ]
        },
        options: {
        legend: {
            display: false
        },
            responsive: true,
            header: false
        }
    };

    window.onload = function() {

        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx, config);

        var ctx2 = document.getElementById("chart-area2").getContext("2d");
        window.myPie = new Chart(ctx2, config2);

        var ctx3 = document.getElementById("chart-area3").getContext("2d");
        window.myPie = new Chart(ctx3, config3);
    };

    </script>
 

<div class="holderCanvas" id="canvas-holder4">
 <h3>Últimos Equipamentos</h3>
    <div style="width: 90%; margin-left: 5%; opacity: 0.88">
    <div class='tituloUltimosEquipamentos'>
    <div class="coluna">ID</div><div class="coluna">Tipo</div><div class="coluna">Marca</div>
    </div><?php
    	$sql = "SELECT TOP (8) relatorios_equipamentos.*, a.nome AS nomeMarca, b.nome AS nomeTipo FROM relatorios_equipamentos LEFT JOIN relatorios_listas a ON relatorios_equipamentos.marca = a.id AND a.tipo = 18 LEFT JOIN relatorios_tipos b ON relatorios_equipamentos.tipo = b.id WHERE relatorios_equipamentos.disponivel = '1' ORDER BY relatorios_equipamentos.id DESC";
		$res = sqlsrv_query($con, $sql);

		$i = 0;
		 while($row = sqlsrv_fetch_array($res)) {
    ?><div class='ultimosEquipamentos'>
    <div class="coluna"><?php echo $row['id'];?></div><div class="coluna"><?php echo $row['nomeTipo'];?></div><div class="coluna"><?php echo $row['nomeMarca'];?></div>
    </div><?php $i++; } ?>
    </div>
 </div>










 </div>