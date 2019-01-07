<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="container-fluid">
        <div class="row page-title clearfix">
            <div class="page-title-left">
                <h6 class="page-title-heading mr-0 mr-r-5">Authos</h6>
            </div>
            <!-- /.page-title-left -->
            <div class="page-title-right d-none d-sm-inline-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Authors Info</li>
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
                        <button data-toggle="modal" data-target="#newCustomerModal" class="btn btn-primary btn-sm rounded-0 mt-3 ml-4"><i class="fa fa-plus"></i> &nbsp;Add New Customers</button>

                        <table class="table table-striped mt-0" data-toggle="datatables" data-plugin-options='{"searching": false}'>
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>E-Mail</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php $custData = $obj->all('customers') ?>
                                <?php foreach ($custData as $data): ?>
                                    <tr>
                                        <td><?php echo $data->c_id; ?></td>
                                        <td><?php echo $data->c_name; ?></td>
                                        <td><?php echo $data->c_phn; ?></td>
                                        <td><?php echo $data->c_mail; ?></td>
                                        <td><?php echo $data->c_addr; ?></td>
                                        <td><div class="btn-group"><button class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></div></td>
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
            <form action="app/action/addCustomers.php" method="POST" >
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



