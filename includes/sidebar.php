<div class="content-wrapper">
	<!-- SIDEBAR -->
	<aside class="site-sidebar scrollbar-enabled" data-suppress-scroll-x="true">
		<!-- User Details -->
		<nav class="sidebar-nav">
			<ul class="nav in side-menu">
				<li class="current-page active">
					<a href="index.php"><i class="list-icon material-icons">home</i> <span class="hide-menu">Dashboard</span></a>

				</li>
				<li class="current-page">
						<a href="index.php?page=books">
							<i class="list-icon  fa fa-book"></i> <span class="hide-menu">Books</span>
						</a>
					</li>
				<!-- show Only admin login  -->
				<?php //if ($_SESSION['user_role'] === 'admin'): ?>
					<!--<li class="menu-item-has-children "><a href="javascript:void(0);"><i class="list-icon material-icons">apps</i> <span class="hide-menu">Users</span></a>
						<ul class="list-unstyled sub-menu">
							<li><a href="add.php?form=user">Add User</a>
								<li><a href="report.php?report=all_user_info">View Users</a>
								</li>
							</ul>
						</li>-->
					<?php //endif ?>

					<li class="menu-item-has-children current-page">
						<a href="javascript:void(0);"><i class="list-icon fa fa-users"></i><span class="hide-menu">Authors</span></a>
						<ul class="list-unstyled sub-menu">
							<li><a href="index.php?page=authors">Authors Info</a></li>
							<li><a href="index.php?page=authorsrm">Authors R.M</a>
								</li>
						</ul>
						</li>
					
					

					<li class="current-page">
						<a href="index.php?page=sell"><i class="list-icon fa fa-shopping-cart"></i> <span class="hide-menu">Sells</span></a>
					</li>

					<li class="current-page">
						<a href="index.php?page=customers"><i class="list-icon fa fa-user-plus"></i> <span class="hide-menu">Customer</span></a>
					</li>
					<li class="current-page">
						<a href="index.php?page=stocks"><i class="list-icon fa fa-cubes"></i> <span class="hide-menu">Stocks</span></a>
					</li>
					<li class="current-page">
						<a href="index.php?page=report"><i class="list-icon fa fa-bar-chart"></i> <span class="hide-menu">Report</span></a>
					</li>

				</ul>
				<!-- /.side-menu -->
			</nav>
			<!-- /.sidebar-nav -->
		</aside>
		<!-- /.site-sidebar -->

