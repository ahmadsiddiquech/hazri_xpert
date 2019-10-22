<!-- Page content-->
<div class="content-wrapper">
    <h3>Webpages<a href="webpages/create"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="sr" width="2%">S.No</th>
                        <th>Title</th>
                        <th class="" style="width:350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody class="courser table-body">
                                <?php
                                if (isset($query)) {
                                     $i=0;
                                    foreach ($query->result() as $row) {
                                         $i++;   
                                        if (!isset($return_page))
                                        $return_page = 0;
                                        $manage_sub_page_url = ADMIN_BASE_URL . 'webpages/manage_sub_pages/' . $row->id ;
                                        $set_home_url = ADMIN_BASE_URL . 'webpages/set_home_page/' . $row->id;										
                                        $set_publish_url = ADMIN_BASE_URL . 'webpages/set_publish/' . $row->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'webpages/set_unpublish/' . $row->id;                                       
                                        $remove_toppanel_url = ADMIN_BASE_URL . 'webpages/remove_toppanel/' . $row->id;
                                        $show_footer_url = ADMIN_BASE_URL . 'webpages/show_footer/' . $row->id;
                                        $remove_footer_url = ADMIN_BASE_URL . 'webpages/remove_footer/' . $row->id;
                                        $edit_url = ADMIN_BASE_URL . 'webpages/create/' . $row->id ;
                                        ?>
                                        <tr id="Row_<?= $row->id ?>" class="odd gradeX">
                                            <td class="table-checkbox"><?php echo $i; ?><!--<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>--></td>
                                            <td><?php echo $row->page_title; ?></td>
                                            <td class="table_action">
                                            <a class="btn yellow c-btn view_details" rel="<?=$row->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                                <?php
                                                if ($row->page_type_id == 1) {
                                                    if ($row->is_home == 1)
                                                        echo '<span class="action_home btn blue c-btn homebtn"><i class="fa fa-home"></i></span>';
                                                    else
                                                     echo anchor($set_home_url, '<i class="fa fa-home"></i>', array('class' => 'action_home btn default c-btn','title' => 'Set Home page'));                          
                                                    $publish_class = 'table_action_publish';
                                                    $publis_title = 'Set Un-Publish';
                                                    $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                    $iconbgclass = ' btn green c-btn';
                                                if ($row->is_publish != 1) {
                                                    $publish_class = 'table_action_unpublish';
                                                    $publis_title = 'Set Publish';
                                                    $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                    $iconbgclass = ' btn default c-btn';
                                                }
                                                    $top_page_class = 'table_action_publish top_border';
                                                    $top_page_title = 'Remove form top panel';
                                                    $icon = '<i class="fa fa-chain"></i>';
                                                    $prefixID = 'asc';
                                                    $iconbgclass = ' btn green c-btn';
                                                if ($row->show_in_toppanel != 1) {
                                                    $top_page_class = 'table_action_unpublish top_border';
                                                    $top_page_title = 'Show in top panel';
                                                    $icon = '<i class="fa fa-chain-broken"></i>';
                                                    $prefixID = 'desc';
                                                    $iconbgclass = ' btn default c-btn';
                                                        }               
                                                    echo anchor('javascript:;', $icon, array('class' => 'action_top_page ' . $top_page_class . $iconbgclass, 'title' => $top_page_title, 'rel' => $row->id, 'id' => $prefixID.'-'.$row->id, 'status' => $row->show_in_toppanel));
                                                    $footer_page_class = 'table_action_publish bottom_border';
                                                    $footer_page_title = 'Remove form footer panel';
                                                    $icon = '<i class="fa fa-chain bottom_border"></i>';
                                                    $prefixID = 'footer_on';
                                                    $iconbgclass = ' btn green c-btn';
                                                if ($row->show_in_footer != 1) {
                                                    $footer_page_class = 'table_action_unpublish bottom_border';
                                                    $footer_page_title = 'Show in footer panel';
                                                    $icon = '<i class="fa fa-chain-broken"></i>';
                                                    $prefixID = 'footer_off';
                                                    $iconbgclass = ' btn default c-btn';
                                                }
                                                   echo anchor('javascript:;', $icon, array('class' => 'action_footer_page ' . $footer_page_class . $iconbgclass, 'title' => $footer_page_title, 'rel' => $row->id,'id' => $prefixID.'-'.$row->id, 'status' => $row->show_in_footer));
						                           echo anchor($manage_sub_page_url, '<i class="fa fa-sitemap" title="Manage Sub Pages" ></i>','class="btn purple c-btn"');
                                                   echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Page'));
                                                   echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row->id, 'title' => 'Delete Webpage'));
                                                    if ($row->is_home != 1){
                                                                                    }
                                                    else
                                                        echo '';
                                                }
                                                else {
                                                    if ($row->is_home == 1)
                                                    echo anchor('javascript:;', '<i class="fa fa-home"></i>', array('class' => 'action_home btn blue c-btn','title' => 'Home page'));
                                                    else{
                                                    echo anchor($set_home_url, '<i class="fa fa-home"></i>', array('class' => 'action_home btn default c-btn','title' => 'Set Home page'));
                                                     }
                                                    $publish_class = 'table_action_publish';
                                                    $publis_title = 'Set Un-Publish';
                                                    $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                    $iconbgclass = ' btn green c-btn';
                                                if ($row->is_publish != 1) {
                                                    $publish_class = 'table_action_unpublish';
                                                    $publis_title = 'Set Publish';
                                                    $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                    $iconbgclass = ' btn default c-btn';
                                                }
                                                if ($row->is_home != 1){
                                                echo anchor('javascript:;', $icon, array('class' => 'action_publish ' . $publish_class . $iconbgclass, 'title' => $publis_title, 'rel' => $row->id,'id' => $row->id, 'status' => $row->is_publish));
                                                        }
                                                    echo nbs(3);
                                                    echo 'Static Page';
                                                    echo nbs(6);
                                                }

                                                ?>
                                            </td>
                                        </tr>  
                                    <?php }
                                }
                                ?>
                            </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    
<script type="application/javascript">
$(document).ready(function(){
 $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Webpage?",
                text : "You will not be able to recover this Webpage!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                       $.ajax({
							type: 'POST', 
                            url: "<? ADMIN_BASE_URL?>webpages/delete",
                            data: {'id': id},
                            async: false,
                            success: function() {
                                $("#datatable1").load("<? ADMIN_BASE_URL?>webpages/load_listing");
                            }
                        });
                swal("Deleted!", "Webpage has been deleted.", "success");

              });

            });
			
 $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?=ADMIN_BASE_URL?>webpages/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                        //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                        $('#myModal').modal('show')
                        //$("#myModal .modal-title").html(test_title);
                        $("#myModal .modal-body").html(test_desc);
                        }
                    });
            });
$(document).on("click", ".action_top_page", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var ID = $(this).attr('id');
            var status = $(this).attr('status');
            $.ajax({
                type: 'POST',
                url: "<?=ADMIN_BASE_URL ?>webpages/change_top_panel_pages",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if (result != false) {
                        if (status == '1') {
                            $('#' + ID).removeClass('green').addClass('default');
                            $('#'+ID).find('i.fa-chain').removeClass('fa-chain').addClass('fa-chain-broken');
                            $('#' + ID).attr('status','0');
                            
                        } else {
                            $('#' + ID).removeClass('default').addClass('green');
                            $('#'+ID).find('i.fa-chain-broken').removeClass('fa-chain-broken').addClass('fa-chain');
                            $('#' + ID).attr('status','1');
                        }
                        toastr.success('Successfully Done');
                    } else if (result == false) {

                        toastr.error('More than 5 pages cannot be showed for top-panel.');

                    }

                }
            });

        });

$(document).on("click", ".action_footer_page", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var ID = $(this).attr('id');
            var status = $(this).attr('status');
            $.ajax({
                type: 'POST',
                url: "<?=ADMIN_BASE_URL ?>webpages/change_footer_panel_pages",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if (result != false) {
                        if (status == '1') {
                            $('#' + ID).removeClass('green').addClass('default');
                            $('#'+ID).find('i.fa-chain').removeClass('fa-chain').addClass('fa-chain-broken');
                            $('#' + ID).attr('status','0');
                        } else {
                            $('#' + ID).removeClass('default').addClass('green');
                            $('#'+ID).find('i.fa-chain-broken').removeClass('fa-chain-broken').addClass('fa-chain');
                            $('#' + ID).attr('status','1');
                        }
                        toastr.success(' Successfully Done ');
                    } 

                }
            });

        });
    $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?=ADMIN_BASE_URL ?>catagories/change_status_category",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if($('#'+id).hasClass('default')==true)
                    {
                        $('#'+id).addClass('green');
                        $('#'+id).removeClass('default');
                        $('#'+id).find('i.fa-long-arrow-down').removeClass('fa-long-arrow-down').addClass('fa-long-arrow-up');
                    }else{
                        $('#'+id).addClass('default');
                        $('#'+id).removeClass('green');
                        $('#'+id).find('i.fa-long-arrow-up').removeClass('fa-long-arrow-up').addClass('fa-long-arrow-down');
                    }
                   // $("#listing").load('<?php ADMIN_BASE_URL?>appligion/manage_record');
                    toastr.success('Status Changed Successfully');
                }
            });
            if (status == 1) {
                $(this).removeClass('table_action_publish');
                $(this).addClass('table_action_unpublish');
                $(this).attr('title', 'Set Publish');
                $(this).attr('status', '0');
            } else {
                $(this).removeClass('table_action_unpublish');
                $(this).addClass('table_action_publish');
                $(this).attr('title', 'Set Un-Publish');
                $(this).attr('status', '1');
            }
           
        });
    
});
</script>