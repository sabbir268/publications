<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>

<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="container-fluid">
        <div class="row page-title clearfix">
            <div class="page-title-left">
                <h6 class="page-title-heading mr-0 mr-r-5">Invoice</h6>
            </div>
            <!-- /.page-title-left -->
            <div class="page-title-right d-none d-sm-inline-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Order Invoice </li>
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
    
    <?php 
    $cond = array('o_id' => $_GET['o_id']);

    $ordData = $obj->findWhereAll('orders_view',$cond,'one') ?>

    <div class="container-fluid">
        <div class="widget-list">
            <div class="row">
                <div class="col-md-12 widget-holder">
                    <div class="widget-bg p-3" id="invoice_area">
                     <div class="row">
                        <div class="col-md-12">
                            <div class="invoice-title">
                                <h2>Publications</h2><h3 class="pull-right">Order # <?php echo $ordData->o_id ?></h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $custData = $obj->find('customers','c_id',$ordData->c_id) ?>
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        <?php echo $custData->c_name ?>,<br>
                                        <?php echo $custData->c_phn ?>,<br>
                                        <?php echo $custData->c_mail ?>,<br>
                                        <?php echo $custData->c_addr ?><br>
                                    </address>
                                </div>
                                <div class="col-md-6 text-right">
                                     <address>
                                        <strong>Order Date:</strong><br>
                                        <?php echo date("d M  Y",strtotime($ordData->order_date)) ?><br><br>
                                        <strong>Payment Status:</strong><br>
                                        <?php echo $ordData->g_total_am == $ordData->paid_am ? "Paid" : "Unpaid"  ?><br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm text-center">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <th class="bg-light text-dark" colspan="6">Order Summury</th>
                                                </tr>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Unit Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th>Discount</th>
                                                    <th class="text-right">Totals</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php 
                                                $detalsData = $obj->findWhere('order_details_view','o_id',$ordData->o_id);
                                                foreach ($detalsData as $data) {
                                                    ?>
                                                    <tr>
                                                     <td><?php echo $data->book_name ?>(<?php echo $data->editions ?>)</td>
                                                     <td><?php echo $data->body_rate ?></td>
                                                     <td><?php echo $data->qty ?></td>
                                                     <td><?php echo $data->price ?></td>
                                                     <td><?php echo (($data->price*$data->disc_per)/100)+$data->disc_am ?></td>
                                                     <td class="text-right"><?php echo $data->t_price ?></td>
                                                     </tr>
                                                <?php 
                                                }
                                               ?>

                                            </tbody>

                                            <tfoot class="border border-light">
                                                <tr><td colspan="8" class="bg-light"></td></tr>
                                                <tr>
                                                    <th colspan="5" class="text-right">Total Price</th>
                                                    <th class="text-right"><?php echo $ordData->total_am ?></th>
                                                </tr>
                                                <tr >
                                                    <th colspan="5" class="text-right">Discount Percentage(<?php echo $ordData->disc_per ?>%)</th>
                                                    <th class="text-right"><?php echo $ordData->disc_per_am ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" class="text-right">Discount Amount</th>
                                                    <th class="text-right"><?php echo $ordData->disc_am ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" class="text-right">Grand Totals</th>
                                                    <th class="text-right"><?php echo $ordData->g_total_am ?></th>
                                                </tr>
                                                 <tr>
                                                    <th colspan="5" class="text-right">Paid Amount</th>
                                                    <th class="text-right"><?php echo $ordData->paid_am ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" class="text-right">Due Amount</th>
                                                    <th class="text-right"><?php echo $ordData->due_am ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-printer"></i>Print Invoice</button>

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


</main>
<?php unset($_SESSION['o_id']); ?>


<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>

