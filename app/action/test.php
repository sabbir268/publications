<?php
error_reporting(0);
require_once('../init.php');
$tdate = date("Y-m-d");
echo $tdate;
$todayData = $obj->query("SELECT SUM(g_total_am) as 'total' , SUM(paid_am) , SUM(due_am) FROM `orders_view` WHERE `order_date` = '$tdate' ","one");
var_dump($todayData);

?>

