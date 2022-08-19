<?php
	require_once './vendor/autoload.php';

	use Laminas\Soap\Server;
	function EcuP($x1, $y1, $x2, $y2){
		$M = ($y2 - $y1)/($x2 - $x1);
		$Ma = (-1)/$M;
		return array ($M, $Ma);
	}
	function EcuL($Bx1, $By1, $m){
		$a = $m * -1;
		$b = 1;
		$c = ($a * ($Bx1))+$By1;
		return array ($a, $b, $c);
	}
	function S2Ecu($a, $b, $c, $d, $e, $f){
		$Y = ($f - (($d*$c)/$a))/(((-$d*$b)/$a)+$e);
		$X = ($c-($b*$Y))/$a;
		return array ($X, $Y);
	}
	function dist($punto1, $punto2){
		return round($lado1 = sqrt( pow($punto1->x-$punto2->x, 2) + pow($punto1->y-$punto2->y, 2) ),2); // de P1 a P2
	}
	$ac = array('uri' => "http://localhost/Aldair/triangulos/"); 
	$server = new Server(null, $ac);
	$server->addFunction("EcuP");
	$server->addFunction("EcuL");
	$server->addFunction("S2Ecu");
	$server->addFunction("dist");
	$server->handle();
?>