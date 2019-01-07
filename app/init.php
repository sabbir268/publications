<?php
require_once('config/config.php');


// including the classes
require_once 'database/connection.php';
require_once 'classes/Object.php';
require_once 'classes/User.php';

require_once 'classes/Books.php';
require_once 'classes/Editions.php';
require_once 'classes/Authors.php';
require_once 'classes/Orders.php';
require_once 'classes/Customers.php';



//include the function
require_once 'functions.php';



// makeing global objects
global $pdo;
session_start();
$obj = new Objects($pdo);
$userO = new User($pdo);
$Authors = new Authors($pdo);
$Books = new Books($pdo);
$Editions = new Editions($pdo);
$Orders = new Orders($pdo);
$Customers = new Customers($pdo);




?>
