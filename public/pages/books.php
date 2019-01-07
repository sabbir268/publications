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
            <h6 class="page-title-heading mr-0 mr-r-5">Books</h6>
         </div>
         <!-- /.page-title-left -->
         <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="#">Dashboard</a>
               </li>
               <li class="breadcrumb-item active">Books Info</li>
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
                  <button data-toggle="modal" data-target="#bookAddModal" class="btn btn-primary btn-sm rounded-0 mt-3 ml-4"><i class="fa fa-plus"></i> &nbsp;Add New</button>
                  <button data-toggle="modal" data-target="#PrintingModal" class="btn btn-success btn-sm rounded-0 mt-3 ml-4"><i class="fa fa-cog"></i> &nbsp; Printing</button>


                  <table class="table table-striped text-center mt-0" data-toggle="datatables" data-plugin-options='{"searching": "true"}'>
                     <thead>
                        <tr>
                           <th>Id</th>
                           <th>Book Name</th>
                           <th>Book ISBN</th>
                           <th>Author(s)</th>
                           <th>Edition</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $bookData = $obj->all('books') ?>
                        <?php foreach ($bookData as $book): ?>
                           <tr>
                              <td><?php echo $book->b_id; ?></td>
                              <td class="text-left"><?php echo $book->b_name; ?></td>
                              <td><?php echo $book->b_isbn; ?></td>
                              <td><?php 
                              $authData = $obj->findWhere('book_auth_view','b_id',$book->b_id);
                              foreach ($authData as $auth){
                               ?>
                              <a href="#" class="text-info border-bottom"> <?php echo $auth->a_name ?></a> &nbsp;
                              <?php 
                            }
                            ?></td>
                            <td><?php echo $obj->totalCountWhere('editions','b_id',$book->b_id); ?></td>
                            <td>
                              <div class="btn-group"><button class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></div>
                           </td>
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
<div class="modal fade" id="bookAddModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Books</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="submit_book_form" action="app/action/addBooks.php" method="POST">
               <!--  author name -->
               <div class="input-group mb-3">
                  <div class="input-group-prepend">
                     <span class="input-group-text btn-primary rounded-0">Name</span>
                  </div>
                  <input name="b_name" id="b_name" class="form-control" required >
               </div>
               <!--.  author name end-->
               <!--  author phone  -->
               <div class="input-group mb-3">
                  <div class="input-group-prepend">
                     <span class="input-group-text btn-primary rounded-0">ISBN</span>
                  </div>
                  <input name="b_isbn" id="b_isbn" class="form-control" required >
               </div>
               <!--.  author phone  end -->
               <!--  author phone  -->
               <div class="input-group mb-3">
                  <div class="input-group-prepend">
                     <span class="input-group-text btn-primary rounded-0">Authors</span>
                  </div>
                  <select  id="b_auth" class="js-example-basic-multiple form-control" name="b_auth[]" multiple="multiple" required>
                     <?php $authData = $obj->all('authors') ?>
                     <?php foreach ($authData as $auth): ?>
                        <option value="<?php echo $auth->a_id; ?>"><?php echo $auth->a_name; ?></option>
                     <?php endforeach ?>
                  </select>
               </div>
               <!--.  author phone  end -->
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
               <button id="submit_auth_form" name="submit_book_form" type="submit" class="btn btn-primary btn-sm rounded-0">Save</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="PrintingModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Printing</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="printingEdition" action="app/action/addEditions.php" method="POST">
               <div class="row">
                  <div class="col-md-7">
                     <div class="input-group mb-0">
                        <div class="input-group-prepend">
                           <span class="input-group-text btn-primary rounded-0">Name</span>
                        </div>
                        <select  id="b_id" class="select2 form-control" name="b_id" required>
                           <option value="">Select Book..</option>
                           <?php $bookData = $obj->all('books') ?>
                           <?php foreach ($bookData as $book): ?>
                              <option value="<?php echo $book->b_id; ?>"><?php echo $book->b_name; ?></option>
                           <?php endforeach ?>
                        </select>
                     </div>
                     <!--.  book name end-->
                     <div class="input-group mb-0">
                        <button type="button" id="chekPrinter"  class="btn bg-transparent"><input type="checkbox" id="chekboxPr" name="check"  value="1" >New Printer</button>
                     </div>
                     <!--  Printers  -->
                     <div class="input-group mb-3 printerso">
                        <div class="input-group-prepend">
                           <span class="input-group-text btn-primary rounded-0">Printer</span>
                        </div>
                        <select  id="p_id" class="select2 form-control" name="p_id" >
                           <option value="">Select Printer..</option>
                           <?php $printersData = $obj->all('printers') ?>
                           <?php foreach ($printersData as $printer): ?>
                              <option value="<?php echo $printer->p_id; ?>"><?php echo $printer->p_name; ?></option>
                           <?php endforeach ?>
                        </select>
                     </div>
                     <div class="input-group mb-3 printers" >
                        <div class="input-group-prepend">
                           <span class="input-group-text btn-primary rounded-0">Printer Name</span>
                        </div>
                        <input name="p_name" id="p_name" class="form-control"  >
                     </div>
                     <div class="input-group mb-3 printers">
                        <div class="input-group-prepend">
                           <span class="input-group-text btn-primary rounded-0">Printer Address</span>
                        </div>
                        <input name="p_addr" id="p_addr" class="form-control"  >
                     </div>
                     <!--  Printers  End-->
                     <div class="input-group mb-3 ">
                        <div class="input-group-prepend">
                           <span class="input-group-text btn-primary rounded-0">Print Date</span>
                        </div>
                        <input type="date" name="pr_date" id="pr_date" class="form-control" required >
                        <span class="btn btn-secondary rounded-0"><i class="fa fa-calendar"></i></span>
                     </div>
                  </div>
                  <div class="col-md-5">
                     <!--  book name -->
                     <div class="input-group mb-4 ">
                        <div class="input-group-prepend">
                           <span class="input-group-text btn-primary rounded-0">Total Copy</span>
                        </div>
                        <input name="ttl_copy" id="ttl_copy" class="form-control" required >
                     </div>
                     <div class="input-group mb-4 ">
                        <div class="input-group-prepend">
                           <span class="input-group-text btn-primary rounded-0">Cost Per Copy</span>
                        </div>
                        <input name="pr_cost" id="pr_cost" class="form-control" required >
                     </div>
                     <div class="input-group mb-4">
                        <div class="input-group-prepend">
                           <span class="input-group-text btn-primary rounded-0">Body Price</span>
                        </div>
                        <input name="b_price" id="b_price" class="form-control" required >
                     </div>

                  </div>
               </div>
               <hr>
               <div class="row sr-only" id="arm_section">
                  <div class="col-md-6 offset-md-3">
                     <div class="input-group mb-0 mb-2 border-bottom bg-dark">
                        <button type="button"  class="btn bg-transparent">Author(s) Respect Money</button>
                     </div>
                     <div id="authorsRmAm">
                        
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
               <button id="submit_printig_form" name="submit_printig_form" type="submit" class="btn btn-primary btn-sm rounded-0">Save</button>
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
<script>
 $(document).ready(function() {
  $('.printers').hide();

  $("#chekPrinter").click(function(event) {
   if($('input#chekboxPr').is(':checked') == false){
    $('#chekboxPr').attr('checked',true);
    $('.printerso').hide();
    $('.printers').show();
 }
 else{
    $('#chekboxPr').attr('checked',false);   
    $('.printerso').show();
    $('.printers').hide();
 }
});

$('select#b_id').change(function(event) {
   $book_id = $(this).val();
   $.post('app/ajax/armam.php', {b_id: $book_id}, function(data) {
      $('#arm_section').removeClass('sr-only');
      $('#authorsRmAm').html(data);
   });
});

});
</script>