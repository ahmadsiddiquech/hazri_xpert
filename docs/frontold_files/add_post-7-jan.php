<?php  error_reporting(0); ?>
<div class="container" style="padding:0 5px; 0 0;">
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
<!-- general Class start-->
<div class=" general-class">
<div class="item_feature_main_block">
        <div class="sample_block">
        <div class="form-group form_block col-lg-12">
        <label class="control-label col-md-3" for="  category_id">Category</label>          
        <div class="col-md-6 ">
        <?php
        $options = array('' => 'Select') + $post_main_cats;
        echo form_dropdown('category_id', $options, $items['category_id'], 'class="form-control select2me"  id="lstCat" onchange="get_sub_category()" required');?>
        </div>
        </div>
        </div>
<div class="sample_block catts">
      <div class="form-group form_block col-lg-12">
      <label class="control-label col-md-3" for="  category_id">Sub Category</label>          
      <div class="col-md-6">
      <select  onchange="get_sub_category()" id="lstCat" class="form-control select2me " name="category_id">
      <option selected="selected" value="">Select</option>
     
      </select>
      </div>
      </div>
</div>
<div class="sample_block">
        <div class="form-group form_block col-lg-12">
      <label for="features_detail_text_" class="control-label col-md-3">Title</label>    
      <div class="col-md-6"><input type="text" name="title" required value="" id="title" class="form-control"></div>   </div>
        </div>
</div>
<div class="clearfix"></div>
<div class="separator_line col-lg-8"></div>
      <div class="item_feature_main_block" id="dynamic_load">
      <div class="heading col-lg-12" ><h3 class="col-lg-12">Item Information</h3></div>
      <!-- -->
      </div>
<div class="separator_line col-lg-8"></div>
      <div class="item_feature_main_block">
      <div class="heading col-lg-12"><h3 class="col-lg-12">More Information</h3></div>
      <div class="sample_block">
      <div class="form-group form_block col-lg-12">
      <label class="control-label col-md-3" for="ForMessage">Describe Your Accessories</label>          
      <div class="col-md-6">
      <textarea class="form-control" type="textarea" id="message" name="short_desc" placeholder="Message" maxlength="140" rows="7"></textarea>
      <span class="help-block"><p id="characterLeft" class="help-block ">You have reached the limit</p></span>   
      </div>
      </div>
      </div>
      </div>
<div class="separator_line col-lg-8"></div>

        <div class="col-md-offset-8 col-md-3">
      <button type="button" class="btn btn-default pull-right AddMoreFileBox">Add Image <i class="fa fa-plus"></i></button>
      </div>            

<div id="InputsWrapper">
      <div class="row col-lg-12 top">
                        <div class="form-group col-lg-6">
                <div class="row" id="certificate_file_div">
                    <div class="col-md-12">
                        <div class="form-group">
                            
                            <div class="">
                               <div class="fileupload fileupload-new" data-provides="fileupload"  >
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="uneditable-input">
                                            <i class="fa fa-file fileupload-exists"></i>
                                            <span class="fileupload-preview">
                                            <?php //if(isset($document['file']) && !empty($document['file'])){ echo $document['file'];} ?>
                                            </span>
                                            </span>
                                        </span>
                                        <span class="btn default btn-file">
                                        <span class="fileupload-new">
                                        <i class="fa fa-paper-clip"></i>Select File
                                        </span>
                                        <span class="fileupload-exists">
                                        <i class="fa fa-undo"></i>Change
                                        </span>
                                        <input type="file" id ="document_file_1" class="document_file default" name="document_file[]"  extension= "docx|doc|pdf|ppt|jpg|jpeg|xls|xlsx" field_count="1" />
                                        <?php 
                                        echo form_input(array('name' => 'hdn_document[]', 'type' => 'hidden', 'id' => 'hdn_document_1')); 
                                        ?>
                                        </span>
                                    <!--<a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
</div>
<div class="separator_line col-lg-8"></div>
<div class="item_feature_main_block">
        <div class="sample_block">
        <div class="form-group form_block col-lg-12">
        <label class="control-label col-md-3" for="  country_id">Country</label>          
        <div class="col-md-6 ">
        <?php
        $options = array('' => 'Select') + $country;
        echo form_dropdown('country_id', $options, $items['country_id'], 'class="form-control select2me"  id="CountryId" ');?>
        </div>
        </div>
        </div>
</div>
<div class="item_feature_main_block">
        <div class="sample_block">
        <div class="form-group form_block col-lg-12">
        <label class="control-label col-md-3" for="  province_id">Province</label>          
        <div class="col-md-6 ">
        <?php
        $options = array('' => 'Select') + $province;
        echo form_dropdown('province_id', $options, $items['province_id'], 'class="form-control select2me"  id="ProId" onchange="get_city()"');?>
        </div>
        </div>
        </div>
</div>
<div id="load_city">
</div>
<div class="sample_block">
        <div class="form-group form_block col-lg-12">
      <label for="features_detail_text_" class="control-label col-md-3">Street Address</label>    
      <div class="col-md-6"><input type="text" name="str_address" value="" id="str_address" class="form-control"></div>   </div>
        </div>
<div class="item_feature_main_block">
      <div class="sample_block">
          <div class="form-group form_block col-lg-12">
          <label class="control-label col-md-3" for="ForMessage">Contact Information</label>          
              <div class="col-md-6">
              <div style="margin-bottom: 25px" class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input id="login-username" type="text" class="form-control" name="seller_name" required value="" placeholder="Seller Name">                                    </div>
              <div style="margin-bottom: 25px" class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
              <input id="login-username" type="text" class="form-control" required name="user_email" value="" placeholder="username or email">                                        
              </div>
              <div style="margin-bottom: 25px" class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
              <input id="login-username" type="text" class="form-control" required name="contact_num" value="" placeholder="Phone"> 
              </div>
              <button class="btn  btn-primary " type="submit">Submit</button>
              <button class="btn  btn-danger " type="submit">Clear</button>
              </div>
          </div>
      </div>
</div>
<div class="separator_line col-lg-8"></div>
</div>
<!-- generl Class end-->
<div class="clearfix"></div>
</div>
<?php echo form_close(); ?> 
</div>
<script type="text/javascript">
 $(document).ready(function() {
    var MaxInputs       = 20; //maximum input boxes allowed
    var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
    var AddButton       = $(".AddMoreFileBox"); //Add button ID
    var x = InputsWrapper.length; //initlal text box count
    var FieldCount = 1; //to keep track of text box added 2
    var label_1 = 'Select file';
    var label_2 = 'Change';
$(AddButton).click(function (e)  //on add input button click
{
if(x <= MaxInputs) //max input box allowed
      {
      FieldCount++; //text box added increment
      $(InputsWrapper).append('<input type="file" id ="document_file_1" class="document_file default" name="document_file[]"  extension= "docx|doc|pdf|ppt|jpg|jpeg|xls|xlsx" field_count="'+FieldCount+'"  /><input type="hidden" name="hdn_document[]" id="hdn_document_'+FieldCount+'">'); 
      x++; //text box increment
      }
return false;
});
$("body").on("click",".removeclass", function(e){ //user click on remove text
      if( x >= 1 ) {
      $(this).parent().parent('div').remove(); //remove text box
      x--; //decrement textbox
      }
return false;
})         
///////////////////////////////////////////////////////////////////////////////
$(document).off("change", ".document_file").on("change", ".document_file", function(event) {
        var FieldCount = $(this).attr('field_count');
        var img = $(this).val();
        var replaced_val = img.replace("C:\\fakepath\\", '');
        $('#hdn_document_'+FieldCount).val(replaced_val);
    });
});
$(document).ready(function(){ 

$('#characterLeft').text('150 characters left');
      $('#message').keydown(function () {
      var max = 150;
      var len = $(this).val().length;
          if (len >= max) {
          $('#characterLeft').text('You have reached the limit');
          $('#characterLeft').addClass('red');
          $('#btnSubmit').addClass('disabled');            
          } 
      else {
      var ch = max - len;
      $('#characterLeft').text(ch + ' characters left');
      $('#btnSubmit').removeClass('disabled');
      $('#characterLeft').removeClass('red');            
      }
      });    
});
function get_sub_category(){
cat_id = $("#lstCat").val();
    if (cat_id == '') {
    $( "#item_feature" ).empty();
    };
    $.ajax({
    type: 'POST',
    url: "<?php echo ADMIN_BASE_URL?>catagories/get_sub_category_dropdown_add_post",
    data: {'id': cat_id},
    async: false,
    success: function(result) {
    $('.catts').html(result);
    }
    });
// get_feature();
}
function get_city(){
pro_id = $("#ProId").val();
    if (pro_id == '') {
    $( "#load_city" ).empty();
    return false;
    };
    $.ajax({
    type: 'POST',
    url: "<?php echo ADMIN_BASE_URL?>front/get_city",
    data: {'id': pro_id},
    async: false,
    success: function(result) {
    $('#load_city').html(result);
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
// $( "#item_feature" ).empty();
$( "#dynamic_load" ).empty();
return false;
}
      $.ajax({
      type: 'POST',
      url: "<?php echo ADMIN_BASE_URL?>category_feature/getfeature_category",
      data: {'item_id':<?=$update_id?>, 'category_id': cat_id, 'sub_category_id':  sub_category_id},
      async: false,
      success: function(result) {
      //alert(result);
      $('#dynamic_load').html(result);
      //$('#item_feature').html(result);
      }
      });
} 
</script>

