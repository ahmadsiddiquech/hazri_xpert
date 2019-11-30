
<div class="container product_page">

	<div class="left_panel col-lg-3">
    <form method="post" action="">
        <ul class="nav">
         <?php  foreach($product_filters->result() as $res_product_filters){ ?>
          <li class="list_item">
             <a href="#multilevel_<?=$res_product_filters->id?>" title="Multilevel" data-toggle="collapse">
                <em class="fa fa-folder-open-o"></em>
                <span > <label ><?=$res_product_filters->name?>_<?=$res_product_filters->id?><span>(<?=$res_product_filters->itemcount?>)</span></label></span>
             </a>
             <ul id="multilevel_<?=$res_product_filters->id?>" class="nav sidebar-subnav collapse">
                <li class="sidebar-subnav-header"><?php //=$res_product_filters->name?></li>
                <?php  foreach($arr_feature_detail_level_1[$res_product_filters->id]->result() as $res_arr_feature_detail_level_1){ ?>
                <li>
                   <a href="#level1_<?=$res_arr_feature_detail_level_1->id?>" title="Level 1" data-toggle="collapse" onclick="test(<?=$res_arr_feature_detail_level_1->id?>)">
                      <span><input class="chk_area2" type="checkbox" name="feature_detail_level_1[]"  id="fdetail_<?=$res_arr_feature_detail_level_1->id?>" > <label><?=$res_arr_feature_detail_level_1->feature_detail?>_<?=$res_arr_feature_detail_level_1->id?><span>(<?=$res_arr_feature_detail_level_1->itemcount?>)</span></label> </span>
                   </a>
                   <ul id="level1_<?=$res_arr_feature_detail_level_1->id?>" class="nav sidebar-subnav collapse">
                      <li class="sidebar-subnav-header"><?php //=$res_arr_feature_detail_level_1->feature_detail?></li>
                      <?php  foreach($arr_feature_level_2[$res_arr_feature_detail_level_1->id]->result() as $res_arr_feature_level_2){ ?>
                      <li>
                         <a href="#level2_<?=$res_arr_feature_level_2->id?>" title="Level 2" data-toggle="collapse">
                            <span><?=$res_arr_feature_level_2->name?>_<?=$res_arr_feature_level_2->id?></span>
                         </a>
                         <ul id="level2_<?=$res_arr_feature_level_2->id?>" class="nav sidebar-subnav collapse">
                            <li class="sidebar-subnav-header"><?=$res_arr_feature_level_2->name?></li>
                             <?php  foreach($arr_feature_detail_level_2[$res_arr_feature_level_2->id]->result() as $res_arr_feature_detail_level_2){ ?>
                            <li>
                               <a href="#level3" title="Level 2 Item 1">
                                  <span><input class="chk_area" type="checkbox" name="feature_detail_level_2[]" > <label><?=$res_arr_feature_detail_level_2->feature_detail?>_<?=$res_arr_feature_detail_level_2->id?><span>(<?=$res_arr_feature_detail_level_2->itemcount?>)</span></label></span>
                               </a>
                            </li>
                             <?php } ?>
                         </ul>
                      </li>
                      <?php } ?>
                   </ul>
                </li>
                <?php  } ?>
             </ul>
          </li> <?php } ?>
        </ul>
        </form>
    </div>

	<?php /*?><div class="left_panel col-lg-3">
	<ul id="" class="prodcut_list">
        <li class="list_item">
            <h4>Brand</h4>
            <p><input type="checkbox" > <label>Audi<span>(4234)</span></label></p>
            <p><input type="checkbox" > <label>Toyota<span>(587)</span></label>
            	<ul>
                     <li class="inner_list_item">
                        <p><input type="checkbox" > <label>Audi<span>(4234)</span></label></p>
                        <p><input type="checkbox" > <label>Toyota<span>(587)</span></label></p>
                        <p><input type="checkbox" > <label>BMW<span>(557)</span></label></p>
                        <p><input type="checkbox" > <label>Honda<span>(427)</span></label></p>
                        <p><input type="checkbox"> <label>Kia<span>(792)</span></label></p>
                    </li>
                </ul>
            </p>
             <p><input type="checkbox" > <label>BMW<span>(557)</span></label></p>
            <p><input type="checkbox" > <label>Honda<span>(427)</span></label></p>
             <p><input type="checkbox"> <label>Kia<span>(792)</span></label></p>
        </li>  
         <li class="list_item">
            <h4>Advertiser</h4>
            <p><input type="checkbox" > <label>Private<span>(4234)</span></label></p>
            <p><input type="checkbox" > <label>Brand Retailer<span>(587)</span></label></p>
             <p><input type="checkbox" > <label>Private<span>(557)</span></label></p>
        </li>
        <li class="list_item">
            <h4>Seats</h4>
           <!--<div class='slider-example'>
      		<h3>Example 2:</h3>
      		<p>Range selector, options specified via data attribute.</p>
      		<div class="well">
      			Filter by price interval: <b>€ 10</b> <input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/> <b>€ 1000</b>
      		</div>

      	</div>-->
        Price Range
        </li>
    </ul>
</div><?php */?>



<div class="product_list col-lg-9">
	<div class="product_list_item">
    	<div class="product_img col-lg-4">
        	<a href="<?php echo base_url();?>"><img class="img-responsive" src="<?php echo STATIC_FRONT_IMAGE?>car_01.jpg" align="logo"></a>
        </div>
        <div class="produc_details col-lg-8">
        	<a  class="paid_placment" href="#">Paid Placment</a>
        	<h4 class="item_name">Citroen Berlingo 5 SEATS, EU OK 12/17</h4>
            <div class="clearfix"></div>
            <p><span>2003</span> <span>165 km/hr <span>6,00000</span></span></p>
            <p>Other car showrooms • Two wheels</p>
        </div>
    </div>
    <div class="product_list_item">
    	<div class="product_img col-lg-4">
        	<a href="<?php echo base_url();?>"><img class="img-responsive" src="<?php echo STATIC_FRONT_IMAGE?>car_01.jpg" align="logo"></a>
        </div>
        <div class="produc_details col-lg-8">
        	
        	<h4 class="item_name">Citroen Berlingo 5 SEATS, EU OK 12/17</h4>
            <div class="clearfix"></div>
            <p class=""><label>Price</label><span>600000</span></p>
            <p class=""><label>Distance</label><span>345 km</span></p>
            <p class=""><label>City</label><span>Islamabad</span></p>
            <p>Other car showrooms • Two wheels</p>
        </div>
    </div>
    <div class="product_list_item">
    	<div class="product_img col-lg-4">
        	<a href="<?php echo base_url();?>"><img class="img-responsive" src="<?php echo STATIC_FRONT_IMAGE?>car_01.jpg" align="logo"></a>
        </div>
        <div class="produc_details col-lg-8">
        	<h4 class="item_name">Citroen Berlingo 5 SEATS, EU OK 12/17</h4>
            <div class="clearfix"></div>
            <p><span>2003</span> <span>165 km/hr <span>6,00000</span></span></p>
            <p>Other car showrooms • Two wheels</p>
        </div>
    </div>
    
</div>
</div>

<script>
$(document).ready(function(){
	  
	$(document).off("click", ".chk_area").on("click", ".chk_area", function(){
		//left_panel_search_items_listing();
	   alert('2');
	});
$(document).off("click", ".chk_area2").on("click", ".chk_area2", function(){
		//left_panel_search_items_listing();
	   alert('1');
	});

	
	/////////////////////////////////////////////////////////////////////////////////////////

	$(document).off("click", ".pagination li a").on("click", ".pagination li a", function(event){
		event.preventDefault();
		var curr_page_url = $(this).attr('href');
		left_panel_search_items_listing(curr_page_url);
	});
	/////////////////////////////////////////////////////////////////////////////////////////
});
function test(id){
	//alert('ok');	
	 //$(".fdetail_60").attr('checked', true);
	 // $(".fdetail_60").prop('checked', $(this).prop('checked'));
	// $('.myCheckbox').attr('checked', true);
	//alert('ok1');
	}
function left_panel_search_items_listing(curr_page_url){
	var arr_chk_area = [];
	$('.chk_area:checked').each(function(i, e) {
		arr_chk_area.push($(this).val());
	});
//alert(arr_chk_area);
	$('#modal_loading').modal('show')

	$.ajax({
		type: "POST",
		url: "<?=BASE_URL?>left_panel_search_items_listing",
		<?php /*?>data: {'parent_cat_slug':'<?=$row_parent_cat->url_slug?>', 'sub_cat_slug':'<?=$row_sub_cat->url_slug?>', 'chk_area':arr_chk_area, 'curr_page_url': curr_page_url},<?php */?>
		success: function(res_html){
			setTimeout(function(){$('#modal_loading').modal('hide');$("#search_container").html(res_html);}, 1500);
		}
	});
}


</script>