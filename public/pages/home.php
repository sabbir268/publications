
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="container-fluid">
        <div class="row page-title clearfix">
            <div class="page-title-left">
                <h6 class="page-title-heading mr-0 mr-r-5">Dashboard</h6>
                <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p>
			</div>
            <!-- /.page-title-left -->
            <div class="page-title-right d-none d-sm-inline-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
					</li>
                    <li class="breadcrumb-item active">Home</li>
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
        <div class="widget-list row">
            <!-- /.widget-holder -->
            <div class="widget-holder widget-sm col-lg-3 col-md-6 widget-full-height">
                <div class="widget-bg bg-primary text-inverse">
                    <div class="widget-body">
                        <div class="counter-w-info media">
                            <div class="media-body w-50">
                            	<?php $tdate = date("Y-m-d"); $todayData = $obj->query("SELECT SUM(g_total_am) as 'total' , SUM(paid_am) as 'paid_am' , SUM(due_am) as 'due_am' FROM `orders_view` WHERE `order_date` = '$tdate' ","one"); ?>
                                <p class="text-muted mr-b-5 fw-600">Todays Sell Report:</p><span class="counter-title d-block"><span class="counter"></span></span>
                                <span class="bg-transparent fw-1000">Sell: <?php echo $todayData->total ?>/-</span><br>
                                <span class="bg-transparent fw-1000">Paid: <?php echo $todayData->paid_am ?>/-</span><br>
                                <span class="bg-transparent fw-1000">Due: <?php echo $todayData->due_am ?>/-</span>
							</div>
                            <!-- /.media-body -->
                            <div class="pull-right align-self-center">
                                <div class="mr-t-20"><span data-toggle="sparklines" data-height="40" data-width="100" data-type="bar" data-bar-spacing="3" data-bar-width="3" data-zero-axis="false" data-bar-color="rgba(144,186,236,1)" data-color-map="
                                    rgba(255,255,255,1.0);
									
                                    rgba(255,255,255,0.4);
									
                                    rgba(255,255,255,1.0);
									
                                    rgba(255,255,255,0.4);
									
                                    rgba(255,255,255,1.0);
									
                                    rgba(255,255,255,0.4);
									
                                    rgba(255,255,255,1.0);
									
                                    " data-chart-range-min="0"><!-- 4,7,8,5,3,6,8 --></span>
								</div>
							</div>
						</div>
                        <!-- /.counter-w-info -->
					</div>
                    <!-- /.widget-body -->
				</div>
                <!-- /.widget-bg -->
			</div>
            <!-- /.widget-holder -->
            <div class="widget-holder widget-sm col-lg-3 col-md-6 widget-full-height">
                <div class="widget-bg text-inverse" style="background: #43a2ff">
                    <div class="widget-body">
                    	<?php $stockData = $obj->query("SELECT SUM(stock) as 'stock' , SUM(total_sold) as 'sold' FROM `stock_view`", "one"); ?>
                        <div class="counter-w-info media">
                            <div class="media-body w-50">
                                <p class="text-muted mr-b-5 fw-600">Total Book report</p><span class="counter-title d-block"><span class="counter"></span></span>
                                <span class="bg-transparent fw-1000">Stock: <?php echo $stockData->stock ?> Copy</span><br>
                                <span class="bg-transparent fw-1000">Sold: <?php echo $stockData->sold ?> Copy</span>
                               
							</div>
                            <!-- /.media-body -->
                            <div class="pull-right align-self-center">
                                <div class="mr-t-20"><span data-toggle="sparklines" data-height="40" data-width="100" data-type="bar" data-bar-spacing="3" data-bar-width="3" data-zero-axis="false" data-bar-color="rgba(144,186,236,1)" data-color-map="
									
                                    rgba(255,255,255,1.0);
									
                                    rgba(255,255,255,0.4);
									
                                    rgba(255,255,255,1.0);
									
                                    rgba(255,255,255,0.4);
									
                                    rgba(255,255,255,1.0);
									
                                    rgba(255,255,255,0.4);
									
                                    rgba(255,255,255,1.0);
									
                                    " data-chart-range-min="0"><!-- 4,7,8,5,3,6,8 --></span>
								</div>
							</div>
						</div>
                        <!-- /.counter-w-info -->
					</div>
                    <!-- /.widget-body -->
				</div>
                <!-- /.widget-bg -->
			</div>
            <!-- /.widget-holder -->
            
				
				
                <div class="widget-holder widget-full-height col-md-6">
					<div class="widget-bg">
						<table class="table table-stripped m-3 text-center table-sm">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Authors Name</th>
									<th>Amount</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$autPayData = $obj->query("SELECT * FROM `authors_pay_view` LIMIT 10","all");
								foreach ($autPayData as $data) {
									?>
								<tr>
									<th><?php echo $data->ap_id ?></th>
									<th><?php echo $data->a_name ?></th>
									<th><?php echo $data->pay_am ?></th>
									<th><?php echo $data->pay_date ?></th>
								</tr>
									<?php 
								}
								 ?>

							</tbody>
						</table>
                        <!-- /.widget-bg -->
                        <a href="http://localhost/personal/publications/index.php?page=authorsrm" class="btn btn-link text-primary border-bottom">View More....</a>
					</div>
                    <!-- /.widget-holder -->
				</div>
				
				
				<div class="widget-holder widget-full-height col-lg-6">
					<div class="widget-bg">
						<div class="widget-heading">
							<h5 class="widget-title">Recent Activities <small>Updates</small></h5>
							<!-- /.widget-graph-info -->
						</div>
						<!-- /.widget-heading -->
						<div class="widget-body">
							<div class="widget-user-activities-3">
								
								<?php $logs = $userO->userLog(); ?>
								<?php foreach ($logs as $log): ?>
								<div class="single media active"><i class="list-icon material-icons">notifications_none</i>
									<div class="media-body">
										<p>
											<!-- User  -->
											<b><?php
												$user = $userO->find("users","id",$log->user_id);
												echo ucfirst($user->username);
											?></b>
											<!-- Log -->
										<?php echo $log->log ?> <i><?php echo timestamDateUser($log->created_at) ?></i> </p>
										<!-- time -->
										<small><?php echo timeAgo($log->created_at) ?></small>
									</div>
								</div>
								<?php endforeach ?>
								<!-- /.widget-user-activities-3 -->
							</div>
                            <!-- /.widget-body -->
						</div>
                        <!-- /.widget-bg -->
					</div>
                    <!-- /.widget-holder -->
				</div>
				
                <!-- /.widget-list -->
			</div>
            <!-- /.container-fluid -->
		</main>
        <!-- /.main-wrappper -->
	</div>
	
