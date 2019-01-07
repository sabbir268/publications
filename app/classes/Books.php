<?php

/**
 *
 */
class Books extends Objects {

	protected $pdo;

	// construct $pdo
	function __construct($pdo) {
		$this->pdo = $pdo;
	}

	/*--create function--*/

	public  function addBooks(){
		if (isset($_POST['submit_book_form'])) {
			$b_name = $this->escape($_POST['b_name']);
			$b_isbn = $this->escape($_POST['b_isbn']);
			$b_auth = $_POST['b_auth'];
			$created_at = timestamp();

			$query =  array('b_name' =>$b_name , 'b_isbn' => $b_isbn, 'created_at' => $created_at);
			$res = $this->create('books',$query);

			$bookId = $this->insertId();

			$tAuth = count($b_auth);
			if( $tAuth > 0 ){
				for($i=0; $i < $tAuth ; $i++){
					$authId = $this->escape($b_auth[$i]);
					$query1 =  array('b_id' =>$bookId , 'a_id' => $authId, 'created_at' => $created_at);
					 
					$res1 = $this->create('book_auth',$query1);
				}
			}


			if($res > 0){
				$log = "added a book";
				$sql = array("user_id"=>$_SESSION['user_id'],"log"=>$log,"created_at"=>$created_at);
				$this->create("logs",$sql);

				redirect('index.php?page=books');
			}
	}
	
}

}

?>