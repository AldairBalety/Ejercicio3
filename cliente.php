<?php
	header("Content-Type: image/png");
	require_once 'vendor/autoload.php';
	require_once 'Punto.php';
	use Laminas\Soap\Client;
	
	$url = "http://localhost/Aldair/triangulos/servidor.php";
	
	$ac = array(
		'location' => $url,
		'uri' => "http://localhost/Aldair/triangulos/"
	);
	$cliente = new Client(null, $ac);

	$p1x = 300; $p1y = 100;//punta arriba B
	$p2x= 10; $p2y= 400;//punta izquierda A
	$p3x = 1200; $p3y = 450;//punta derecha C

	$ancho = 800;
	$alto = 1200;

	$img = imagecreate($alto, $ancho);
	
	$blanco = imagecolorallocate($img, 255, 255, 255);
	imagefilledrectangle($img, 0, 0, $ancho, $alto, $blanco);
	$negro = imagecolorallocate($img, 0, 0, 0);
	$rojo = imagecolorallocate($img, 255, 0, 0);
	$verde = imagecolorallocate($img, 0, 128, 0);
	
	$p1 = new Punto($p1x, $p1y);
	$p2 = new Punto($p2x, $p2y);
	$p3 = new Punto($p3x, $p3y);

	$arrptos = array(
		$p1x, $p1y,
		$p2x, $p2y,
		$p3x, $p3y,
	);
	imagepolygon($img, $arrptos, 3, $negro);

	$EP = $cliente->EcuP($p2x, $p2y, $p3x ,$p3y);
	$EL1 = $cliente->EcuL($p1x, $p1y, $EP[1]);
	$EL2 = $cliente->EcuL($p2x, $p2y, $EP[0]);	
	$E = $cliente->S2Ecu($EL1[0], $EL1[1], $EL1[2], $EL2[0], $EL2[1], $EL2[2]);
	$ph = new Punto($E[0], $E[1]);

	imagestring($img, 3, ($p1->x+$E[0])/2, ($p1->y+$E[1])/2, "L3=" . $cliente->dist($p1,$ph), $negro);
	imagestring($img, 3, ($p1->x+$p2->x)/2, ($p1->y+$p2->y)/2, "L3=" . $cliente->dist($p1,$ph), $negro);
	imagestring($img, 3, ($p1->x+$p3->x)/2, ($p1->y+$p3->y)/2, "L3=" . $cliente->dist($p1,$ph), $negro);
	imagestring($img, 3, ($p2->x+$p3->x)/2, ($p2->y+$p3->y)/2, "L3=" . $cliente->dist($p1,$ph), $negro);

	imageline($img, $p1->x, $p1->y, $ph->x,$ph->y, $verde);
	imagepng($img);
	imagedestroy($img);
	
?>
