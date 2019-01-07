<?php require_once('../init.php');

if (isset($_POST['b_id'])) {
    $b_id = $_POST['b_id'];
    $searchAuthors = $obj->findWhere('book_auth_view','b_id',$b_id);

    foreach ($searchAuthors as $auth) {
        ?>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
              <span  class="input-group-text btn-primary rounded-0"><?php echo $auth->a_name ?></span>
          </div>
          <input type="text" name="auth[]" value="<?php echo $auth->a_id ?>" hidden>
          <input name="arm_am[]" id="arm_am" class="form-control" required >
          <span class="input-group-append rounded-0 btn btn-default">%</span>
      </div>
      <?php
  }
}

if (isset($_POST['add_payment'])) {
    $a_id = $_POST['a_id'];
    $aData = $obj->find('authors','a_id',$a_id);
    ?>
    <div class="modal fade" id="add_payment_modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo $aData->a_name ?>'s  Payment</h5>
        <!--  <div class="alert alert-success alert-dismissible" id="myAlert">
            <a href="#" class="close">&times;</a>
            <strong>Success!</strong> Payment Done.
        </div> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

      <!--  author name -->
      <input type="text" id="a_id_rm" name="a_id" value="<?php echo $aData->a_id ?>" hidden>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text btn-primary rounded-0">Books</span>
      </div>
      <select  id="e_id_rm" class="select2 form-control" name="e_id"  required>
          <option value="">Select Book..</option>
          <?php $armvData = $obj->findWhere('author_rm_view','a_id',$a_id); ?>
          <?php foreach ($armvData as $data): ?>
              <option value="<?php echo $data->e_id; ?>"><?php echo $data->b_name; ?></option>
          <?php endforeach ?>
      </select>
  </div>
  <!--.  author name end-->
  <!--  author rm amount  -->
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text btn-primary rounded-0">Payable Amount</span>
  </div>
  <input name="payable_am" id="payable_am" class="form-control" readonly>
</div>
<!--.  author rm amount end -->
<!--  pay date  -->
<div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text btn-primary rounded-0">Payment Amount</span>
  </div>
  <input id="pay_am_rm" class="form-control" required >
</div>
<!--.  pay date end -->

<!--  pay date  -->
<div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text btn-primary rounded-0">Payment Date</span>
  </div>
  <input type="date"  id="pay_date_rm" class="form-control" required >
  <span class="btn btn-secondary rounded-0"><i class="fa fa-calendar"></i></span>
</div>
<!--.  pay date end -->

<!--  remarks  -->
<div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text btn-primary rounded-0">Remarks</span>
  </div>
  <input name="remarks" id="remarks_rm" class="form-control" required >
</div>
<!--.  remarks end -->
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
  <button id="submit_payment_form" name="submit_payment_form" type="submit" class="btn btn-primary btn-sm rounded-0">Save</button>

</div>
</div>
</div>

<script>
    $('.select2').select2();

    $('select#e_id_rm').change(function(event) {
        //alert(1);
        $e_id = $(this).val();
        $a_id = $('#a_id_rm').val();
        $.post('app/ajax/armam.php', {e_id: $e_id , a_id: $a_id , payable_am: 'payable_am' }, function(data) {
            $('#payable_am').val(data);
        });
    });

      // $('#arm_pay_form').submit(false);
      // $('#myAlert').hide();
      $('#submit_payment_form').click(function(event) {
         //event.preventDefault();
         $a_id = $('#a_id_rm').val();
         $e_id = $('#e_id_rm').val();
         $pay_am = $('#pay_am_rm').val();
         $pay_date = $('#pay_date_rm').val();
         $remarks = $('#remarks_rm').val();
         $.post('app/ajax/armam.php', {a_id: $a_id, e_id : $e_id , pay_am: $pay_am , pay_date: $pay_date, remarks: $remarks , submit_payment_form: 'submit_payment_form'}, function(data) {
             if ($.trim(data) == 1) {
               if(confirm("Pyament Done! Add another payment?")){
                 $e_id = $('#e_id_rm').val('');
                 $pay_am = $('#pay_am_rm').val('');
                 $pay_date = $('#pay_date_rm').val('');
                 $remarks = $('#remarks_rm').val('');
                 $('#payable_am').val('');  
             }
             else{
                $('#add_payment_modal').modal('hide');
            }
        }
    });
     });

 </script>
</div>
<?php 
}

if (isset($_POST['view_ledger'])) {
    $a_id = $_POST['a_id'];
    $aData = $obj->find('authors','a_id',$a_id); 
    
    ?>

    <div class="modal fade " id="ledger_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $aData->a_name ?>'s  Ledger</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                    <table class="table table-sm table-bordered text-center">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Description</th>
                                <th>Alloted</th>
                                <th>Payout</th>
                                <th>Due</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $armvData = $obj->findWhere('author_rm_view','a_id',$a_id);
                            foreach ($armvData as $data): ?>
                            <tr>
                                <td><?php echo $data->arm_id ?></td>
                                <td><?php echo $data->b_name ?> (<?php echo $data->allot_per ?>%)</td>
                                <td><?php echo $data->allot_am ?></td>
                                <td><?php echo $data->paid_am ?></td>
                                <td><?php echo $data->due_am ?></td>
                                <td><button  data-aid="<?php echo $data->a_id ?>" data-eid="<?php echo $data->e_id ?>" class="btn btn-sm btn-info view_pay_history" ><i class="fa fa-eye"></i></button></td>
                            </tr>
                           <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <?php  $armvSum = $obj->query("SELECT SUM(allot_am) as 't_allot_am', SUM(paid_am) as 't_paid_am' , SUM(due_am) as 't_due_am' FROM author_rm_view WHERE a_id = $a_id","one"); ?>
                                <th><?php echo $armvSum->t_allot_am ?> </th>
                                <th><?php echo $armvSum->t_paid_am ?> </th>
                                <th><?php echo $armvSum->t_due_am ?> </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="history_view">
</div>

<script>
    $('.view_pay_history').click(function(event) {
        $a_id = $(this).data('aid');
        $e_id = $(this).data('eid');

        $.post('app/ajax/armam.php', {e_id: $e_id , a_id: $a_id , view_pay_history: 'view_pay_history' }, function(data) {
            $('.history_view').html(data);
            $('#history_modal').modal('show');
            $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
        });

    });
</script>

<?php 

}




if (isset($_POST['payable_am'])) {
    $a_id = $_POST['a_id'];
    $e_id = $_POST['e_id'];
    $conditon = array('e_id' => $e_id , 'a_id'=> $a_id  );
    $armvData = $obj->findWhereAll('author_rm_view',$conditon,"one");

    echo $armvData->allot_am;
}

if (isset($_POST['submit_payment_form'])) {
    $a_id = $_POST['a_id'];
    $e_id = $_POST['e_id'];
    $pay_am = $_POST['pay_am'];
    $pay_date = $_POST['pay_date'];
    $remarks = $_POST['remarks'];
    $query = array('a_id' => $a_id , 'e_id' => $e_id , 'pay_am' => $pay_am , 'pay_date' => $pay_date , 'remarks' => $remarks, 'created_at' => timestamp() );
    $addPay = $obj->create('authors_pay',$query);

    if ($addPay) {
        echo "1";
    }

}

if (isset($_POST['view_pay_history'])) {
    $a_id = $_POST['a_id'];
    $e_id = $_POST['e_id'];
    ?>
    <div class="modal fade " id="history_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                    <div class="col-md-12">
                    <table class="table table-sm table-bordered text-center table-responsive">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $conditon = array('a_id' => $a_id , 'e_id'=> $e_id ); 
                        $apayData = $obj->findWhereAll('authors_pay',$conditon,"all");
                            foreach ($apayData as $data): ?>
                            <tr>
                                <td><?php echo $data->ap_id ?></td>
                                <td><?php echo $data->pay_date ?></td>
                                <td><?php echo $data->pay_am ?></td>
                                <td><?php echo $data->remarks ?></td>
                                <td><button data-id="<?php echo $data->ap_id ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
                            </tr>
                           <?php endforeach ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>

    <?php 
}

?>
