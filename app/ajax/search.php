<?php require_once('../init.php');


if (isset($_POST['dept'])) {
    $roll = $_POST['roll'];
    $reg = $_POST['reg'];
    $sub = $_POST['sub'];
    $dept = $_POST['dept'];
    $datas = $dataO->searchSub($roll,$reg,$sub,$dept);

    if (count($datas) > 0) {


    ?>
    <?php foreach ($datas as $data): ?>
        <tr>
        <td><?php echo  $data->id ?></td>
        <td><?php echo $data->s_roll ?></td>
        <td><?php echo  $data->s_reg ?></td>
        <td><?php echo $data->sub; ?></td>
        <td><?php echo $data->dept; ?></td>
        <td><?php echo $data->stype; ?></td>
		</tr>
<?php endforeach ?>


<?php
    }else{
        echo "<tr><td colspan='6' class='text-center'>No data found</td></tr>";
    }
}





?>
