<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Source\Support\QrcodeGerate;

/** @var stdClass */
$urlDoc = url("verifica/documento/{$memo->id}");

(new QrcodeGerate($urlDoc));
$urlqrCode = __DIR__. "/../../../tmp/qrcode.png";;

$options = new Options(["isPhpEnabled" => true]);
$dompdf = new Dompdf($options);
ob_start();
require __DIR__ . "/../../../contents/documento.php";
$php = ob_get_clean();

//echo $php;
//die;
$numeroDoc = ($memo->numeroDoc !== "xxxx") ? zeroEsquerda($memo->numeroDoc) : $memo->numeroDoc;
$nomeArquivo = "{$tipoDoc->nomeTipoDoc} Nº {$numeroDoc}-{$memo->assuntoDoc}";
$nomeArquivo = str_replace("/","-",$nomeArquivo);

$dompdf->loadHtml($php);
$dompdf->setPaper("A4");
$dompdf->render();
$canvas = $dompdf->getCanvas();
$canvas->page_text(260, 782, "Página: {PAGE_NUM} de {PAGE_COUNT}", "", 8, array(0,0,0));
$dompdf->stream($nomeArquivo, ["Attachment" => false]);
