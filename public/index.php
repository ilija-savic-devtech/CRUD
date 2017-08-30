<?php
require_once '..\bootstrap\bootstrap.php';


$klein->respond('/', function() use ($twig, $crud){
	$getAll = $crud->getAll();
	if($getAll == null){
		throw new \exceptions\EmptyTableException();
	}
	echo $twig->render('home.twig', array(
		'getAll' => $getAll
	));
});

$klein->respond('/[i:id]', function($request) use($twig, $crud){
	$getOne = $crud->getOne($request->id);
	if ($getOne->getId() == null) {
		throw new \exceptions\InvalidIdException();
	}
	echo $twig->render('getOne.twig', array(
		'getOne' => $getOne
	));
});


$klein->dispatch();


