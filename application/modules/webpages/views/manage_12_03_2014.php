<div class="row table-heading">
    <div class="col-md-9 col-sm-7 col-xs-7 genral table-header">
        Page Manager                   	
        <?php
        echo anchor(ADMIN_BASE_URL.'webpages/create', 'Add new', array('class' => 'btn btn-default btn-info btn-xs', 'role' => 'button'));
        ?>
    </div>
    <div class=" col-xs-12 col-sm-4 col-md-3 search-box">
        <?php
        echo form_open(ADMIN_BASE_URL.'webpages/search_page/', array('class' => 'form-inline', 'role' => 'form'));
        ?>
        <div class="form-group">
            <?php
            if(empty($strSearch))
            $strSearch = '';
            $data = array(
            'name' => 'txtSearch',
            'class' => 'form-control input-sm',
            'value' => $strSearch,
            'placeholder' => 'Search page',
            );
            echo form_input($data);
            ?>
        </div>
        <div class="form-group">
            <?php
            $data = array(
            'name' => 'btnSubmit',
            'id' => 'btnSubmit',
            'class' => 'btn btn-sm btn-info',
            'value' => 'Search',
            );
            echo form_submit($data);
            echo form_close();
            ?>
        </div>
    </div>
</div>
<div class="row">
    <?php
    $message = $this->session->flashdata('message');
    if(!empty($message)){
    ?>

    <div class="col-sm-12 alert alert-success  min_h" align="center">
        <?php
        echo $message;
        ?>
    </div>
<?php } ?>
</div>
<?php 
 if(isset($languages) &&!empty($languages))
            {
				?>
<div class="row col-xs-12 col-sm-4 col-md-4 slanguage-div" style="  margin-bottom: 10px;">
    <div class="form-group">
        <label for="inputLanguage" class="col-sm-5 control-label slanguage ">Select Language</label>
        <div class="col-sm-4 genral">
            <?php
            $options = array('' => '---select--') + $languages;
            echo form_label('', 'lstLanguage', 'class = "col-sm-5 control-label slanguage"');
            echo br();
            echo form_dropdown('lstLanguage', $options, $lang_id, 'class = "form-control input-sm" id = "lstLanguage"');
            ?>
        </div>
    </div>
</div>
<?php 
}
?>
<div class="clearfix"></div>

<?php
echo form_open(ADMIN_BASE_URL.'webpages/set_multi', array('name' => 'frmPage', 'id' => 'frmPage'));
?>
<table class="table table-hover">
    <thead class="tabhead">
        <tr class="table-title">
            <th width="2%">
                <?php
                $data = array(
                'id' => 'selectAll',
                );
                echo form_checkbox($data);
                ?>
            </th>
            <th>Title</th>
    <!--    <th width="24.5%">Title</th>
        <th width="24.5%" >Title</th>-->
      <!--  <th>Sub Pages</th>-->
       <!-- <th>Is Home</th>-->
            <th class="ActionsClass">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $all_langs = Modules::run('lang/_get_all_langs');
        foreach($query->result() as $row)
        {
        if(!isset($return_page))
        $return_page = 0;
        $manage_sub_page_url = ADMIN_BASE_URL.'webpages/manage_sub_pages/'.$row->id.'/'.$row->lang_id;
        $set_home_url = ADMIN_BASE_URL.'webpages/set_home_page/'.$row->id;
        $set_publish_url = ADMIN_BASE_URL.'webpages/set_publish/'.$row->id;
        $set_unpublish_url = ADMIN_BASE_URL.'webpages/set_unpublish/'.$row->id;
		
		$show_toppanel_url = ADMIN_BASE_URL.'webpages/show_toppanel/'.$row->id;
        $remove_toppanel_url = ADMIN_BASE_URL.'webpages/remove_toppanel/'.$row->id;
		
		$show_footer_url = ADMIN_BASE_URL.'webpages/show_footer/'.$row->id;
        $remove_footer_url = ADMIN_BASE_URL.'webpages/remove_footer/'.$row->id;
		
		
        $edit_url = ADMIN_BASE_URL.'webpages/create/'.$row->id.'/'.$row->lang_id;
        $delete_url = ADMIN_BASE_URL.'webpages/delete/'.$row->id.'/'.$row->lang_id.'/'.$return_page;
        ?>
        <tr class="table-listing table-row-style">
            <td>
                <?php
                if($row->is_home != 1)
                {
                $data = array(
                'class' => 'case',
                'name' => 'chkId[]',
                'value' => $row->id,
                );
                echo form_checkbox($data);
                }
                ?>
            </td>
            <td><?php echo $row->page_title; ?></td>
         <!-- <td><?php echo anchor($manage_sub_page_url, 'Manage Sub Pages'); ?></td>-->
          <!--<td>
            <?php
            if($row->is_home == 1)
            echo '<img src="'.base_url().'static/admin/theme1/images/home_active.png" />';
            else
            echo anchor($set_home_url, '<img src="'.base_url().'static/admin/theme1/images/IsNotHome.png" title="Set as Home page" />');
            ?>
          </td>-->
            <td aria-hidden="true" align="right">
                <?php
                if($row->page_type_id == 1)
                {
                if($row->is_home == 1)
                echo '<img src="'.base_url().'static/admin/theme1/images/home_active.png" title="Home page" />';
                else
                echo anchor($set_home_url, '<img src="'.base_url().'static/admin/theme1/images/IsNotHome.png" title="Set Home page" />');
				echo nbs(2);
                if($row->is_publish == 1)
                echo anchor($set_unpublish_url, '<img src="'.base_url().'static/admin/theme1/images/publish.png" title="Set Un-Publish" />');
                else
                echo anchor($set_publish_url, '<img src="'.base_url().'static/admin/theme1/images/unpublish.png"  title="Set Publish" />');
				echo nbs(2);
				
				if($row->show_in_toppanel == 1)
                echo anchor($remove_toppanel_url, '<img src="'.base_url().'static/admin/theme1/images/top_show_active.png" title="Remove From Top panel" />');
                else
                echo anchor($show_toppanel_url, '<img src="'.base_url().'static/admin/theme1/images/top_show.png"  title="Show in Top panel" />');
				echo nbs(2);
				
				if($row->show_in_footer == 1)
                echo anchor($remove_footer_url, '<img src="'.base_url().'static/admin/theme1/images/footer_show_active.png" title="Remove From Footer" />');
                else
                echo anchor($show_footer_url, '<img src="'.base_url().'static/admin/theme1/images/footer_show.png"  title="Show in Footer" />');
				echo nbs(2);
				
                echo anchor($edit_url, '<img src="'.base_url().'static/admin/theme1/images/edit.png" title="Edit Page" />');
				echo nbs(2);
                if($row->is_home != 1)
	                echo anchor($delete_url, '<img src="'.base_url().'static/admin/theme1/images/delete.png" title="Delete Page" />', array('onclick'=>"if (confirm('Are you sure to delete selected item?')){ return true; }else{ return false; };"));
                else
	                echo '<img src="'.base_url().'static/admin/theme1/images/delete_dull.png" title="Cannot Delete Home page" />';
                $query = Modules::run('lang/_get_not_lang_record', $row->id, 'webpages');
                $query2 = Modules::run('lang/_get_done_lang_record', $row->id, 'webpages');
                if(isset($query) && $query->num_rows>0)
                {
                foreach($query->result() as $lang):
                foreach($all_langs->result() as $all_lang){
                if(trim($lang->lang_name) == trim($all_lang->lang_name))
                {
                ?>
                <a href="<?= ADMIN_BASE_URL."webpages/translate/".$row->id."/".$row->lang_id."/".$lang->id ?>" title="Translate into <?= $lang->lang_name ?>"><img src="<?php echo base_url(); ?>static/admin/theme1/images/<?= $lang->lang_flag ?>" height="20" width="20" style="opacity:0.5;" alt="<?= $lang->lang_flag ?>"/></a>
                <?
                }
                }
                endforeach;
                if(isset($query2)&& $query2->num_rows>0)
                {
                foreach($query2->result() as $done_lang)
                {
                foreach($all_langs->result() as $all_lang){
                if(trim($done_lang->lang_name) ==  trim($all_lang->lang_name))
                {
                ?>
                <img src="<?php echo base_url(); ?>static/admin/theme1/images/<?= $done_lang->lang_flag ?>" height="20" width="20" title="<?= $done_lang->lang_name ?>" alt="<?= $done_lang->lang_flag ?>"/>
                <?
                }
                }
                }
                }
                }
                else
                {
                if(isset($query2))
                {
                foreach($query2->result() as $done_lang)
                {
                foreach($all_langs->result() as $all_lang){	
                if(trim($done_lang->lang_name) == trim($all_lang->lang_name))
                {
                ?>
                <img src="<?php echo base_url(); ?>static/admin/theme1/images/<?= $done_lang->lang_flag ?>" height="20" width="20" title="<?= $done_lang->lang_name ?>" alt="<?= $done_lang->lang_flag ?>"/>
                <?
                }
                }
                }
                }
                }
                }
                else
                {
                if($row->is_home == 1)
                	echo '<img src="'.base_url().'static/admin/theme1/images/home_active.png" title="Home page" />';
				else
					echo anchor($set_home_url, '<img src="'.base_url().'static/admin/theme1/images/IsNotHome.png" title="Set Home page" />');
				echo nbs(2);
                if($row->is_publish == 1){
	                if($row->is_home != 1)
		                echo anchor($set_unpublish_url, '<img src="'.base_url().'static/admin/theme1/images/publish.png" title="Set Un-Publish" />');
				}
                else
    	            echo anchor($set_publish_url, '<img src="'.base_url().'static/admin/theme1/images/unpublish.png"  title="Set Publish" />');
				echo nbs(3);
                echo 'Static Page'; 
				echo nbs(6);
                }
                ?>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>
<!--------------------  pagination--------------->
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6 genral">
        <div class="pull-left">
            <input type="submit" name="btnPublish" value="Publish" id="btnPublish" class="btn btn-primary active btn-success btn-sm">
            <input type="submit" name="btnUnPublish" value="UnPublish" id="btnUnPublish" class="btn btn-primary active btn-warning btn-sm">
            <!--<input type="submit" name="btnDelete" value="Delete" id="btnDelete" class="btn btn-primary active btn-danger btn-sm">-->

        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:30px;">
        <div class="pull-right">
<?php echo $paging; ?>
        </div>
    </div>
</div>
<!------------------- end pagination -------------> 
<?php
echo form_close();
?>

<script>
      $(document).ready(function() {
        $("#selectAll").on("click", function() {
            var $checkbox = $(".case");          
            $checkbox.prop('checked', !$checkbox.prop('checked'));
        });
        $('.case').change( function(){
            var all= $('.case');          
            if(all.length == all.filter(':checked').length){
                $('#selectAll').prop('checked' , true)
            }else{
                $('#selectAll').prop('checked' ,false)
            }
            
        });
    });
    $(function() {  //  document.ready
        $('#lstLanguage').change(function() {
            var lang_id = $(this).val();
            window.location.href = '<?php echo ADMIN_BASE_URL; ?>webpages/manage/' + lang_id;
        });
    });
</script>
