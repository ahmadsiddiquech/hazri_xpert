<style type="text/css">
  @media print {
    * {
        -webkit-print-color-adjust: exact;
    }
    @page {
      size: landscape;
    }
  }
  table,th,td {
    border: 2px solid black;
    text-align: center;
    border-collapse: collapse;
    padding: 10px;
    font-size: 20px;
    font-weight: bolder;
  }
  .img-opacity {
    background-position: center;
    background-image: url("<?=STATIC_ADMIN_IMAGE.'logo.png'?>?>") !important;
    background-repeat: no-repeat;
  }
  div.transbox {
    margin: 30px;
    background-color: #ffffff;
    opacity: 0.8;
  }
  .border_top {
    border-top: 2px solid black;
    width: 200px;
  }
  .l-span{
    border-bottom: 1px solid black;
    width: 800px;
    display: inline-block;
    text-align: center;
  }
  .m-span{
    border-bottom: 1px solid black;
    width: 240px;
    display: inline-block;
    text-align: center;
  }
  .s-span  {
    border-bottom: 1px solid black;
    width: 120px;
    display: inline-block;
    text-align: center;
  }
</style>
<?php $i = 0 ?>
<div class="img-opacity">
  <div class="transbox">
  <div>
    <div style="float: left;">
      <img src="<?php echo STATIC_ADMIN_IMAGE.'logo.png'?>" height="120px;">
    </div>
    <div>
      <h1 style="text-align: center;">
      <?php echo $org[0]['org_name']; ?>
      </h1>
      <h4 style="text-align: center;">
        <?php echo $org[0]['org_address']; ?><br>
        Ph: <?php echo $org[0]['org_phone']; ?>
      </h4>
    </div>
  </div>
  <div style="text-align: center;"><h1>Timetable - <?php echo $timetable[0]['program_name'].' - '.$timetable[0]['class_name'].' - '.$timetable[0]['section_name'].' - '.$timetable[0]['day'];?></h1></div>
  <table width="100%" class="mt-5">
    <thead>
      <th>Sr.No</th>
      <th>Subject Name</th>
      <th>Start Time</th>
      <th>End Time</th>
    </thead>
    <tbody>
      <?php foreach ($timetable as $key => $value) { $i++?>
      <tr>
        <td><?=$i?></td>
        <td><?=$value['subject_name']?></td>
        <td><?=$value['start_time']?></td>
        <td><?=$value['end_time']?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
    <div style="text-align: center; padding-top: 10px;">
      <h5 class="border_top">Incharge's Signature</h5>
  </div>
 
  </div>
</div>
<p style="bottom: 0px;position: fixed;"><b> Powered by XpertSpot </b></p>

<script type="text/javascript">

window.print();

</script>