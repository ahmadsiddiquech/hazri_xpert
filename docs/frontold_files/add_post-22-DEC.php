<?php error_reporting(0); ?>
<div class="container">
<!-- Panel For Add post -->

<div class="panel panel-default">
    <div class="panel-body">
        <h4 style="color:black;">  Post An Add</h4>
    </div>
</div>
<?php
   $attributes = array('autocomplete' => 'off', 'id' => 'fileupload', 'class' => 'form-horizontal');
        if (empty($update_id)) {
			$update_id = 0;
        } else {
			$hidden = array('hdnId' => $update_id); ////edit case
        }
        if (isset($hidden) && !empty($hidden))
			echo form_open_multipart(ADMIN_BASE_URL . 'front/submit/' . $update_id , $attributes, $hidden);
        else
			echo form_open_multipart(ADMIN_BASE_URL . 'front/submit/' . $update_id , $attributes);
?>
<div class="row">
<div class="row general-class">
        <div class="col-lg-8">
          <div class="form-group">
          <?php
          $options = array('' => 'Select') + $post_main_cats;
          $attribute = array('class' => 'control-label col-md-4');
          echo form_label('Category', '  category_id', $attribute);?>
          <div class="col-md-8"><?php echo form_dropdown('category_id', $options, $items['category_id'], 'class="form-control select2me" id="lstCat" onchange="get_sub_category()"');?></div>
          </div>
        </div>
</div>
</div>

<!-- sub cat Drop down start -->
<div class="row">
    <div class="row general-class">
    <div class="col-lg-8 catts">
        <div class="form-group">
        <?php
        $options = array('' => 'Select') + $post_sub_cats;
        $attribute = array('class' => 'control-label col-md-4 ');
        echo form_label('Sub Category-', '  lstCatsub', $attribute);?>
        <div class="col-md-8"><?php echo form_dropdown('lstCatsub', $options, $items['lstCatsub'], 'class="form-control select2me" id="lstCatsub" onchange="get_feature()"'); ?></div>
        </div>
    </div>
    </div>
</div>

<div class="panel panel-default">
<div class="panel-body">
      <div id='item_feature'></div>
</div>
</div>

<!-- Div Panel category Sub category -->



        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">submit
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>


    <div class="form-actions fluid no-mrg">
    <div class="row">
        <div class="col-md-6">
        <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
        <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
        <a href="">
        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
        </a> </div>
        </div>
    <div class="col-md-6"> </div>
    </div>
</div>
 <?php echo form_close(); ?> 

    <!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">



{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>

<script type="text/javascript">
function get_sub_category(){
        cat_id = $("#lstCat").val();
        if (cat_id == '') {
        $( "#item_feature" ).empty();
        };
        $.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>catagories/get_sub_category_dropdown",
        data: {'id': cat_id},
        async: false,
        success: function(result) {
        $('.catts').html(result);
        }
});
// get_feature();
}
function get_feature(){
    cat_id = $("#lstCat").val();
    sub_category_id = $("#lstCatsub").val();
    if (sub_category_id == '' )
    {
    sub_category_id = 0;
    $( "#item_feature" ).empty();
    return false;
}
$.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>category_feature/getfeature_category",
        data: {'item_id':<?=$update_id?>, 'category_id': cat_id, 'sub_category_id':  sub_category_id},
        async: false,
        success: function(result) {
        $('#item_feature').html(result);
        }
});
}
</script>