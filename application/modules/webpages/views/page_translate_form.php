<div class="col-md-9 col-sm-7 col-xs-7 genral table-header">Translate Page</div>
<?php
echo anchor(ADMIN_BASE_URL . 'webpages', 'Back', array('class' => 'btn btn-default btn-info btn-xs pull-right back-button', 'role' => 'button'));
?>
<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:10px;padding:0px;">
    <?php
    echo validation_errors('<p style="color:red;">', '</p>');
    ?>
    <div style="clear:both;"></div>
    <?php
    $attributes = array('autocomplete' => 'off', 'id' => 'frmWebpages');
    $hidden = array('hdnId' => $update_id);
    echo form_open(ADMIN_BASE_URL . 'webpages/translate_submit/' . $update_id, $attributes, $hidden);
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php
                $data = array(
                    'name' => 'txtPageTitle',
                    'id' => 'txtPageTitle',
                    'class' => 'form-control validate[required] text-input',
                    'value' => $webpage['page_title'],
                );
                echo form_label('Page Title <span class="red" style="color:red;">*</span>', 'txtPageTitle');
                echo form_input($data);
                ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php
                $options = array('' => '---select--') + $languages;
                echo form_label('Language <span class="red" style="color:red;">*</span>', 'lstLanguage');
                echo br();
                echo form_dropdown('lstLanguage', $options, $lang_id, 'class = "form-control validate[required]" id = "lstLanguage"');
                ?>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php
                $this->config->load('general_constants');
                $rank = $this->config->item('RANK');
                $options = array('' => '---select--') + $rank;
                echo form_label('Page Rank <span class="red" style="color:red;">*</span>', 'lstRank');
                echo br();
                echo form_dropdown('lstRank', $options, $webpage['page_rank'], 'class = "form-control validate[required]" id = "lstRank"');
                ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php
                $data = array(
                    'name' => 'txtPageUrl',
                    'id' => 'txtPageUrl',
                    'class' => 'form-control',
                    'value' => $webpage['url_slug'],
                );
                echo form_label('Page Url', 'txtPageUrl');
                echo form_input($data);
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php
                $data = array(
                    'name' => 'txtMetaKW',
                    'id' => 'txtMetaKW',
                    'rows' => '5',
                    'cols' => '10',
                    'class' => 'form-control',
                    'value' => $webpage['meta_keywords'],
                );
                echo form_label('Meta Keywords', 'txtMetaKW');
                echo form_textarea($data);
                ?>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <?php
                $data = array(
                    'name' => 'txtMetaDesc',
                    'id' => 'txtMetaDesc',
                    'rows' => '5',
                    'cols' => '10',
                    'class' => 'form-control',
                    'value' => $webpage['meta_description'],
                );
                echo form_label('Meta Description', 'txtMetaDesc');
                echo form_textarea($data);
                ?>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <?php
                $data = array(
                    'name' => 'txtPageCont',
                    'id' => 'txtPageCont',
                    'rows' => '5',
                    'cols' => '10',
                    'class' => 'ckeditor',
                    'value' => $webpage['page_content'],
                );
                echo form_label('Page Contents', 'txtPageCont');
                echo form_textarea($data);
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
            $data = array(
                'name' => 'btnSubmit',
                'id' => 'btnSubmit',
                'class' => 'btn btn-primary',
                'value' => 'Save',
            );
            echo form_submit($data);
            echo form_close();
            ?>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        // binds form submission and fields to the validation engine
        jQuery("#frmWebpages").validationEngine();
    });

</script>
<script>
    CKEDITOR.replace('txtPageCont',
            {
                filebrowserBrowseUrl: '<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/browser/default/browser.html?Connector=<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserImageBrowseUrl: '<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserFlashBrowseUrl: '<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserUploadUrl: '<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
                filebrowserImageUploadUrl: '<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
                filebrowserFlashUploadUrl: '<?= $this->config->base_url() ?>static/admin/theme1/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
            });
<?php
if (!empty($update_id)) {
    ?>
        $("#lstLanguage").css("pointer-events", "none");
        $("#lstLanguage").css("cursor", "default");
    <?php
}
?>
</script>