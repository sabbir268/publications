<style>
.select2-container--default.select2 {
 width: 83% !important;
}
</style>
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="container-fluid">
        <div class="row page-title clearfix">
            <div class="page-title-left">
                <h6 class="page-title-heading mr-0 mr-r-5">Authors</h6>
            </div>
            <!-- /.page-title-left -->
            <div class="page-title-right d-none d-sm-inline-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Authors Respect Money</li>
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
                <div class="col-md-12 widget-holder">
                    <div class="widget-bg p-3">
                        <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success btn-sm rounded-0 ml-4"><i class="fa fa-check-square"></i> &nbsp; Payout</button>

                        <table class="table table-striped text-center" data-toggle="datatables" data-plugin-options='{"searching": false}' >
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Authors Name</th>
                                    <th>Alloted Amount</th>
                                    <th>Payout Amount</th>
                                    <th>Due Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                             <?php
                             $authData = $obj->all('authors');
                             foreach($authData as $auth){
                                $allotData = $obj->query("SELECT sum(allot_am) as 't_allot_am' FROM `author_rm_view` WHERE a_id =".$auth->a_id." ","one");
                                $paidData = $obj->query("SELECT SUM(pay_am) as 'paid_am' FROM `authors_pay` WHERE a_id =".$auth->a_id." ","one");
                                
                                ?>
                                 <tr>
                                     <td><?php echo $auth->a_id; ?></td>
                                     <td><?php echo $auth->a_name; ?></td>
                                     <td><?php echo $allotData->t_allot_am; ?></td>
                                     <td><?php echo $paidData->paid_am == '' ? 0.00 : $paidData->paid_am  ?></td>
                                     <td><?php echo ($allotData->t_allot_am - $paidData->paid_am); ?></td>
                                     <td><div class="btn-group"><button class="btn btn-sm btn-info add_payment" data-id ="<?php echo $auth->a_id ?>"> Add Payment</button><button class="btn btn-sm btn-warning view_ledger"  data-id ="<?php echo $auth->a_id ?>">View Ledger</button></div></td>
                                 </tr>
                             <?php 
                     }
                     ?>
                 </tbody>

             </table>
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
<div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Authors Respect Money Payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">



        <form id="arm_pay_form" action="app/action/addAuthors.php" method="POST">
            <!--  author name -->
            <div class="input-group mb-3">
               <div class="input-group-prepend">
                <span class="input-group-text btn-primary rounded-0">Authors</span>
            </div>
            <select  id="a_id" class="select2 form-control" name="a_id"  required>
                <option value="">Select authors..</option>
                <?php $authData = $obj->all('authors') ?>
                <?php foreach ($authData as $auth): ?>
                    <option value="<?php echo $auth->a_id; ?>"><?php echo $auth->a_name; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <!--.  author name end-->

        <!--  author rm amount  -->
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text btn-primary rounded-0">Amount</span>
        </div>
        <input name="arm_pay_am" id="arm_pay_am" class="form-control" required >
    </div>
    <!--.  author rm amount end -->

    <!--  pay date  -->
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text btn-primary rounded-0">Pay Date</span>
    </div>
    <input type="date" name="pay_date" id="pay_date" class="form-control" required >
    <span class="btn btn-secondary rounded-0"><i class="fa fa-calendar"></i></span>
</div>
<!--.  pay date end -->

<!--  remarks  -->
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text btn-primary rounded-0">Remarks</span>
</div>
<input name="remarks" id="remarks" class="form-control" required >
</div>
<!--.  remarks end -->



</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
    <button id="submit_arm_pay_form" name="submit_arm_pay_form" type="submit" class="btn btn-primary btn-sm rounded-0">Save</button>

</form>
</div>
</div>
</div>
</div>

<div class="response"></div>
</main>




<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>



<script>
$(document).ready(function() {
    $('.add_payment').click(function(event) {
        $.post('app/ajax/armam.php', {a_id: $(this).data('id') , add_payment: 'add_payment' }, function(data) {
            $('.response').html(data);
            $('#add_payment_modal').modal('show');
        });
    });
});


$(document).ready(function() {
    $('.view_ledger').click(function(event) {
        $.post('app/ajax/armam.php', {a_id: $(this).data('id') , view_ledger: 'view_ledger' }, function(data) {
            $('.response').html(data);
            $('#ledger_modal').modal('show');
        });
    });
});

</script>
