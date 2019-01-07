<?php
ob_start();

//incluing all php connection
require_once('app/init.php');


if ($userO->is_login() == false) {
     redirect("login.php");
}

 ?>
<?php require_once('includes/header.php') ?>
<?php require_once('includes/navbar.php') ?>
<?php require_once('includes/sidebar.php') ?>


<?php
	if(isset($_GET['page'])){
		$page='public/pages/'.$_GET['page'].".php";
	}
	else{
		$page="public/pages/home.php";
	}
	
	if(file_exists($page)){
		include $page;
	}
	else{
		$page="public/pages/home.php";
	}
	
?>

<?php require_once('includes/footer.php') ?>

