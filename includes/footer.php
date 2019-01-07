
<!-- DELETE  Modal -->
<div class="modal fade" id="confirmationDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Are you want to sure want to delete it?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				<button type="button" id="deleteBtn"  class="btn btn-danger">Confirm</button>
				<a href="" ></a>
			</div>
		</div>
	</div>
</div>

<!-- end Modal -->


<!-- /.content-wrapper -->
<!-- FOOTER -->
<!--<footer class="footer bg-primary text-inverse text-center">
	<div class="container-fluid"><span class="fs-13 heading-font-family">Copyright @ <?php echo date("Y"); ?>. All rights reserved <a class="fw-800" href="https://iamsabbir.me/">Design & Develop</a> by <a class="fw-800" href="http://iamsabbir.me">Sabbir Hossain</a></span>
	</div>
	<!-- /.container-fluid -
</footer>-->
</div>
<!--/ #wrapper -->
<!-- Scripts -->
<script src="<?php echo SITE_ROOT ?>vendor/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/metisMenu/2.7.9/metisMenu.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js"></script>
<script src="<?php echo SITE_ROOT ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/countup.js/1.9.2/countUp.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/moment.js/2.22.2/moment.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/Chart.js/2.7.2/Chart.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/select2/4.0.5/js/select2.min.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/select2/4.0.5/js/select2-bootstrap4.min.css"></script>
<script src="<?php echo SITE_ROOT ?>vendor/jqvmap/1.5.1/jquery.vmap.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/jqvmap/1.5.1/maps/jquery.vmap.usa.js"></script>
<script src="<?php echo SITE_ROOT ?>vendor/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script src="<?php echo SITE_ROOT ?>assets/js/template.js"></script>
<script src="<?php echo SITE_ROOT ?>assets/js/custom.js"></script>
<script src="<?php echo SITE_ROOT ?>assets/js/scripts.js"></script>
<script src="vendor/datatables/1.10.18/js/jquery.dataTables.min.js"></script>




<script>
$(document).ready(function() {
	$('.select2').select2();

	$('.dept_select2').select2({
		theme: "bootstrap4",
		width: '26%',
	});
	$('.roll_select2').select2({
		theme: "bootstrap4",
		width: 'resolve',
		 dropdownAutoWidth : true
	});

	$('.select2').select2();
	$('.sem_select2').select2({
		theme: "bootstrap4",
		width: 'resolve',
		 dropdownAutoWidth : true
	});
    $('.js-example-basic-multiple').select2();
    
});
</script>
</body>


</html>


