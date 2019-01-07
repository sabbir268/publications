<?php

/**
 * the user class
 */
class Objects {
	protected $pdo;

	// construct $pdo
	function __construct($pdo) {
		$this->pdo = $pdo;
	}

	// prevent sql injection
	public function escape($var) {
		$var = trim($var);
		$var = htmlspecialchars($var);
		$var = stripcslashes($var);
		return $var;
	}

	public function query($sql,$state) {
		$stmt = $this->pdo->prepare($sql);
		
		if ($stmt->execute()) {
			if ($state == "one") {
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			elseif ($state == "all") {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else{
				return "Only 'one' and 'all' is allowed ";
			}
		}
		else{
			$err = $stmt->errorInfo();
			return end($err);
		}

	}


	public function create($table, $fields = array()) {
		$columns = implode(',', array_keys($fields));
		$values = ":" . implode(', :', array_keys($fields));
		$sql = "INSERT INTO {$table}({$columns}) VALUES($values)";

		if ($stmt = $this->pdo->prepare($sql)) {
			foreach ($fields as $key => $data) {
				$stmt->bindValue(":" . $key, $data);
			}

			if ($stmt->execute()) {
				return $this->pdo->lastInsertId();
			}
			else{
				$err = $stmt->errorInfo();
				return end($err);
			}
		}
	}


	public function procedure($procName, $fields = array()) {
		$values = implode(',',$fields);
		return $sql = "CALL $procName ($values, @p_msg)";

		// if ($stmt = $this->pdo->prepare($sql)) {
		// 	if($stmt->execute()){
		// 		$msgStmt = $this->pdo->prepare("SELECT @p_msg AS 'msg' ");
		// 		$msgStmt->execute();
		// 		$msg = $msgStmt->fetch(PDO::FETCH_OBJ);

		// 		return $msg->msg;
		// 	}
		// }
	}

	public function update($table, $colum_name, $id, $fields = array()) {
		$columns = '';

		$i = 1;
		foreach ($fields as $name => $value) {
			$columns .= "{$name} = :{$name}";
			if ($i < count($fields)) {
				$columns .= ', ';
			}
			$i++;
		}

		$sql = "UPDATE {$table} SET {$columns} WHERE {$colum_name} = {$id}";
		if ($stmt = $this->pdo->prepare($sql)) {
			foreach ($fields as $key => $value) {
				$stmt->bindValue(":" . $key, $value);
			}
			$stmt->execute();
			return $stmt->rowCount();
		}

	} // end of update

	public function delete($table, $array) {
		$sql = "DELETE FROM {$table}";
		$where = " WHERE ";
		foreach ($array as $key => $value) {
		 $sql .= "{$where} {$key} = :{$key}";
			$where = " AND ";
		}

		if ($stmt = $this->pdo->prepare($sql)) {
			foreach ($array as $key => $value) {
				$stmt->bindValue(":" . $key, $value);
			}
			if($stmt->execute()){
				return true;
			}
			else{
				$err = $stmt->errorInfo();
				return end($err);
			}
		}
	}

	public function trash($table,$colum_name,$id){
		$deleted = array('deleted_at' =>timestamp() );
		$res = $this->update($table,$colum_name,$id,$deleted);
		//$stmt = $this->pdo->prepare("DELETE FROM ".$table." WHERE ".$colum_name."=".$id."" );
		//$stmt->execute();
		if ($res) {
			return true;
		}
	}



// find all data from table
	public function all($table) {
		$stmt = $this->pdo->prepare("SELECT * FROM " . $table . "");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}


	// find a specific data
	public function find($table,$column,$value) {
		$stmt = $this->pdo->prepare("SELECT * FROM " . $table . " WHERE " . $column . " = :value LIMIT 1");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function findWhere($table,$column,$value) {
		$stmt = $this->pdo->prepare("SELECT * FROM " . $table . " WHERE " . $column . " = :value");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}


	public function findWhereAll($table, $array = array() , $status) {
		$sql = "SELECT * FROM {$table}";
		$where = " WHERE ";
		foreach ($array as $key => $value) {
			$sql .= "{$where} {$key} = :{$key}";
			$where = " AND ";			
		}

		if ($stmt = $this->pdo->prepare($sql)) {
			foreach ($array as $key => $value) {
				$stmt->bindValue(":" . $key, $value);
			}
			if($stmt->execute()){
				if ($status == "one") {
					return $stmt->fetch(PDO::FETCH_OBJ);	
				}
				elseif($status == "all"){
					return $stmt->fetchAll(PDO::FETCH_OBJ);
				}
				else{
					return "Only 'one' and 'all' is allowed ";
				}
			}
			else{
				$err = $stmt->errorInfo();
				return end($err);
			}
		}
	}

	public function insertId(){
		return $this->pdo->lastInsertId();
	}
// Count row form table
	public function total_count($table) {
		$stmt = $this->pdo->prepare("SELECT * FROM " . $table . " ");
		$stmt->execute();
		$stmt->fetchAll(PDO::FETCH_OBJ);
		$count = $stmt->rowCount();
		return $count;
	}

	public function totalCountWhere($table,$column,$val) {
		$stmt = $this->pdo->prepare("SELECT * FROM " . $table . " WHERE ". $column ." = ". $val ." ");
		$stmt->execute();
		$stmt->fetchAll(PDO::FETCH_OBJ);
		$count = $stmt->rowCount();
		return $count;
	}

	public function shortSummery($content,$len)
	{
		$content =  substr($content, 0, $len);
		return $content .= "....";
	}



	public function uploadImage($file,$folderPath)
	{
		$fileName = basename($file['name']);
		$fileTmp  = $file['tmp_name'];
		$fileSize  = $file['size'];
		$error  = $file['error'];

		$ext = explode(".", $fileName);
		$ext = strtolower(end($ext));

		$allowedExt = array('jpg','png','jpeg');

		if (in_array($ext, $allowedExt) === true)
		{
			if ($fileSize <= ( 1024 * 2 ) * 1024)
			{
				$fileRoot = $fileName;
				move_uploaded_file($fileTmp, $_SERVER["DOCUMENT_ROOT"] . $folderPath. $fileRoot);
				return $fileRoot;

			}else{
				$GLOBALS['imageError'] = "This file size is too large";
			}
		}else{
			$GLOBALS['imageError'] = "This file type is not allowed";
		}
	}

	// display the message
	public function message(){
		if (isset($_SESSION['message'])) {
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
	}



} //end of class

?>
