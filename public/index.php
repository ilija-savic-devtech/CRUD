<?php
require_once '..\bootstrap\bootstrap.php';
echo "Hello";
$database = new \database\CrudDatabaseMongoDb(new \database\MongoDbConnection());


$database->getAll();