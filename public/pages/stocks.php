<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="container-fluid">
        <div class="row page-title clearfix">
            <div class="page-title-left">
                <h6 class="page-title-heading mr-0 mr-r-5">Stock</h6>
            </div>
            <!-- /.page-title-left -->
            <div class="page-title-right d-none d-sm-inline-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Book Stock</li>
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
                        <table class="table table-striped mt-1 text-center" data-toggle="datatables" data-plugin-options='{"searching": false}'>
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Book Name</th>
                                    <th>Edition</th>
                                    <th>Total Printed Copy</th>
                                    <th>In Stock</th>
                                    <th>Total Sold</th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php $stockData = $obj->all('stock_view') ?>
                                <?php foreach ($stockData as $stock): ?>
                                    <tr>
                                        <td><?php echo $stock->e_id; ?></td>
                                        <td><?php echo $stock->book_name; ?></td>
                                        <td><?php echo $stock->editions; ?></td>
                                        <td><?php echo $stock->total_copy; ?></td>
                                        <td><?php echo $stock->stock; ?></td>
                                        <td><?php echo $stock->total_sold; ?></td>
                                    </tr>
                                <?php endforeach ?>


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

</main>



<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>



