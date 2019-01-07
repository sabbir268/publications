<?php 
if(!isset($_SESSION['o_id'])){
   redirect('app/action/orderIdGen.php');
}

$o_id = $_SESSION['o_id'];

$currentOrders = $obj->find('orders_view','o_id',$o_id);

?>

<!-- <style>
.select2-container--default.select2 {
   width: 80% !important;
}
</style> -->


<main class="main-wrapper clearfix">
   <!-- Page Title Area -->
   <div class="container-fluid">
      <div class="row page-title clearfix">
         <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Sells</h6>
         </div>
         <!-- /.page-title-left -->
         <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="#">Dashboard</a>
               </li>
               <li class="breadcrumb-item active">Sell/Order-Id:<?php echo $o_id;?></li>
            </ol>
         </div>
         <!-- /.page-title-right -->
      </div>
      <!-- /.page-title -->
   </div>
   <!-- /.container-fluid -->
   <!-- =================================== -->
   <!-- Different data widgets ============ -->
   <!-- =================================== -->
   <div class="container-fluid">
      <div class="widget-list">
         <div class="row">
            <div class="col-md-8 widget-holder">
               <div class="widget-bg p-3">
                  <div class="row">
                   <div class="form-group col-md-5">
                     <label>Books/Products</label>
                     <select   class="select2 form-control" name="products" id="products"  required>
                        <option value="">Select Books..</option>
                        <?php $stocksData = $obj->all('stock_view') ?>
                        <?php foreach ($stocksData as $data): ?>
                           <option value="<?php echo $data->e_id; ?>"><?php echo $data->book_name; ?>(<?php echo $data->editions; ?>)</option>
                        <?php endforeach ?>
                     </select>
                  </div>

                  <div class="form-group col-md-2">
                    <label>Copy</label>
                    <input type="number" class="form-control" name="copy" id="copy">
                 </div>

                 <div class="form-group col-md-2">
                    <label>Disc.(%)</label>
                    <input type="number" class="form-control" value="0" name="disc_per" id="disc_per">
                 </div>

                 <div class="form-group col-md-2">
                    <label>Disc.(tk)</label>
                    <input type="text" class="form-control" value="0" name="disc_am" id="disc_am">
                 </div>

                 <div class="form-group col-md-1">
                  <label for="">ADD</label>
                  <button class="btn btn-success  rounded-0"  id="addProduct"><i class="fa fa-plus"></i></button>
                  <!-- <input type="submit" class="btn btn-primary btn-sm" value="ADD"  id="addProduct"> -->
               </div>
               
            </div>

            <div class="row">
               <div class="col-md-12">
                 <table class="table table-responsive text-center">
                    <thead class="bg-dark">
                       <tr>
                          <th>Books Name</th>
                          <th>Body Rate</th>
                          <th>Copy</th>
                          <th>Cost</th>
                          <th>Discount</th>
                          <th>Total</th>
                          <th>Action</th>
                       </tr>
                    </thead>
                    <tbody id="orderDetailsData">
                     <tr id="loaderGif"><td colspan="8"><img src="<?php echo SITE_ROOT ?>/assets/img/ajax-loader.gif" alt=""></td></tr>
                     <?php 
                     $o_id = $_SESSION['o_id'];
                     $resOrderDetailsData = $obj->findWhere('order_details_view','o_id',$o_id);
                     if($resOrderDetailsData){
                        foreach ($resOrderDetailsData as $data) {
                          ?>
                          <tr>
                             <td><?php echo $data->book_name ?>(<?php echo $data->editions ?>)</td>
                             <td><?php echo $data->body_rate ?></td>
                             <td><?php echo $data->qty ?></td>
                             <td><?php echo $data->price ?></td>
                             <td><?php echo ($data->disc_am + ((($data->price)*$data->disc_per)/100)  ) ?></td>
                             <td><?php echo $data->t_price ?></td>
                             <td><div class="btn-group"><button  data-id="<?php echo $data->od_id ?>" class="btn btn-sm btn-danger remove_product"><i class="fa fa-trash"></i></button></div></td>
                          </tr>

                          <?php 
                       }
                    }else{
                     ?>
                     <tr><td colspan="8">No Item Added</td></tr>
                     <?php 
                  }
                  ?>

               </tbody>
            </table>
         </div>
      </div>

   </div>
   <!-- /.widget-body -->
</div>

<div class="col-md-4 widget-holder">
  <div class="widget-bg p-3">

     <div class="input-group mb-2 border-bottom ">
        <div class="input-group-prepend">
           <span class="input-group-text btn-info btn-sm rounded-0">Oreder Date</span>
        </div>
        <input type="date" name="o_date" id="o_date" class="form-control form-control-sm" value="<?php echo $currentOrders->order_date == true ? $currentOrders->order_date : date("Y-m-d") ?>" >
        <span class="btn btn-secondary btn-sm rounded-0"><i id="caleder" class="fa fa-calendar"></i></span>
     </div>
     <div id="customerSection" class="form-group ">
      <?php 
      if ($currentOrders->c_id > 0) {
         $customersFinde = $obj->find('customers','c_id',$currentOrders->c_id);
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
  else{

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
?>
</div>
<hr>
<div class="input-group ">
  <span class="input-group-text bg-transparent border-0">Total Item</span>
  <input type="text" id="total_item" class="form-control form-control-sm border-0 text-right" value="<?php echo $currentOrders->total_item ?>" readonly>
</div>
<div class="input-group ">
  <span class="input-group-text bg-transparent border-0">Total Amount</span>
  <input type="text" id="total_am" class="form-control form-control-sm border-0 text-right" value="<?php echo $currentOrders->total_am ?>" readonly>
</div>
<div class="input-group mb-1">
  <span class="input-group-text bg-transparent border-0">- Discount(%) &nbsp;</span>
  <input type="text" id="o_disc_per" class="form-control form-control-sm col-md-2" value="<?php echo $currentOrders->disc_per ?>">
  <span class="input-group-text btn btn-sm rounded-0"><i class="fa fa-percent"></i></span>
  <input type="text" id="o_disc_per_am"  class="form-control form-control-sm border-0 text-right" value="<?php echo $currentOrders->disc_per_am ?>" readonly>
</div>
<div class="input-group border-bottom">
  <span class="input-group-text bg-transparent border-0">- Discount(Tk)&nbsp;</span>
  <input type="text" id="o_disc_am" class="form-control form-control-sm col-md-2" value="<?php echo $currentOrders->disc_am ?>">
  <span class="input-group-text btn btn-sm rounded-0"><i class="fa fa-dollar"></i></span>
  <input type="text" id="o_disc_am_n" class="form-control form-control-sm border-0 text-right" value="<?php echo $currentOrders->disc_am ?>" readonly>
</div>

<div class="input-group ">
  <span class="input-group-text bg-transparent border-0">Grand Total</span>
  <input type="text" id="g_total_am" class="form-control  border-0 text-right" value="<?php echo $currentOrders->g_total_am ?>" readonly>
</div>

<div class="input-group border-bottom">
  <span class="input-group-text bg-transparent border-0">Paid Amount</span>
  <span class="col-md-2"></span>
  <sapn class="btn p_am "><i class="fa fa-spinner fa-spin"></i></sapn>
  <input type="text" id="paid_am" class="form-control text-right col-md-4" value="<?php echo $currentOrders->paid_am ?>">
</div>

<div class="input-group mb-2">
  <span class="input-group-text bg-transparent border-0">Due Amount</span>
  <input type="text" id="due_am" class="form-control  border-0 text-right" value="<?php echo $currentOrders->due_am ?>" readonly>
</div>

<!-- 
  <button class="btn btn-primary float-right rounded-0 "><i class="list-icon fa fa-credit-card"></i>&nbsp; Add payment</button> -->

  <hr>
  <div class="input-group">
     <center>
        <button id="suspend" class="btn btn-warning rounded-0 btn-sm mr-3"><i class="list-icon  fa fa-warning"></i> Suspend</button>
        <button class="btn btn-success rounded-0 btn-sm mr-3"><a href="index.php?page=invoice&o_id=<?php echo $o_id ?>" class="text-white"><i class="list-icon  fa fa-check"></i>Invoice</a></button>
        <button id="cancel" class="btn btn-danger rounded-0 btn-sm "><i class="list-icon  fa fa-times"></i>Cancel</button>
     </center>
  </div>

</div>
<!-- /.widget-body -->
</div>
<!-- /.widget-bg -->
</div>
<!-- /.widget-holder -->
</div>
<!-- /.row -->
</div>
<!-- /.widget-list -->
</div>
<!-- /.container-fluid -->
</div>
<!-- Modal -->
<div class="modal fade" id="newCustomerModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="newCustomerForm" >
               <!--  author name -->
               <div class="input-group mb-2">
                  <div class="input-group-prepend">
                     <span class="input-group-text btn-primary rounded-0">Name</span>
                  </div>
                  <input name="c_name" id="c_name" class="form-control" required >
               </div>
               <!--.  author name end-->
               <!--  author phone  -->
               <div class="input-group mb-2">
                  <div class="input-group-prepend">
                     <span class="input-group-text btn-primary rounded-0">Phone No.</span>
                  </div>
                  <input name="c_phn" id="c_phn" class="form-control" required >
               </div>
               <!--.  author phone  end -->
               
               <div class="input-group mb-2">
                  <div class="input-group-prepend">
                     <span class="input-group-text btn-primary rounded-0">Email</span>
                  </div>
                  <input  id="c_mail" name="c_mail"  class="form-control" required>
               </div>
               
               <div class="input-group mb-2">
                  <div class="input-group-prepend">
                     <span class="input-group-text btn-primary rounded-0">Address</span>
                  </div>
                  <input  id="c_addr" name="c_addr"  class="form-control" required>
               </div>
               

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
               <button id="submit_auth_form" name="submit_customer_form" type="submit" class="btn btn-primary btn-sm rounded-0">Save</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
</main>

<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {
   $('#loaderGif').hide();
   $('#addProduct').click(function() {
      $e_id = $('#products').val();
      $qty = $('#copy').val();
      $o_disc_per = $('#disc_per').val();
      $o_disc = $('#disc_am').val();
      $o_id = <?php echo $_SESSION['o_id']; ?>;
      $('#loaderGif').show();
      if($e_id){
         $.ajax({
            url: 'app/ajax/createOrder.php',
            type: 'POST',
            data: {e_id : $e_id , qty: $qty , o_disc_per: $o_disc_per ,  o_disc: $o_disc , o_id: $o_id , item_add: 'add_item' }
         })
         .done(function(data) {
            $('#orderDetailsData').html(data);

            $('#products').prop('selectedIndex',0);
            $('#copy').val(0);
            $('#disc_per').val(0);
            $('#disc_am').val(0);

            $('#loaderGif').hide();
         })
         .fail(function() {
            console.log("error");
         })


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

      }else{
         alert('Please Select a Product');
      }
   });

   $('select#products').change(function(event) {
      $.post('app/ajax/stockCheck.php', {e_id: $(this).val() }, function(data) {
         $('#copy').val($.trim(data));
      });
   });

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

   $('#o_date').focus(function(event) {
      $('#caleder').removeClass('fa-calendar');
      $('#caleder').addClass('fa-spinner');
      $('#caleder').addClass('fa-spin');
   });

   $('#o_date').blur(function(event) {
      $o_id = <?php echo $_SESSION['o_id']; ?>;
      $.post('app/ajax/createOrder.php', {date: $(this).val() , o_id: $o_id ,date_add : 'order_date'}, function(data) {
         console.log(data);
         $('#caleder').addClass('fa-calendar');
         $('#caleder').removeClass('fa-spinner');
         $('#caleder').removeClass('fa-spin');
      });
   });

   $('#newCustomerForm').submit(false);
   $('#newCustomerForm').submit(function(event) {
      event.preventDefault();
      $.ajax({
         url: 'app/ajax/addCustomer.php',
         type: 'POST',
         data: $(this).serialize(),
      })
      .done(function(data) {
         $('#customerSection').html(data);
         $('#newCustomerForm')[0].reset();
         $('#newCustomerModal').modal('hide');
      })
      .fail(function() {
         console.log("error");
      })
      
   });

   $('#customersSelect').change(function(event) {
      $c_id = $(this).val();
      $o_id = <?php echo $_SESSION['o_id']; ?>;

      $.post('app/ajax/createOrder.php', {c_id: $c_id , o_id: $o_id , customer_add : 'customer_add' }, function(data) {
         $('#customerSection').html(data);
      });
   });

   /*remove customer from order*/
   $('#customersRemove').click(function(event) {
      $o_id = <?php echo $_SESSION['o_id']; ?>;
      $.post('app/ajax/createOrder.php', {remove_customer: 'removeCustomer' ,o_id: $o_id }, function(data) {
         $('#customerSection').html(data);
      });
   });
   /*----------*/

   /*add discount percentage*/
   $('#o_disc_per').keyup(function(event) {
      $('.fa-percent').toggleClass('fa-spinner');
      $o_id = <?php echo $_SESSION['o_id']; ?>;
      $.post('app/ajax/createOrder.php', {o_disc_per: $(this).val() , o_id: $o_id , add_disc_per: 'add_disc_per'}, function(data, JSON) {
         $json = $.parseJSON(data);
         $('#o_disc_per_am').val($json.disc_per_am);
         $('#g_total_am').val($json.g_total_am);
         $('#due_am').val($json.due_am);
         $('.fa-spinner').toggleClass('fa-percent');
      });
   });

   /*-----------*/

   /*add discount amount*/
   $('#o_disc_am').keyup(function(event) {
      $('.fa-dollar').toggleClass('fa-spinner');
      $o_id = <?php echo $_SESSION['o_id']; ?>;
      $.post('app/ajax/createOrder.php', {o_disc_am: $(this).val() , o_id: $o_id , add_disc_am: 'add_disc_am'}, function(data, JSON) {
         $json = $.parseJSON(data);
         $('#o_disc_am_n').val($json.disc_am);
         $('#g_total_am').val($json.g_total_am);
         $('#due_am').val($json.due_am);
         $('.fa-spinner').toggleClass('fa-dollar');
      });
   });

   /*-----------*/


   /*add paid amount*/
   $('.p_am').css("visibility","hidden");
   $('#paid_am').keyup(function(event) {
      $('.p_am').css("visibility","visible");
      $o_id = <?php echo $_SESSION['o_id']; ?>;
      $.post('app/ajax/createOrder.php', {o_paid_am: $(this).val() , o_id: $o_id , add_paid_am: 'add_paid_am'}, function(data) {
         $('#due_am').val(data);
         $('.p_am').css("visibility","hidden");
      });
   });

   /*-----------*/


   $('#suspend').click(function(event) {
      $o_id = <?php echo $_SESSION['o_id']; ?>;
      $.post('app/ajax/createOrder.php', { o_id: $o_id , suspend: 'suspend'}, function(data) {
         $data = $.trim(data);
         if($data == 1){
            window.location.href = 'app/action/resetOrderId.php';
         }
      });
   });

   $('#cancel').click(function(event) {
      $o_id = <?php echo $_SESSION['o_id']; ?>;
      $.post('app/ajax/createOrder.php', { o_id: $o_id , cancel: 'cancel'}, function(data) {
         $data = $.trim(data);
         if($data == 1){
            window.location.href = 'app/action/resetOrderId.php';
         }
      });
   });


});

</script>