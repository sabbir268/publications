<main class="main-wrapper clearfix">
	<!-- Page Title Area -->
	<div class="container-fluid">
		<div class="row page-title clearfix">
			<div class="page-title-left">
				<h6 class="page-title-heading mr-0 mr-r-5">Order/Sell Report</h6>
			</div>
			<!-- /.page-title-left -->
			<div class="page-title-right d-none d-sm-inline-flex">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Dashboard</a>
					</li>
					<li class="breadcrumb-item active">Report</li>
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
							<table class="table table-striped mt-0" data-toggle="datatables" data-plugin-options='{"searching": false}'>
								<thead>
									<tr>
										<th>Sl No</th>
										<th>Customer</th>
										<th>Total Item</th>
										<th>Total Amount</th>
										<th>Paid Amount</th>
										<th>Due Amount</th>
										<th>Action</th>
									</tr>
								</thead>


								<tbody>
									<?php $ordersData = $obj->all("orders_view"); ?>
									<?php foreach ($ordersData as $data): ?>

										<tr>
											<td><?php echo $data->o_id; ?></td>
											<td><?php $custData = $obj->find('customers','c_id',$data->c_id); echo $custData->c_name ?></td>
											<td><?php echo $data->total_item; ?></td>
											<td><?php echo $data->total_am; ?></td>
											<td><?php echo $data->paid_am; ?></td>
											<td><?php echo $data->due_am; ?></td>
											<td><a href="index.php?page=invoice&o_id=<?php echo $data->o_id; ?>" class="btn btn-sm btn-success rounded-0"><i class="fa fa-eye"> View Invoice</i></a></td>
										</tr>
									<?php endforeach ?>


								</tbody>
							</table>
						
						<!-- /.widget-body -->
						</div>
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
</main>
</div>