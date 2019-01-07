<?php 
error_reporting(0);
require_once('../init.php');

if (isset($_POST['item_add'])) {
  $e_id = $_POST['e_id'];
  $qty = $_POST['qty'];;
  $o_disc_per = $_POST['o_disc_per'];
  $o_disc = $_POST['o_disc'];
  $created_at = timestamp();

  $o_id = $_POST['o_id'];


  /*--create order details--*/

  $queryOrderDetails = array('o_id' =>$o_id , 'e_id' => $e_id , 'qty' => $qty , 'disc' => $o_disc , 'disc_per' => $o_disc_per , 'created_at' => $created_at );

  $resOrderDetails = $obj->create('order_details',$queryOrderDetails);

  if($resOrderDetails > 0){
    $resOrderDetailsData = $obj->findWhere('order_details_view','o_id',$o_id);
    foreach ($resOrderDetailsData as $data) {
      ?>
      <tr>
        <td><?php echo $data->book_name ?>(<?php echo $data->editions ?>)</td>
        <td><?php echo $data->body_rate ?></td>
        <td><?php echo $data->qty ?></td>
        <td><?php echo $data->price ?></td>
        <td><?php echo ($data->disc_am + ((($data->price)*$data->disc_per)/100)  ) ?></td>
        <td><?php echo $data->t_price ?></td>
        <td><div class="btn-group"><button data-id="<?php echo $data->od_id ?>" class="btn btn-sm btn-danger remove_product"><i class="fa fa-trash"></i></button></div></td>
      </tr>

      <script>
        $('.remove_product').click(function(event) {
          $o_id = <?php echo $_SESSION['o_id']; ?>;
          $od_id = $(this).data('id');
          $.post('app/ajax/createOrder.php', {od_id: $od_id , o_id: $o_id , remove_product: 'remove_product'}, function(data) {
           $('#orderDetailsData').html(data);
         });

          $.post('app/ajax/createOrder.php', {o_id: $o_id , all_data: 'all_data' }, function(data,json) {
           $json = $.parseJSON(data);
           $('#total_item').val($json.total_item);
           $('#total_am').val($json.total_am);
           $('#o_disc_per').val($json.disc_per);
           $('#o_disc_per_am').val($json.disc_per_am);
           $('#o_disc_am').val($json.disc_am);
           $('#o_disc_am_n').val($json.disc_am);
           $('#g_total_am').val($json.g_total_am);
           $('#paid_am').val($json.paid_am);
           $('#due_am').val($json.due_am);
         });


        });
      </script>
      <?php 
    }
  }

  /*--create order details end --*/
}



if(isset($_POST['remove_product'])){
  $o_id = $_POST['o_id'];
  $od_id = $_POST['od_id'];

  $del = array('od_id' => $od_id , 'o_id' => $o_id );
  $delProd = $obj->delete('order_details',$del);
  if($delProd){
   $resOrderDetailsData = $obj->findWhere('order_details_view','o_id',$o_id);
   foreach ($resOrderDetailsData as $data) {
    ?>
    <tr>
      <td><?php echo $data->book_name ?>(<?php echo $data->editions ?>)</td>
      <td><?php echo $data->body_rate ?></td>
      <td><?php echo $data->qty ?></td>
      <td><?php echo $data->price ?></td>
      <td><?php echo ($data->disc_am + ((($data->price)*$data->disc_per)/100)  ) ?></td>
      <td><?php echo $data->t_price ?></td>
      <td><div class="btn-group"><button data-id="<?php echo $data->od_id ?>" class="btn btn-sm btn-danger remove_product"><i class="fa fa-trash"></i></button></div></td>
    </tr>

    <script>
      $('.remove_product').click(function(event) {
        $o_id = <?php echo $_SESSION['o_id']; ?>;
        $od_id = $(this).data('id');
        $.post('app/ajax/createOrder.php', {od_id: $od_id , o_id: $o_id , remove_product: 'remove_product'}, function(data) {
         $('#orderDetailsData').html(data);
       });

        $.post('app/ajax/createOrder.php', {o_id: $o_id , all_data: 'all_data' }, function(data,json) {
         $json = $.parseJSON(data);
         $('#total_item').val($json.total_item);
         $('#total_am').val($json.total_am);
         $('#o_disc_per').val($json.disc_per);
         $('#o_disc_per_am').val($json.disc_per_am);
         $('#o_disc_am').val($json.disc_am);
         $('#o_disc_am_n').val($json.disc_am);
         $('#g_total_am').val($json.g_total_am);
         $('#paid_am').val($json.paid_am);
         $('#due_am').val($json.due_am);
       });


      });
    </script>
    <?php
  }

}
}



if(isset($_POST['date_add'])){
  $date = $_POST['date'];
  $o_id = $_POST['o_id'];

  $dateUpdate = array('order_date' => $date);
  $updateRes = $obj->update('orders','o_id',$o_id,$dateUpdate);

  if($updateRes){
    echo "ok";
  }

}


if(isset($_POST['customer_add'])){
  $c_id = $_POST['c_id'];
  $o_id = $_POST['o_id'];

  $dateUpdate = array('c_id' => $c_id);
  $updateRes = $obj->update('orders','o_id',$o_id,$dateUpdate);

  if($updateRes){
    $customersFinde = $obj->find('customers','c_id',$c_id);
    ?>
    <div class="alert alert-success rounded-0" role="alert">
     <button type="button" id="customersRemove" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
     <div class="row">
       <div class="col-md-12">
         <p class="p-0 mb-1"><strong>Name: </strong> <?php echo $customersFinde->c_name ?></p>
       </div>
     </div>
   </div>
   <?php 
 }

}


if(isset($_POST['remove_customer'])){
  $c_id = 0;
  $o_id = $_POST['o_id'];

  $dateUpdate = array('c_id' => $c_id);
  $updateRes = $obj->update('orders','o_id',$o_id,$dateUpdate);

  if($updateRes){
    ?>
    <label class="text-info border-bottom btn p-0 m-0" data-toggle="modal" data-target="#newCustomerModal" >Add New Customer</label>
    <label>&nbsp;OR</label>
    <select name="customers" id="customersSelect" class="form-control select2 m-0">
     <option value="">Select a Customer..</option>
     <?php $customerData = $obj->all('customers') ?>
     <?php foreach ($customerData as $data): ?>
      <option value="<?php echo $data->c_id; ?>"><?php echo $data->c_name; ?> </option>
    <?php endforeach ?>
  </select>
  <?php 
}

}

if (isset($_POST['all_data'])) {
  $o_id = $_POST['o_id'];
  $orderData = $obj->find('orders_view','o_id',$o_id);
  echo json_encode($orderData);
}


if ($_POST['add_disc_per']) {
  $o_id = $_POST['o_id'];
  $o_disc_per = $_POST['o_disc_per'];
  $discPerUpdate = array('o_disc_per' => $o_disc_per);
  $updateRes = $obj->update('orders','o_id',$o_id,$discPerUpdate);

  if ($updateRes) {
    $orderData = $obj->find('orders_view','o_id',$o_id);
    $jsonData->disc_per_am = $orderData->disc_per_am;
    $jsonData->g_total_am = $orderData->g_total_am;
    $jsonData->due_am = $orderData->due_am;

    echo json_encode($jsonData);
  }
}


if ($_POST['add_disc_am']) {
  $o_id = $_POST['o_id'];
  $o_disc_am = $_POST['o_disc_am'];
  $discPerUpdate = array('o_disc' => $o_disc_am);
  $updateRes = $obj->update('orders','o_id',$o_id,$discPerUpdate);

  if ($updateRes) {
    $orderData = $obj->find('orders_view','o_id',$o_id);
    $jsonData->disc_am = $orderData->disc_am;
    $jsonData->g_total_am = $orderData->g_total_am;
    $jsonData->due_am = $orderData->due_am;

    echo json_encode($jsonData);
  }
}


if ($_POST['add_paid_am']) {
  $o_id = $_POST['o_id'];
  $o_paid_am = $_POST['o_paid_am'];
  $discPerUpdate = array('o_paid_am' => $o_paid_am);
  $updateRes = $obj->update('orders','o_id',$o_id,$discPerUpdate);

  if ($updateRes) {
    $orderData = $obj->find('orders_view','o_id',$o_id);
    echo $orderData->due_am;
  }
}


if ($_POST['suspend']) {
  $o_id = $_POST['o_id'];
  $StatusUpdate = array('status' => 2);
  $updateRes = $obj->update('orders','o_id',$o_id,$StatusUpdate);
  //if ($updateRes) {
  echo "1";
  //}
}


if ($_POST['cancel']) {
  $o_id = $_POST['o_id'];
  $detDelData = array('o_id' => $o_id );
  $delOrderDetails = $obj->delete('order_details',$detDelData);
  if ($delOrderDetails) {
    $ordDelData = array('o_id' => $o_id);
    $delOrders = $obj->delete('orders',$ordDelData);
    if ($delOrders) {
      echo $delOrders;
    }
  }
}


?>
