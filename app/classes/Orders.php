<?php

/**
 *
 */
class Orders extends Objects {

	protected $pdo;

	// construct $pdo
	function __construct($pdo) {
		$this->pdo = $pdo;
	}

	
	/*-- create order --*/

	public function orderGenarate(){

		$lastOrderId = $this->total_count("orders");

		// $created_at = timestamp();
		// $query = array('c_id'=>'0', 'created_at' => $created_at);
		// $o_id = $this->create('orders',$query);
		$o_id = $lastOrderId+1;
		return $o_id;
	}

	/*-- create order end--*/

}
?>

