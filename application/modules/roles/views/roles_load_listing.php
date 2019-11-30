<thead class="bg-th">
                        <tr class="bg-col">
                        <th width='2%'>S.No</th>
                        <th>Title</th>
                        <th class="" style="width:200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>

                        <tbody class="courser table-body">
                        <?php
                        $i = 0;
                        if (isset($roles)) { foreach ($roles as $row) {
                            $i++;
                            $edit_url = ADMIN_BASE_URL . 'roles/create/' . $row['id']; 
                            ?>
                            <tr id="Row_<?=$row['id']?>" class="odd gradeX">
                            <td class="sr"><?php echo $i;?></td>
                            <td><?php echo $row['role']?></td>
                            <td class="table_action action">
                            <!-- <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a> -->
                            <!--<a class="fancybox btn yellow c-btn" data-target="#myModal" data-toggle="modal" href="#description_<?= $row['id'] ?>" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>-->
                            <?php
                            $permission_url = ADMIN_BASE_URL . 'permission/manage/'.$row['id'].'/'.$row['outlet_id'].'/'.$row['role'];

                            echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Roles'));
echo anchor('javascript:;', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 
                            'rel' => $row['id'], 'title' => 'Delete Role'));                            echo anchor($permission_url, '<i class="fa fa-eye"></i>', array('class' => '','title' => 'Permissions'));

                            ?>
                            </td>
                            </tr>
                            <?php 
                        } }
                        ?>
                        </tbody>