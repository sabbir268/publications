<?php require_once('../init.php');

$data = $Customers->addCustomersAjax();
$o_id = $_SESSION['o_id'];
$c_id = $data->c_id;
if(!empty($c_id)){
  $updateCustomer = array('c_id' => $c_id );
  $updateCustomerOrders = $obj->update('orders','o_id',$o_id,$updateCustomer);

  if($updateCustomerOrders)  {
    ?>
    <div class="alert alert-success rounded-0" role="alert">
      <button type="button" id="customersRemove" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="row">
        <div class="col-md-12">
          <p class="p-0 mb-1"><strong>Name: </strong> <?php echo $data->c_name ?></p>
        </div>
      </div>
    </div>
    <?php 
  }
}


?>
