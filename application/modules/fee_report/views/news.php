<style type="text/css">
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: center;    
}
</style>
<?php if(isset($report) && !empty($report)) {
$total = 0;
$remaining =0;
$paid = 0;
date_default_timezone_set("Asia/Karachi");
} ?>
<table style="text-align: center;width: 100%" >
    <thead>
        <tr>
            <td colspan="2"><img src="<?php echo STATIC_ADMIN_IMAGE.'logo.png'?>" height="60px;"> <p style="padding-bottom: 10px"><b> <?=$report[0]['org_name']?></b></p></td>
            <td colspan="2"><b> <?php echo $report[0]['program_name'].'-'.$report[0]['class_name'].'-'.$report[0]['section_name'].' Monthly Fee Report for '.$report[0]['issue_date']; ?></b></td>
            <th colspan="2">
                <?=date('d-m-Y')?>
            </th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Roll No</th>
            <th>Parent Name</th>
            <th>Fee</th>
            <th>Paid</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($report as $key => $value) { ?>
            <tr>
                <td><?=$value['std_name']?></td>
                <td><?=$value['std_roll_no']?></td>
                <td><?=$value['parent_name']?></td>
                <td><?=$value['total']?></td>
                <td><?=$value['paid']?></td>
                <td><?=$value['remaining']?></td>
            </tr>
        <?php 
            $total = $total + $value['total'];
            $remaining = $remaining + $value['remaining'];
            $paid = $paid + $value['paid'];
        } ?>
        <tr>
            <th colspan="2">Total : <?=$total?></th>
            <th colspan="2">Paid : <?=$paid?></th>
            <th colspan="2">Balance : <?=$remaining?></th>
        </tr>
    </tbody>
</table>