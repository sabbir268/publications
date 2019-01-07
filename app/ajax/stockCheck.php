<?php require_once('../init.php');

if (isset($_POST['e_id'])) {
    $e_id = $_POST['e_id'];
    $searchStock = $obj->find('stock_view','e_id',$e_id);

    echo $searchStock->stock;    
}
?>
