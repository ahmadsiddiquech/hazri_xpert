<thead class="bg-th">
                            <tr class="bg-col">
                                <th width='2%'>S.No</th>
                                <th>User Name</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th width="350px">Actions</th>
                          </tr>
                    </thead>
                            <tbody class="table-body">
                             <?php
                    $i = 0;
                    if (isset($users_rec)) {
                        foreach ($users_rec as $row) {
                            $i++;
                            $edit_url = ADMIN_BASE_URL . 'organizations/create/' . $row['id']; 
                           
                        ?>
                    <tr id="Row_<?=$row['id']?>" class="odd gradeX">
                        <td width='2%'><?php echo $i;?></td>
                        <td><?php echo $row['user_name']?></td>
                        <td><?php echo $row['first_name']." ".$row['last_name']?></td>
                        <td><?php echo $row['email']?></td>
                        <td><?php echo $row['phone']?></td>
                

                       <td class="table_action">
                             <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
                            <?php
                             echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit organizations'));

                             echo anchor('javascript:;', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 
                             'rel' => $row['id'], 'title' => 'Delete User'));
                            
                            ?>
                      
                            <?php
                             $publish_class = ' table_action_publish';
                                $publis_title = 'Set Un-Publish';
                                $icon = '<i class="fa fa-long-arrow-up"></i>';
                                $iconbgclass = ' btn green c-btn';
                                 if ($row['status'] != 1) {
                                     $publish_class = ' table_action_unpublish';
                                 $publis_title = 'Set Publish';
                                     $icon = '<i class="fa fa-long-arrow-down"></i>';
                                     $iconbgclass = ' btn default c-btn';
                                }
                             echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass, 
                             'title' => $publis_title,'rel' => $row['id'],'id' => $row['id'], 'status' => $row['status']));
    
                            ?>
                        </td>
                    </tr>
                      <?php 
                        }
                    ?>
                      <?php } ?>
                            </tbody>