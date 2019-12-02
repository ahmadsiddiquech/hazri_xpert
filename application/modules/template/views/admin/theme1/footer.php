    <!-- Page footer-->

    <footer><span>&copy; <script>document.write(new Date().getFullYear())</script> - Hazri Xpert</span></footer>

    </div><!-- wrapper div ends here -->

    

    

    <!-- MODERNIZR-->

    <script src="<?php echo STATIC_ADMIN_JS?>modernizr.js"></script>
    


    <!-- ===================== Toastr ========================= -->

    <script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>

    <script src="<?php echo STATIC_ADMIN_JS?>moment/min/moment-with-locales.min.js"></script>



    

    <!-- BOOTSTRAP-->

    <script src="<?php echo STATIC_ADMIN_JS?>bootstrap.js"></script>

    

    <!-- STORAGE API-->

    <script src="<?php echo STATIC_ADMIN_JS?>jquery.storageapi.js"></script>

    

    <!-- JQUERY EASING-->

    <script src="<?php echo STATIC_ADMIN_JS?>jquery.easing.js"></script>

    

    <!-- ANIMO-->

    <script src="<?php echo STATIC_ADMIN_JS?>animo.js"></script>



    <!-- BOOTSTRAP FILEUPLOAD-->

   <script src="<?php echo STATIC_ADMIN_JS?>bootstrap-fileupload.js"></script>

    

    <!-- SLIMSCROLL-->

    <script src="<?php echo STATIC_ADMIN_JS?>jquery.slimscroll.min.js"></script>

    

    <!-- SCREENFULL-->

    <script src="<?php echo STATIC_ADMIN_JS?>screenfull.js"></script>

    <!-- File upload Js -->

    



    <!-- file uplaod Js end -->

    

    <!-- LOCALIZE-->

    <script src="<?php echo STATIC_ADMIN_JS?>jquery.localize.js"></script>

        <!-- RTL demo-->

    <script src="<?php echo STATIC_ADMIN_JS?>demo-rtl.js"></script>

    <script src="<?php echo STATIC_ADMIN_JS?>notify.js"></script>

<script src="<?php echo STATIC_ADMIN_JS?>notify.min.js"></script>

    <!-- SWEET ALERT-->

    <script src="<?php echo STATIC_ADMIN_JS?>sweetalert.min.js"></script>





      <!-- PARSLEY FORM VALIDATION-->

   <script src="<?php echo STATIC_ADMIN_JS?>parsley.min.js"></script>

    

    <!-- DATATABLES-->

    <script src="<?php echo STATIC_ADMIN_JS?>jquery.dataTables.min.js"></script>

    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.colVis.js"></script>

    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.bootstrap.js"></script>

    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.bootstrapPagination.js"></script>

    <script src="<?php echo STATIC_ADMIN_JS?>demo-datatable.js"></script>

    <script src="<?php echo STATIC_ADMIN_JS?>bootstrap-datetimepicker.min.js"></script>


<!--    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script> -->
 
<!-- <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script> -->




   <!-- =============== APP SCRIPTS ===============-->

   <script src="<?php echo STATIC_ADMIN_JS?>app.js"></script>



	<div id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">

      <div class="modal-dialog">

         <div class="modal-content">

            <div class="modal-header">

               <button type="button" data-dismiss="modal" aria-label="Close" class="close">

                  <span aria-hidden="true">&times;</span>

               </button>

               <h4 id="myModalLabel" class="modal-title"><?php $module = $this->uri->segment(2); 

               if ($module=='outlet') {

                 $modal_title=str_replace($module,"Mosque",$module); echo ucfirst($modal_title); }

               else if ($module=='catagories') {

                 $modal_title='categories'; echo ucfirst($modal_title); }

                 else{

               $modal_title = preg_replace('/[^a-zA-Z0-9]+/', ' ', $module); echo ucfirst($modal_title); }?>&nbsp;Details</h4>

            

            </div>

            <div class="modal-body" style="margin-top:0px;"></div>

            <div class="modal-footer">

               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>

            </div>

         </div>

      </div>

   </div>



   <!-- Modal Large-->

   <div id="myModalLarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true" class="modal fade">

      <div class="modal-dialog modal-lg">

         <div class="modal-content">

            <div class="modal-header">

               <button type="button" data-dismiss="modal" aria-label="Close" class="close">

                  <span aria-hidden="true">&times;</span>

               </button>

               <h4 id="myModalLabelLarge" class="modal-title">Modal title</h4>

            </div>

              

              <h4 id="myModalLabel" class="modal-title"><?php $module = $this->uri->segment(2); 

               if ($module=='outlet') {

                 $modal_title=str_replace($module,"Mosque",$module); echo ucfirst($modal_title); }

                 else{

               $modal_title = preg_replace('/[^a-zA-Z0-9]+/', ' ', $module); echo ucfirst($modal_title); }?>&nbsp;Details</h4>



            <div class="modal-body">...</div>

            <div class="modal-footer">

               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>

            </div>

         </div>

      </div>

   </div>



   <!-- -==================== PAssword Model =================== -->

   <div id="password_Modal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true" class="modal fade">

      <div class="modal-dialog">

         <div class="modal-content">

            <div class="modal-header">

               <button type="button" data-dismiss="modal" aria-label="Close" class="close">

                  <span aria-hidden="true">&times;</span>

               </button>

               <h4 id="password_Modal_label" class="modal-title">Change Password</h4>

            

            </div>

            <div class="modal-body" style="margin-top: -30px;"></div>

            <div class="modal-footer">

               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>

            </div>

         </div>

      </div>

   </div>

</body>

<script type="text/javascript">

   $(document).ready(function() {



<?php 

$arrDate = $this->config->item('Date_Format_Type_JS');

$arrTime = $this->config->item('time_Format_Type_JS');

 ?>



    $('#datetimepicker1').datetimepicker({

      icons: {

          time: 'fa fa-clock-o',

          date: 'fa fa-calendar',

          up: 'fa fa-chevron-up',

          down: 'fa fa-chevron-down',

          previous: 'fa fa-chevron-left',

          next: 'fa fa-chevron-right',

          today: 'fa fa-crosshairs',

          clear: 'fa fa-trash'

        },

        //viewMode: 'years',

        format: '<?=$arrDate[DEFAULT_DATE_FORMAT]?>'

    });



     $('.datetimepicker2').datetimepicker({

      icons: {

          time: 'fa fa-clock-o',

          date: 'fa fa-calendar',

          up: 'fa fa-chevron-up',

          down: 'fa fa-chevron-down',

          previous: 'fa fa-chevron-left',

          next: 'fa fa-chevron-right',

          today: 'fa fa-crosshairs',

          clear: 'fa fa-trash'

        },

        //viewMode: 'years',

        format: '<?=$arrDate[DEFAULT_DATE_FORMAT]?>'

    });



     $('.datetimepicker3').datetimepicker({

      icons: {

          time: 'fa fa-clock-o',

          date: 'fa fa-calendar',

          up: 'fa fa-chevron-up',

          down: 'fa fa-chevron-down',

          previous: 'fa fa-chevron-left',

          next: 'fa fa-chevron-right',

          today: 'fa fa-crosshairs',

          clear: 'fa fa-trash'

        },

       format: '<?=$arrDate[DEFAULT_DATE_FORMAT]?> <?=$arrTime[DEFAULT_TIME_FORMAT]?>'

    });



       // only time

    $('.datetimepicker4').datetimepicker({

        format: 'LT'

    });





 });



  



    $(function(){ $('[data-load-css]').on('click', function (e) {

      var element = $(this);

      if(element.is('a'))

        e.preventDefault();

      var uri = element.data('loadCss'),

          link;

        if(uri) {

        link = createLink(uri);

        if ( !link ) {

          $.error('Error creating stylesheet link element.');

        }

      }

      else {

        $.error('No stylesheet location defined.');

      }

       //alert('uri' + uri);



     var res =  uri.slice(-5, -4);

       //alert('res==>' + res);

        $.ajax({

                    type: 'POST',

                    url: "<?=ADMIN_BASE_URL?>general_setting/update_theme",

                    data: {'uri': res},

                    async: false,

                    success: function(test_body) {



        

                    }

                });

      



    });

  });



    function createLink(uri) {

    var linkId = 'autoloaded-stylesheet',

        oldLink = $('#'+linkId).attr('id', linkId + '-old');



    $('head').append($('<link/>').attr({

      'id':   linkId,

      'rel':  'stylesheet',

      'href': uri

    }));



    if( oldLink.length ) {

      oldLink.remove();

    }



    return $('#'+linkId);

  }



 

       

</script>

<script type="text/javascript">



    $(function(){ $('[data-load-css]').on('click', function (e) {

      var element = $(this);

      if(element.is('a'))

        e.preventDefault();

      var uri = element.data('loadCss'),

          link;

        if(uri) {

        link = createLink(uri);

        if ( !link ) {

          $.error('Error creating stylesheet link element.');

        }

      }

      else {

        $.error('No stylesheet location defined.');

      }

       //alert('uri' + uri);



     var res =  uri.slice(-5, -4);

       //alert('res==>' + res);

        $.ajax({

                    type: 'POST',

                    url: "<?=ADMIN_BASE_URL?>general_setting/update_theme",

                    data: {'uri': res},

                    async: false,

                    success: function(test_body) {



        

                    }

                });

      



    });

  });



    function createLink(uri) {

    var linkId = 'autoloaded-stylesheet',

        oldLink = $('#'+linkId).attr('id', linkId + '-old');



    $('head').append($('<link/>').attr({

      'id':   linkId,

      'rel':  'stylesheet',

      'href': uri

    }));



    if( oldLink.length ) {

      oldLink.remove();

    }



    return $('#'+linkId);

  }



 

       

</script>