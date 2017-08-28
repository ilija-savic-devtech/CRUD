<?php
require_once '..\bootstrap\bootstrap.php';


$klein->respond('/', function() use ($base, $twig){
	$getAll = $base->getAll();
	echo $twig->render('home.twig', array(
		'getAll' => $getAll
	));
});


$klein->dispatch();


