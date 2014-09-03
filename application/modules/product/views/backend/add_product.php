<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery.chosen.min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/chzn.css" charset="utf-8" />

<h3>เพิ่มข้อมูลสินค้า</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>product/backend/index">รายการสินค้า</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เพิ่มข้อมูลสินค้า
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="product_form" name="product_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>product/backend/add_product">
        <div class="widget">
            <div class="formRow">
                <div class="grid2">
					<label class="lbl" for="product_categories_id">หมวดหมู่สินค้า</label>
                    <span class="required"></span>
                </div>
                <div class="grid3">
					<select id="product_categories_id" name="product_categories_id" class="sep_bo">
						<?php if(!empty($listCategories)){foreach($listCategories as $list){?>
                        <option value="<?php echo $list["product_categories_id"]?>" ><?php echo $list["product_categories_name"]?></option>
                        
						<?php }}?>
                    </select>
                </div>
            </div>
           	<div class="clear"></div>
                     
	        <?php if(!empty($listAllLang)){foreach($listAllLang as $lang){
				$lang_icon = ($lang['language_icon'] != '')?'<img src="'.DIR_ROOT.$lang['language_icon'].'" title="'.$lang['language_desc'].'" style="margin-left:3px;" />':'';
				$lang_id = $lang['language_id'];
			?>
			<div class="formRow">
                <div class="grid12">
                    <fieldset>
                        <legend><?php echo $lang['language_desc'].$lang_icon;?></legend>
			
						<div class="formRow">
							<div class="grid2">
								<label class="lbl fl" for="product_name[<?php echo $lang_id?>]">ชื่อสินค้า</label>
								<?php if($lang_id==1) echo '<span class="required"></span>'; ?>
							</div>
							<div class="grid4">
								<input type="text" id="product_name[<?php echo $lang_id?>]" name="product_name[<?php echo $lang_id?>]">
							</div>
						</div>
						<div class="clear"></div>
						
						<!--<div class="formRow">
							<div class="grid2">
								<label class="lbl fl" for="product_short_detail"><?php echo lang('product_short_detail');?></label>
							</div>
							<div class="grid8">
								<input type="text" id="product_short_detail" name="product_short_detail">
							</div>
						</div>
						<div class="clear" style="height:10px;"></div>-->
						
						<div class="formRow">
							<div class="grid2">
								<label class="lbl fl" for="product_detail[<?php echo $lang_id?>]">รายละเอียด</label>
							</div>
							<div class="grid4">
								<textarea id="product_detail[<?php echo $lang_id?>]" name="product_detail[<?php echo $lang_id?>]" class="mceEditor" style="height:40px; width:389px;"></textarea>
								
							</div>
						</div>
						<div class="clear" style="height:10px;"></div>
                    </fieldset>
                </div>
            </div>
            <div class="clear" style="height:10px;"></div>
            <?php }}?>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="product_price">ราคา</label>
                    <span class="required"></span>
                </div>
                <div class="grid1">
                    <input type="text" id="product_price" name="product_price" placeholder="0" style="width:70px;">
                </div>
            </div>
           	<div class="clear"></div>			
			<hr/>
           	<div class="clear"></div>
			
            <h4>สินค้าที่มีส่วนลด (ถ้ามี)</h4>
            <div class="clear"></div>
			<div class="grid5">
				<div class="txt_notify" style="margin-top:-15px; margin-left:-25px; color:#404040;">( สามารถเลือกกรอก "ส่วนลด" หรือ "ราคาหลังหักส่วนลด" อย่างใดอย่างหนึ่ง )</div>
			</div>
           	<div class="clear" style="height:10px;"></div>
			
            <div class="formRow">
                <div class="grid1">&nbsp;</div>
                <div class="grid2">
                    <label class="lbl fl" for="product_price">ราคาเดิม</label>
                </div>
                <div class="grid1" id="boxOldPrice" style="margin-top:5px;">0</div>
            </div>
           	<div class="clear"></div>
			
            <div class="formRow">
                <div class="grid1">&nbsp;</div>
                <div class="grid2">
                    <label class="lbl fl" for="product_discount">ส่วนลด</label>
                </div>
                <div class="grid1">
                    <input type="text" id="product_discount" name="product_discount" placeholder="0" style="width:70px;">
                </div>
                <div class="grid5">
                    <div class="txt_notify" style="margin-top:5px;">* สามารถเลือกกรอกส่วนลดเป็นเปอร์เซ็นต์ (%) หรือส่วนลดราคา อย่างใดอย่างหนึ่ง</div>
                </div>
            </div>
           	<div class="clear"></div>
			
            <div class="formRow">
                <div class="grid1">&nbsp;</div>
                <div class="grid2">
                    <label class="lbl fl" for="product_newprice">ราคาหลังหักส่วนลด</label>
                </div>
                <div class="grid1">
                    <input type="text" id="product_newprice" name="product_newprice" placeholder="0" style="width:70px;">
                </div>
            </div>
           	<div class="clear"></div>			
			<hr/>
           	<div class="clear"></div>  
            
            <div class="formRow">
                <div class="grid11">
                    <fieldset style="margin-top:20px;">
                        <legend><?php echo lang('web_image');?></legend>
                        <input type="file" id="file_upload" name="file_upload">
                        <div class="txt_notify">* <?php echo lang('web_notify_multi_upload');?>&nbsp;&nbsp;/&nbsp;&nbsp; ขนาดรูปที่แนะนำคือ 408 x 274 พิกเซล</div>
                    </fieldset>
        		</div>
   			</div>
           	<div class="clear" style="height:10px;"></div> 
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
        </div>
	</form>
</div>
<script>
$(document).ready(function(){
	$('#product_categories_id').chosen();
	$("#product_form").validate({
		rules: {
			'product_name[1]' : {
				required: true,
			},
			product_categories_id: {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.product_formAdd.submit();
	 	}
	});
    $("#file_upload").uploadfile();
    //LoadTinyMCE();
	
	$('#product_price').keyup(function(){
		price = ($(this).val()=='') ? '0' : $(this).val();
		price = cutNumberSeparate(price);		
		price = number_format (price, 2, '.', ',');
		$('#boxOldPrice').html(price);
		
		calculate('discount')
	});
	$('#product_discount').keyup(function(){
		calculate('discount')
	});
	$('#product_newprice').keyup(function(){
		calculate('sum')
	});
	
});
function calculate(from){
	price = $('#product_price').val();
	price = (price=='') ? '0' : price;
	price = cutNumberSeparate(price);
	
	if(from=='discount'){
		discount = $('#product_discount').val();
		discount = (discount=='') ? '0' : discount;
		discount = cutNumberSeparate(discount);
		Array_dis = getDiscount(discount).split('||');
		dis = Array_dis[0];
		dis_type = Array_dis[1];
		dis = cutNumberSeparate(dis);
		
		sum = (dis_type==1) ? price*((100-dis)/100) : price-discount;
		$('#product_newprice').val(number_format(sum,2,'.',','));
	}else{
		sum = $('#product_newprice').val();
		sum = (sum=='') ? '0' : sum;
		sum = cutNumberSeparate(sum);
		
		discount = 100-((sum*100) / price);
		if(Math.floor(discount)==discount){
			if(discount==0) $('#product_discount').val(discount);
			else			$('#product_discount').val(discount+'%');
		}else{
			discount = price-sum;
			$('#product_discount').val(number_format(discount,2,'.',','));
		}
	}
}
</script>
<?php }?>