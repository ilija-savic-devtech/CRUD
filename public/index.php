<?php
require_once '..\bootstrap\bootstrap.php';


$klein->respond('/', function() use ($twig, $crud){
	$getAll = $crud->getAll();
	echo $twig->render('home.twig', array(
		'getAll' => $getAll
	));
});


$klein->dispatch();


