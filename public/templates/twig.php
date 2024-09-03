<?php 

	ini_set('display_errors',1); # uncomment if you need debugging

	require_once $_SERVER['DOCUMENT_ROOT'].'/libs/twig/vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('../admin/templates');

	$twig = new \Twig\Environment($loader, [
	    'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache',
	]);

	echo $twig->render('main.php');

	
?>