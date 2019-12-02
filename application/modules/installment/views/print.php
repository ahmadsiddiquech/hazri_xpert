
<style type="text/css">
  table {
    border: 2px solid black;
  }
  .border_bottom {
    border-bottom: 2px solid black;
  }
  .border_left {
    border-left: 2px solid #919191;
    padding-left: 5px;
  }
</style>
<?php foreach ($news as $key => $value) { ?>
<table>
  <tr>
    <td>
      <table style="text-align: left;" >
      <tbody>
        <tr>
          <th colspan="4">Bank Copy</th>
        </tr>
        <tr>
          <td colspan="1"><img src="<?php echo STATIC_ADMIN_IMAGE.'logo.png'?>" height="60px;"></td>
          <td colspan="3"> <?php echo $value['org_name']; ?> <br> <b>F.T.N</b>1234455</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Account No: </th>
          <td colspan="1">012342</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Account Title:</th>
          <td colspan="2"><?php echo $value['org_name']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2"><b>Challan No:</th>
          <th colspan="1"></th>
          <th colspan="1"><b>Due Date:</th>
        </tr>
        <tr>
          <td colspan="2"> <?php echo $value['std_voucher_id']; ?></td>
          <th></th>
          <td colspan="2"><?php echo $value['due_date']; ?></td>
          <th></th>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Name</th>
          <td class="border_left" colspan="2"> <?php echo $value['std_name']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Registration No.</th>
          <td class="border_left" colspan="2"><?php echo $value['std_id']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">CNIC</th>
          <td class="border_left" colspan="2">31302-3387651-1</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <td colspan="2"><b>Fee Code:</b> 001</td>
          <td class="border_left" colspan="2"><b>Fee Type:</b> Semester fee</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <th colspan="3">Particular</th>
          <th colspan="1" class="border_left">Amount(Rs)</th>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Tution Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['tution_fee']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Transportation Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['transport_fee']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Lunch Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['lunch_fee']; ?></td>
        </tr><tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <th colspan="3">Total</th>
          <td colspan="1" class="border_left"><?php echo $value['total']; ?></td>
        </tr>
        </tr><tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align:center;">
          <th colspan="2" style="padding-top: 50px;">Officer</th>
          <th colspan="2" style="padding-top: 50px;" class="border_left">Cashier</th>
        </tr>
      </tbody>
    </table>
  </td>
    <td>
      <table style="text-align: left;" >
      <tbody>
        <tr>
          <th colspan="4">School Copy</th>
        </tr>
        <tr>
          <td colspan="1"><img src="<?php echo STATIC_ADMIN_IMAGE.'logo.png'?>" height="60px;"></td>
          <td colspan="3"> <?php echo $value['org_name']; ?> <br> <b>F.T.N</b>1234455</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Account No: </th>
          <td colspan="1">012342</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Account Title:</th>
          <td colspan="2"><?php echo $value['org_name']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2"><b>Challan No:</th>
          <th colspan="1"></th>
          <th colspan="1"><b>Due Date:</th>
        </tr>
        <tr>
          <td colspan="2"> <?php echo $value['std_voucher_id']; ?></td>
          <th></th>
          <td colspan="2"><?php echo $value['due_date']; ?></td>
          <th></th>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Name</th>
          <td class="border_left" colspan="2"> <?php echo $value['std_name']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Registration No.</th>
          <td class="border_left" colspan="2"><?php echo $value['std_id']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">CNIC</th>
          <td class="border_left" colspan="2">31302-3387651-1</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <td colspan="2"><b>Fee Code:</b> 001</td>
          <td class="border_left" colspan="2"><b>Fee Type:</b> Semester fee</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <th colspan="3">Particular</th>
          <th colspan="1" class="border_left">Amount(Rs)</th>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Tution Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['tution_fee']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Transportation Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['transport_fee']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Lunch Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['lunch_fee']; ?></td>
        </tr><tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <th colspan="3">Total</th>
          <td colspan="1" class="border_left"><?php echo $value['total']; ?></td>
        </tr>
        </tr><tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align:center;">
          <th colspan="2" style="padding-top: 50px;">Officer</th>
          <th colspan="2" style="padding-top: 50px;" class="border_left">Cashier</th>
        </tr>
      </tbody>
    </table>
    </td>
    <td>
      <table style="text-align: left;" >
      <tbody>
        <tr>
          <th colspan="4">Student Copy</th>
        </tr>
        <tr>
          <td colspan="1"><img src="<?php echo STATIC_ADMIN_IMAGE.'logo.png'?>" height="60px;"></td>
          <td colspan="3"> <?php echo $value['org_name']; ?> <br> <b>F.T.N</b>1234455</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Account No: </th>
          <td colspan="1">012342</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Account Title:</th>
          <td colspan="2"><?php echo $value['org_name']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2"><b>Challan No:</th>
          <th colspan="1"></th>
          <th colspan="1"><b>Due Date:</th>
        </tr>
        <tr>
          <td colspan="2"> <?php echo $value['std_voucher_id']; ?></td>
          <th></th>
          <td colspan="2"><?php echo $value['due_date']; ?></td>
          <th></th>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Name</th>
          <td class="border_left" colspan="2"> <?php echo $value['std_name']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">Registration No.</th>
          <td class="border_left" colspan="2"><?php echo $value['std_id']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <th colspan="2">CNIC</th>
          <td class="border_left" colspan="2">31302-3387651-1</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr>
          <td colspan="2"><b>Fee Code:</b> 001</td>
          <td class="border_left" colspan="2"><b>Fee Type:</b> Semester fee</td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <th colspan="3">Particular</th>
          <th colspan="1" class="border_left">Amount(Rs)</th>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Tution Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['tution_fee']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Transportation Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['transport_fee']; ?></td>
        </tr>
        <tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <td colspan="3">Lunch Fee</td>
          <td colspan="1" class="border_left"><?php echo $value['lunch_fee']; ?></td>
        </tr><tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align: center;">
          <th colspan="3">Total</th>
          <td colspan="1" class="border_left"><?php echo $value['total']; ?></td>
        </tr>
        </tr><tr>
          <th class="border_bottom" colspan="100%"></th>
        </tr>
        <tr style="text-align:center;">
          <th colspan="2" style="padding-top: 50px;">Officer</th>
          <th colspan="2" style="padding-top: 50px;" class="border_left">Cashier</th>
        </tr>
      </tbody>
    </table>
    </td>
  </tr>
</table>
<p style="page-break-after: always"> </p>
<!-- <br><br><br><br><br><br><br><br><br><br><br> -->

<?php } ?>
<script type="text/javascript">

window.print();

</script>