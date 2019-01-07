<?php

/**
 *
 */
class Customers extends Objects {

	protected $pdo;

	// construct $pdo
	function __construct($pdo) {
		$this->pdo = $pdo;
	}

	/*--create function--*/

	public  function addCustomersAjax(){
		if (isset($_POST['c_name'])) {
			$c_name = $this->escape($_POST['c_name']);
			$c_addr = $this->escape($_POST['c_addr']);
			$c_phn = $this->escape($_POST['c_phn']);
			$c_mail = $this->escape($_POST['c_mail']);

			$created_at = timestamp();

			$query =  array('c_name' =>$c_name , 'c_addr' => $c_addr, 'c_phn' => $c_phn , 'c_mail' => $c_mail,  'created_at' => $created_at);

			$res = $this->create('customers',$query);

			if($res > 0){
				$log = "added a customers from quick add";
				$sql = array("user_id"=>$_SESSION['user_id'],"log"=>$log,"created_at"=>$created_at);
				$this->create("logs",$sql);
			}

			return $this->find('customers','c_id',$res);
			//return $res;
		}
		else{
			echo "Something Wrong";
		}

	}


	public  function addCustomers(){
		if (isset($_POST['c_name'])) {
			$c_name = $this->escape($_POST['c_name']);
			$c_addr = $this->escape($_POST['c_addr']);
			$c_phn = $this->escape($_POST['c_phn']);
			$c_mail = $this->escape($_POST['c_mail']);

			$created_at = timestamp();

			$query =  array('c_name' =>$c_name , 'c_addr' => $c_addr, 'c_phn' => $c_phn , 'c_mail' => $c_mail,  'created_at' => $created_at);

			$res = $this->create('customers',$query);

			if($res > 0){
				$log = "added a customers from quick add";
				$sql = array("user_id"=>$_SESSION['user_id'],"log"=>$log,"created_at"=>$created_at);
				$this->create("logs",$sql);
			}
			return $res;
		}
		else{
			echo "Something Wrong";
		}

	}

}

?>