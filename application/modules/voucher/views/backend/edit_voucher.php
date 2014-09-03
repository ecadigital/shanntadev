<?php if(isset($redirect)){ echo $redirect; }else{ 
$admin= $this->session->userdata('admin');
?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery.chosen.min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/chzn.css" charset="utf-8" />

<h3><?php echo lang('product_voucher_edit');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>product/backend/index"><?php echo lang('product_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>product/backend/index_voucher"><?php echo lang('product_voucher');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo lang('product_voucher_edit');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="product_voucher_form" name="product_voucher_formEdit" target="myIframe" action="<?php echo DIR_ROOT?>product/backend/edit_voucher">
        <div class="widget">
            <div class="formRow">
                <div class="grid3">
                    <label class="lbl" for="product_categories_id"><?php echo lang('product_set');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid4">                    
                    <select id="product_categories_id" name="product_categories_id" class="sep_bo">
                        <?php 
						if(!empty($listPackage)){
							foreach($listPackage as $list){								
								echo '<optgroup label="'.$list["product_categories_name"].'">';
								$listSets = $this->model->listPackageEach($list["product_categories_id"]);
								if(!empty($listSets)){
									foreach($listSets as $listSet){
										echo '<option value="'.$listSet["product_categories_id"].'" >'.$listSet["product_categories_name"].'</option>';
									}
								}
								echo '</optgroup>';
							}
						}
						/*if(!empty($listVoucherParent)){
							foreach($listVoucherParent as $list){
                        		echo '<option value="'.$list["product_voucher_id"].'" '; echo ($list["product_voucher_id"] == $listEditVoucher['product_voucher_parent_id'])?'selected="selected"':''; echo '>'.$list["product_voucher_name"].'</option>';
							}
						}*/
						?>
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            
            <div class="formRow">
                <div class="grid3">
                    <label class="lbl fl" for="product_voucher_name"><?php echo lang('product_voucher_name');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid4">
                    <input type="text" id="product_voucher_name" name="product_voucher_name" value="<?php echo $listEditVoucher['product_voucher_name'];?>">
                </div>
            </div>  
            <div class="clear"></div>
            
            <div class="formRow">
                <div class="grid3">
                    <label class="lbl fl" for="product_voucher_discount"><?php echo lang('product_voucher_discount');?></label>
                </div>
                <div class="grid6">
                    <input type="text" id="product_voucher_discount" name="product_voucher_discount" style="width:100px;" value="<?php echo $listEditVoucher['product_voucher_discount'];?>">
                    <div class="txt_notify" style="margin-top:5px;">* สามารถกรอกส่วนลดเป็นจำนวนเต็มบาท (20) หรือส่วนลดเปอร์เซ็นต์ (20%) ได้</label></div>
                </div>
            </div>
           	<div class="clear" style="height:10px;"></div>
            
            <div class="formRow">
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="hidden" id="product_voucher_id" name="product_voucher_id" value="<?php echo $listEditVoucher['product_voucher_id']?>"></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
			</div>
		</div>
	</form>
</div>

<script>
$(document).ready(function(){
	
	$('#product_categories_id').chosen();	
	
	$("#product_voucher_form").validate({
		rules: {
			'product_voucher_name' : {
				required: true,
			},
	   },
	   submitHandler: function(form) {
			document.product_voucher_formEdit.submit();
		}
	});
});
</script>
<?php }?>