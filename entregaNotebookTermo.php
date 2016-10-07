<?php

date_default_timezone_set('America/Sao_Paulo');

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// Include the PHPWord.php, all other classes were loaded by an autoloader
require_once 'PHPWord.php';

// Create a new PHPWord Object
$PHPWord = new PHPWord();

// Every element you want to append to the word document is placed in a section. So you need a section:
$section = $PHPWord->createSection();

// After creating a section, you can append elements:
$section->addText('N° '.$_GET['codigoMovimento'].'/'.date("y"), array('name'=>'Tahoma', 'size'=>10, 'color'=>'999999'));

// You can directly style your text by giving the addText function an array:
$PHPWord->addParagraphStyle('centralizar', array('align'=>'center', 'spaceAfter'=>430, 'spaceBefore'=>430));
$section->addText('Termo de responsabilidade', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true), 'centralizar');

// If you often need the same style again you can create a user defined style to the word document
// and give the addText function the name of the style:


$PHPWord->addFontStyle('myOwnStyle', array('name'=>'Tahoma', 'size'=>11, 'color'=>'1B2232'));
$PHPWord->addFontStyle('myOwnStyleBold', array('name'=>'Tahoma', 'size'=>11, 'color'=>'1B2232', 'bold'=>true));

$textrun = $section->createTextRun();

$textrun->addText('Eu, ', 'myOwnStyle');
$textrun->addText($_GET['usuario'], 'myOwnStyleBold');
$textrun->addText(', matrícula ', 'myOwnStyle');
$textrun->addText($_GET['matricula'], 'myOwnStyleBold');
$textrun->addText(', assumo a responsabilidade pela guarda e conservação da estação móvel celular da marca ', 'myOwnStyle');
$textrun->addText($_GET['marca'], 'myOwnStyleBold');
$textrun->addText(', modelo ', 'myOwnStyle');
$textrun->addText($_GET['modelo'], 'myOwnStyleBold');
$textrun->addText(' de código PIN ', 'myOwnStyle');
$textrun->addText($_GET['pin'], 'myOwnStyleBold');
$textrun->addText(' e IMEI ', 'myOwnStyle');
$textrun->addText($_GET['imei'], 'myOwnStyleBold');
$textrun->addText(', código ', 'myOwnStyle');
$textrun->addText($_GET['codigoCelular'], 'myOwnStyleBold');
$textrun->addText('. Estou recebendo em comodato, nesta data, relativo ao convênio firmado entre a Claro S.A. e a Cooperativa Agropecuária Petrópolis Ltda., declarando que será de minha inteira responsabilidade o uso do celular, proibindo o empréstimo, aluguel ou cessão deste a terceiros, comprometendo-me a devolvê-lo em perfeitas condições de uso, considerando o desgaste natural pelo uso normal do equipamento.', 'myOwnStyle');



$section->addText('No caso de roubo, mau uso, negligência e/ou extravio, devo comunicar imediatamente o Telecom da empresa e, salvo mediante autorização da direção, ressarcir financeiramente à Cooperativa Agropecuária Petrópolis Ltda. no valor correspondente a um equipamento da mesma marca e modelo ou equivalente ao da praça.', 'myOwnStyle');



$PHPWord->addFontStyle('assinatura', array('name'=>'Tahoma', 'size'=>11, 'color'=>'999999'));
$PHPWord->addFontStyle('assinatura2', array('name'=>'Tahoma', 'size'=>11, 'color'=>'555555', 'bold'=>true));
$PHPWord->addFontStyle('assinatura3', array('name'=>'Tahoma', 'size'=>11, 'color'=>'777777'));
$PHPWord->addParagraphStyle('centralizar2', array('align'=>'center', 'spaceBefore'=>1600));
$PHPWord->addParagraphStyle('centralizar3', array('align'=>'center', 'spaceBefore'=>7));
$section->addText('________________________________________________________________', 'assinatura', 'centralizar2');
$section->addText($_GET['usuario'], 'assinatura2', 'centralizar3');
$section->addText('Matrícula '.$_GET['matricula'], 'assinatura3', 'centralizar3');



// Add footer
$footer = $section->createFooter();

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$PHPWord->addFontStyle('rodape', array('name'=>'Tahoma', 'size'=>11, 'color'=>'555555'));
$footer->addPreserveText('Nova Petrópolis, '.date('d').' de '.strftime('%B', strtotime('today')).' de '.date('Y').'.', 'rodape', array('align'=>'center'));

$nomeArquivo = "termos/celular-".date("Y-m-d H:i:s").".docx";
// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save($nomeArquivo);

header("location: ".$nomeArquivo);

?>