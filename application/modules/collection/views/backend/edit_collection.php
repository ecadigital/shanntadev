<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<?php if(isset($redirect)){ echo $redirect; }else{ ?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>js/tiny_mce/load.js"></script>

<script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery.chosen.min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/chzn.css" charset="utf-8" />

<h3>แก้ไขข้อมูลคอลเลคชั่น</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>collection/backend/index">รายการคอลเลคชั่น</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	แก้ไขข้อมูลคอลเลคชั่น
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="collection_form" name="collection_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>collection/backend/edit_collection">
        <div class="widget">
            <div class="formRow">
                <div class="grid2">
					<label class="lbl" for="collection_categories_id">หมวดหมู่คอลเลคชั่น</label>
                    <span class="required"></span>
                </div>
                <div class="grid3">
					<select id="collection_categories_id" name="collection_categories_id" class="sep_bo">
						<?php if(!empty($listCategories)){foreach($listCategories as $list){?>
                        <option value="<?php echo $list["collection_categories_id"]?>" <?php echo ($list["collection_categories_id"] == $listEditCollection['collection_categories_id'])?'selected="selected"':'';?> ><?php echo $list["collection_categories_name"]?></option>
                        <?php }}?>
                    </select>
                </div>
            </div>
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="collection_name">ชื่อคอลเลคชั่น</label>
                    <span class="required"></span>
                </div>
                <div class="grid4">
                    <input type="text" id="collection_name" name="collection_name" value="<?php echo $listEditCollection['collection_name'];?>">
                </div>
            </div>
           	<div class="clear"></div>
            
            <!--<div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="collection_short_detail"><?php echo lang('collection_short_detail');?></label>
                </div>
                <div class="grid8">
                    <input type="text" id="collection_short_detail" name="collection_short_detail" value="<?php echo $listEditCollection['collection_short_detail'];?>">
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div>-->
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="collection_detail">รายละเอียด</label>
                </div>
                <div class="grid4">
                    <textarea id="collection_detail" name="collection_detail" class="mceEditor" style="height:40px; width:389px;"><?php echo $listEditCollection['collection_detail'];?></textarea>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="collection_price">ราคา</label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="collection_price" name="collection_price" placeholder="0" value="<?php echo number_format($listEditCollection['collection_price']);?>">
                </div>
            </div>
           	<div class="clear"></div>	
			<hr/>
           	<div class="clear"></div>
			
            <h4>คอลเลคชั่นที่มีส่วนลด (ถ้ามี)</h4>
            <div class="clear"></div>
			<div class="grid5">
				<div class="txt_notify" style="margin-top:-15px; margin-left:-25px; color:#404040;">( สามารถเลือกกรอก "ส่วนลด" หรือ "ราคาหลังหักส่วนลด" อย่างใดอย่างหนึ่ง )</div>
			</div>
           	<div class="clear" style="height:10px;"></div>
			
            <div class="formRow">
                <div class="grid1">&nbsp;</div>
                <div class="grid2">
                    <label class="lbl fl" for="collection_price">ราคาเดิม</label>
                </div>
                <div class="grid1" id="boxOldPrice" style="margin-top:5px;"><?php echo number_format($listEditCollection['collection_price']);?></div>
            </div>
           	<div class="clear"></div>
			
            <div class="formRow">
                <div class="grid1">&nbsp;</div>
                <div class="grid2">
                    <label class="lbl fl" for="collection_discount">ส่วนลด</label>
                </div>
                <div class="grid1">
                    <input type="text" id="collection_discount" name="collection_discount" placeholder="0" style="width:70px;" value="<?php echo $listEditCollection['collection_discount'];?>">
                </div>
                <div class="grid5">
                    <div class="txt_notify" style="margin-top:5px;">* สามารถเลือกกรอกส่วนลดเป็นเปอร์เซ็นต์ (%) หรือส่วนลดราคา อย่างใดอย่างหนึ่ง</div>
                </div>
            </div>
           	<div class="clear"></div>
			
            <div class="formRow">
                <div class="grid1">&nbsp;</div>
                <div class="grid2">
                    <label class="lbl fl" for="collection_newprice">ราคาหลังหักส่วนลด</label>
                </div>
                <div class="grid1">
                    <input type="text" id="collection_newprice" name="collection_newprice" placeholder="0" style="width:70px;" value="<?php echo number_format($listEditCollection['collection_newprice']);?>">
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
                        <?php if(!empty($listEditCollection['collection_images'])){?>
                        <ul id="UploadQueue" class="hidden">
                            <?php foreach($listEditCollection['collection_images'] as $index=>$collection_images){?>
                            <li class="queue" id="EditUpload_0_<?php echo $index?>" data-itemid="<?php echo $collection_images['collection_images_id'];?>"><?php echo $collection_images['collection_images_path'];?></li>
                            <?php }?>
                        </ul>
                        <?php }?>
                        <div class="txt_notify">* <?php echo lang('web_notify_multi_upload');?>&nbsp;&nbsp;/&nbsp;&nbsp; ขนาดรูปที่แนะนำคือ 408 x 274 พิกเซล</div>
                    </fieldset>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div> 
            
            <div class="formRow">   
                <input type="hidden" id="collection_id" name="collection_id" value="<?php echo $listEditCollection['collection_id'];?>"></input>
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
    </form>
</div>

<script>
$(document).ready(function(){
	$('#collection_categories_id').chosen();
	$("#collection_form").validate({
		rules: {
			'collection_name' : {
				required: true,
			},
			collection_categories_id: {
				required: true,
			}
		},
	   	submitHandler: function(form) {
			document.collection_formEdit.submit();
	 	}
	});
    $("#file_upload").uploadfile();
    //LoadTinyMCE();
	
	$('#collection_price').keyup(function(){
		price = ($(this).val()=='') ? '0' : $(this).val();
		price = cutNumberSeparate(price);		
		price = number_format (price, 2, '.', ',');
		$('#boxOldPrice').html(price);
		
		calculate('discount')
	});
	$('#collection_discount').keyup(function(){
		calculate('discount')
	});
	$('#collection_newprice').keyup(function(){
		calculate('sum')
	});
});
function calculate(from){
	price = $('#collection_price').val();
	price = (price=='') ? '0' : price;
	price = cutNumberSeparate(price);
	
	if(from=='discount'){
		discount = $('#collection_discount').val();
		discount = (discount=='') ? '0' : discount;
		discount = cutNumberSeparate(discount);
		Array_dis = getDiscount(discount).split('||');
		dis = Array_dis[0];
		dis_type = Array_dis[1];
		dis = cutNumberSeparate(dis);
		
		sum = (dis_type==1) ? price*((100-dis)/100) : price-discount;
		$('#collection_newprice').val(number_format(sum,2,'.',','));
	}else{
		sum = $('#collection_newprice').val();
		sum = (sum=='') ? '0' : sum;
		sum = cutNumberSeparate(sum);
		
		discount = 100-((sum*100) / price);
		if(Math.floor(discount)==discount){
			if(discount==0) $('#collection_discount').val(discount);
			else			$('#collection_discount').val(discount+'%');
		}else{
			discount = price-sum;
			$('#collection_discount').val(number_format(discount,2,'.',','));
		}
	}
}
</script>
<?php }?>