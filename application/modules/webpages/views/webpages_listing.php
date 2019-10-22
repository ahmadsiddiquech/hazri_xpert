 <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="sr" width="2%">S.No</th>
                        <th>Title</th>
                        <th class="" style="width:350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                if (isset($webpages)) {
                  $i=0;
                                    foreach ($webpages->result() as
                                            $row) {
                    $i++;   
                                        if (!isset($return_page))
                                            $return_page = 0;
                                        $manage_sub_page_url = ADMIN_BASE_URL . 'webpages/manage_sub_pages/' . $row->id ;
                                        $set_home_url = ADMIN_BASE_URL . 'webpages/set_home_page/' . $row->id;
                                        $set_publish_url = ADMIN_BASE_URL . 'webpages/set_publish/' . $row->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'webpages/set_unpublish/' . $row->id;

                                        $show_toppanel_url = ADMIN_BASE_URL . 'webpages/show_toppanel/' . $row->id;
                                        $remove_toppanel_url = ADMIN_BASE_URL . 'webpages/remove_toppanel/' . $row->id;

                                        $show_footer_url = ADMIN_BASE_URL . 'webpages/show_footer/' . $row->id;
                                        $remove_footer_url = ADMIN_BASE_URL . 'webpages/remove_footer/' . $row->id;

                                        $edit_url = ADMIN_BASE_URL . 'webpages/create/' . $row->id ;
                                        ?>
                                        <tr id="Row_<?= $row->id ?>" class="odd gradeX">
                                            <td class="table-checkbox"><?php echo $i; ?><!--<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>--></td>
                                            <td><?php echo $row->page_title; ?></td>
                                            <td class="table_action">
                                                <?php
                                                if ($row->page_type_id == 1) {
                                                    if ($row->is_home == 1)
                                                        echo '<span class="action_home btn blue c-btn homebtn"><i class="fa fa-home"></i></span>';
                            //echo anchor('javascript:;', '<i class="fa fa-home"></i>', array('class' => 'action_home btn blue c-btn','title' => 'Home page'));
                                                    else
                          echo anchor($set_home_url, '<i class="fa fa-home"></i>', array('class' => 'action_home btn default c-btn','title' => 'Set Home page'));
/*                                                  $publish_class = 'table_action_publish';
                                                    $publis_title = 'Set Un-Publish';

                                                    if ($row->is_publish != 1) {
                                                        $publish_class = 'table_action_unpublish';
                                                        $publis_title = 'Set Publish';
                                                    }
                                                    echo anchor('javascript:;', '&nbsp;', array('class' => 'action_publish ' . $publish_class, 'title' => $publis_title, 'rel' => $row->id, 'status' => $row->is_publish));*/
                          
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
                                                echo anchor('javascript:;', $icon, array('class' => 'action_publish ' . $publish_class . $iconbgclass, 'title' => $publis_title, 'rel' => $row->id,'id' => $row->id, 'status' => $row->is_publish));

                                                    /*$top_page_class = 'table_action_top_show';
                                                    $top_page_title = 'Remove form top panel';
                                                    if ($row->show_in_toppanel != 1)
                                                        $top_page_class = 'table_action_top_show_inactive';
                                                    $top_page_title = 'Set in top panel';
                                                    echo anchor('javascript:;', '&nbsp;', array('class' => 'action_top_page Record_' . $row->id . ' ' . $top_page_class, 'title' => $top_page_title, 'rel' => $row->id, 'status' => $row->show_in_toppanel));*/
                          
                          
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


//                                                    if ($row->show_in_footer == 1)
//                                                        echo anchor($remove_footer_url, '<img src="' . base_url() . 'static/admin/theme1/images/footer_show_active.png" title="Remove From Footer" />');
//                                                    else
//                                                        echo anchor($show_footer_url, '<img src="' . base_url() . 'static/admin/theme1/images/footer_show.png"  title="Show in Footer" />');

                                                    /*$footer_page_class = 'table_action_footer_show';
                                                    $footer_page_title = 'Remove form footer panel';
                                                    if ($row->show_in_footer != 1)
                                                        $footer_page_class = 'table_action_footer_show_inactive';
                                                    $footer_page_title = 'Set in footer panel';
                                                    echo anchor('javascript:;', '&nbsp;', array('class' => 'action_footer_page Record_footer' . $row->id . ' ' . $footer_page_class, 'title' => $footer_page_title, 'rel' => $row->id, 'status' => $row->show_in_footer));*/
                          
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
                          
                          
                          
                          
                          
                                            echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row->id, 'title' => 'Delete Webpage'));

                        echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Page'));
                                                   /* echo anchor($edit_url, '<img src="' . base_url() . 'static/admin/theme1/images/edit.png" title="Edit Page" />');*/

                                                    if ($row->is_home != 1){
                                                       /* echo anchor('javascript:;', '<img src="' . base_url() . 'static/admin/theme1/images/delete.png" title="Delete Page" />', array('class' => 'action_delete', 'rel' => $row->id, 'lang' => $row->lang_id));*/
                            
                          }
                                                    else
                                                        echo '';//<img src="' . base_url() . 'static/admin/theme1/images/delete_dull.png" title="Cannot Delete Home page" />;
                                                }
                                                else {
                                                    if ($row->is_home == 1)
                          echo anchor('javascript:;', '<i class="fa fa-home"></i>', array('class' => 'action_home btn blue c-btn','title' => 'Home page'));
                                                    else{
                          echo anchor($set_home_url, '<i class="fa fa-home"></i>', array('class' => 'action_home btn default c-btn','title' => 'Set Home page'));
                                                    //    echo anchor($set_home_url, '<img src="' . base_url() . 'static/admin/theme1/images/IsNotHome.png" title="Set Home page" />');
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