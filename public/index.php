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

$klein->respond('PUT', '/[i:id]', function($request) use ($crud){
	parse_str(file_get_contents("php://input"),$put_vars);
	$crud->update($request->id, $put_vars);
});

$klein->dispatch();


