<?php

$m['subject'] = 'Help Desk Teste';	
	//$m['to'] = $row["email"].'@pia.com.br; '.$rowAtr['name'].'@pia.com.br';
	$m['to'] = 'gean.spiering@pia.com.br; thiago.santos@pia.com.br';
	
	$m['message'] = 'E aí, beleza?!';
	
	$m['headers'] = implode("\r\n",array(
							'From: Laura Anschau <laura.anschau@pia.com.br>',
							'Reply-To: Laura Anschau <laura.anschau@pia.com.br>',
							'Mime-Version: 1.0',
							'Content-Type: text/html; charset=utf-8',
							'Priority: normal',
							'X-Mailer: PHP/'.phpversion(),
							'X-Priority: 3'));;
	
		if(mail($m['to'],$m['subject'],$m['message'],$m['headers'])) echo "<p>Seu email foi enviado com sucesso!</p>";
		else echo "Não foi.";