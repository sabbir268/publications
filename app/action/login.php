<?php

require_once('../init.php');
if (isset($_POST['username'])) {
	$username = $obj->escape($_POST['username']);
	$password = $obj->escape($_POST['password']);
	$userO->login($username,$password);
}




 ?>
