<?php
require_once '..\bootstrap\bootstrap.php';


$klein->respond('GET','/', function() use ($twig, $crud){
	$getAll = $crud->getAll();
	echo $twig->render('home.twig', array(
		'getAll' => $getAll
	));
});

$klein->respond('GET','/[i:id]', function($request) use($twig, $crud){
	$getOne = $crud->getOne($request->id);
	echo $twig->render('getOne.twig', array(
		'getOne' => $getOne
	));
});

$klein->respond('POST','/', function() use ($crud){
	$crud->create();
});

$klein->dispatch();


