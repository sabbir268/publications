<?php

/**
 *
 */
class Authors extends Objects {

	protected $pdo;

	// construct $pdo
	function __construct($pdo) {
		$this->pdo = $pdo;
	}

	/*--create authors function--*/

	public  function addAuthors(){
		if (isset($_POST['submit_auth_form'])) {
			$a_name = $this->escape($_POST['a_name']);
			$a_phn = $this->escape($_POST['a_phn']);
			$a_addr = $this->escape($_POST['a_addr']);
			$created_at = timestamp();


			$query =  array('a_name' =>$a_name , 'a_phn' => $a_phn, 'a_addr' => $a_addr, 'created_at' => $created_at);

			$res = $this->create('authors',$query);

			if($res > 0){
				$log = "added a authors";
				$sql = array("user_id"=>$_SESSION['user_id'],"log"=>$log,"created_at"=>$created_at);
				$this->create("logs",$sql);

				redirect('index.php?page=authors');
			}
		}
	}
	/*-- .. create function end --*/


	public function authorsRMPay(){
		if (isset($_POST['submit_arm_pay_form'])) {
			$a_id = $_POST['a_id'];
			$arm_pay_am = $_POST['arm_pay_am'];
			$pay_date = $_POST['pay_date'];
			$remarks = $_POST['remarks'];
			$updated_at = timestamp();
			echo $query = "UPDATE  author_rm  SET  arm_paid_am = $arm_pay_am, arm_pay_date = '$pay_date', remarks ='$remarks', updated_at = '$updated_at' WHERE arm_id = last_arm_id($a_id)";

			$stmt = $this->pdo->prepare($query);
			$res = $stmt->execute();
			if($res){
				$log = "make a payment to authors";
				$sql = array("user_id"=>$_SESSION['user_id'],"log"=>$log,"created_at"=>$created_at);
				$this->create("logs",$sql);

				redirect('index.php?page=authorsrm');
			}
		}
	}


}


?>

