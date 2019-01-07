<?php

/**
 *
 */
class Editions extends Objects {

	protected $pdo;

	// construct $pdo
	function __construct($pdo) {
		$this->pdo = $pdo;
	}

	public function totalEdition($b_id){
		$res = $this->find('editions','b_id',$b_id);

		 return $res->ttl_edition;
	}

	/*--create function--*/

	public  function addEditions(){
		if (isset($_POST['submit_printig_form'])) {
			$b_id = $this->escape($_POST['b_id']);

			$p_id = $this->escape($_POST['p_id']);

			$pr_date = $this->escape($_POST['pr_date']);
			$p_name = $this->escape($_POST['p_name']);
			$p_addr = $this->escape($_POST['p_addr']);

			$ttl_copy = $this->escape($_POST['ttl_copy']);
			$pr_cost = $this->escape($_POST['pr_cost']);
			$b_price = $this->escape($_POST['b_price']);

			$total_cost = ($ttl_copy*$pr_cost);
			$total_price = ($ttl_copy*$b_price);

			$auth = $_POST['auth'];
			$arm_am = $_POST['arm_am'];

			$created_at = timestamp();
			
			/*--if new printer added--*/
			if(!isset($p_id) OR empty($p_id)){
				$query =  array('p_name' =>$p_name , 'p_addr' => $p_addr, 'created_at' => $created_at);
				$res = $this->create('printers',$query);

				$p_id = $res;
			}else{
				$p_id = $this->escape($_POST['p_id']);
			}
			/*--if new printer add end--*/

			$ttl_edition = $this->totalEdition($b_id) + 1; // count editions

			$query =  array('b_id' =>$b_id , 'p_id' => $p_id, 'pr_date' => $pr_date, 'ttl_copy' => $ttl_copy , 'pr_cost' => $pr_cost , 'b_price' => $b_price ,  'ttl_edition' => $ttl_edition , 'created_at' => $created_at);
			
			$res = $this->create('editions',$query);


			/*-- author respect money genarate --*/
			$tAuth = count($auth);
			if( $tAuth > 0 ){
				for($i=0; $i < $tAuth ; $i++){
					$authId = $this->escape($auth[$i]);
					$authRMper = $this->escape($arm_am[$i]);
					//$totalRmam = (($total_price*$authRMper)/100);
					$query1 =  array('a_id' =>$authId , 'e_id' => $res, 'allot_per'=>$authRMper,'allot_date' => $pr_date , 'created_at' => $created_at);
					$res1 = $this->create('author_rm',$query1);
				}
			}
			/*-- author respect money genarate end --*/

			if($res > 0){
				$log = "made a editions";
				$sql = array("user_id"=>$_SESSION['user_id'],"log"=>$log,"created_at"=>$created_at);
				$this->create("logs",$sql);

				redirect('index.php?page=books');
			}
		}
	}
	/*-- .. create function --*/
}


?>

