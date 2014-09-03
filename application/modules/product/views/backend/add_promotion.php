<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<!--<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>-->

<h3><?php echo lang('product_promotion_add');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>product/backend/index"><?php echo lang('product_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>product/backend/index_promotion"><?php echo lang('product_promotion');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo lang('product_promotion_add');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="product_form" name="product_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>product/backend/add_promotion">
        <div class="widget">
            <div class="formRow">
                <div class="grid2">
					<label class="lbl" for="product_id"><?php echo lang('product_ii');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid3">
					<select id="product_id" name="product_id" class="sep_bo">
                    	<option value="">-<?php echo lang('product_promotion_select_product');?>-</option>
						<?php if(!empty($listProduct)){foreach($listProduct as $list){?>
                        <option value="<?php echo $list["product_id"]?>" ><?php echo $list["product_name"]?></option>
                        <?php }}?>
                    </select>
                </div>
            </div>
           	<div class="clear"></div>      
                    
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="product_promotion_name"><?php echo lang('product_promotion_name');?></label>
                </div>
                <div class="grid9">
                    <textarea id="product_promotion_name" name="product_promotion_name" class="mceEditor" style="height:100px;"></textarea>
                </div>
            </div>
            <div class="clear" style="height:10px;"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="product_price"><?php echo lang('product_price');?></label>
                </div>
                <div class="grid2">
                    <input type="text" id="product_price" name="product_price" placeholder="0">
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="product_discount"><?php echo lang('product_discount');?></label>
                </div>
                <div class="grid2">
                    <input type="text" id="product_discount" name="product_discount" placeholder="0">
                </div>
            </div>
           	<div class="clear"></div>   
            
            <div class="formRow">
                <div class="grid11">
                    <fieldset style="margin-top:20px; margin-bottom:20px;">
                        <legend>Setting</legend>
                        <div class="sep_bo"><label for='product_promotion_publish'><input type="checkbox" id="product_promotion_publish" name="product_promotion_publish" value="1" checked="checked"/>&nbsp;&nbsp;<?php echo lang('web_publish');?></label></div>
                        <div class="sep_bo"><label for='product_promotion_pin'><input type="checkbox" id="product_promotion_pin" name="product_promotion_pin" value="1" />&nbsp;&nbsp;<?php echo lang('web_pin');?></label></div>
                    </fieldset>
                </div>
            </div>
           	<div class="clear"></div>    
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
        </div>
	</form>
</div>
<script>
$(document).ready(function(){
	$("#product_form").validate({
		rules: {
			product_id : {
				required: true,
			},
			product_promotion_name: {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.product_formAdd.submit();
	 	}
	});
    //LoadTinyMCE();
	
});

</script>
<?php }?>