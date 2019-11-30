
                    <thead class="bg-th">
                          <tr>
                                <th width='2%'>S.No</th>
                                <th width="20%">Building Name</th>
                                <th width="20%">Address</th>
                                <th width="5%">city</th>
                                <th width="5%">zip</th>
                                <th width="50px">phone</th>
                                <th class="table_action">Action</th>
                          </tr>
                    </thead>
                    <tbody>
                      <?php
                    $i = 0;
                    if (isset($outlet)) {

                        foreach ($outlet as $row) {
                            $i++;
                            $edit_url = ADMIN_BASE_URL . 'outlet/create/' . $row['id'];                           
                        ?>
                    <tr id="Row_<?=$row['id']?>" class="odd gradeX">
                        <td width="2%"><?php echo $i;?></td>
                        <td width="20%"><?php echo $row['building_name']?></td>
                        <td width="20%"><?php echo $row['address']?></td>
                        <td width="5%"><?php echo $row['city']?></td>
                        <td width="5%"><?php echo $row['zip']?></td>
                        <td width="50px"><?php echo $row['phone']?></td>
                        <td class="table_action">
                        <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
                        <?php
                             echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Mosque'));
                             echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row['id'], 'title' => 'Delete Mosque'));                    
                        ?>
                        </td>
                    </tr>
                        <?php 
                            }
                        ?>
                        <?php } ?>
                    </tbody>
