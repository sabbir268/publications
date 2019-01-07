<?php
require_once('../init.php');
$o_id = $Orders->orderGenarate();
if ($o_id) {
	session_start();
	$_SESSION['o_id'] = $o_id;
	$orderIdex = $obj->find('orders','o_id',$o_id);
	if(!$orderIdex){

		$queryOrder = array('o_id' =>$o_id , 'order_date' => date('Y-m-d') , 'created_at' => $created_at );

		$resOrder = $obj->create('orders',$queryOrder);  

		redirect('index.php?page=sell');
	}
	
}
?>
