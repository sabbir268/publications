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
                        <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-sm rounded-0 mt-3 ml-4"><i class="fa fa-plus"></i> &nbsp;Add New Authors</button>

                        <table class="table table-striped mt-0" data-toggle="datatables" data-plugin-options='{"searching": false}'>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author Name</th>
                                    <th>Phonoe</th>
                                    <th>Author Addrss</th>
                                    <th>Total Books</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php $authData = $obj->all('authors') ?>
                                <?php foreach ($authData as $auth): ?>
                                    <tr>
                                        <td><?php echo $auth->a_id; ?></td>
                                        <td><?php echo $auth->a_name; ?></td>
                                        <td><?php echo $auth->a_phn; ?></td>
                                        <td><?php echo $auth->a_addr; ?></td>
                                        <td><?php $tAuth = $obj->query("SELECT COUNT(a_id) as 't_auth' FROM book_auth WHERE a_id =".$auth->a_id."","one" ); echo $tAuth->t_auth; ?></td>
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


<!-- Modal -->
<div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Authors</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">



        <form id="auth_form" action="app/action/addAuthors.php" method="POST">
            <!--  author name -->
             <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text btn-primary rounded-0">Name</span>
                </div>
                <input name="a_name" id="a_nmae" class="form-control" required >
            </div>
            <!--.  author name end-->

            <!--  author phone  -->
             <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text btn-primary rounded-0">Contact Number</span>
                </div>
                <input name="a_phn" id="a_phn" class="form-control" required >
            </div>
            <!--.  author phone  end -->

            <!--  author phone  -->
             <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text btn-primary rounded-0">Address</span>
                </div>
                <input name="a_addr" id="a_addr" class="form-control" required >
            </div>
            <!--.  author phone  end -->



</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
    <button id="submit_auth_form" name="submit_auth_form" type="submit" class="btn btn-primary btn-sm rounded-0">Save</button>

</form>
</div>
</div>
</div>
</div>
</main>



<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>



