<?php
require_once('../init.php');

$res = $Customers->addCustomers();
if($res > 0){
	redirect('index.php?page=customers');
}


?>