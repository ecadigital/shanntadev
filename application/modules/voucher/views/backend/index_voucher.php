<h3>ข้อมูล Voucher</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index"><?php echo lang('menu_home');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
    ข้อมูล Voucher
    
    <div style="float:right;"><a href="<?php echo DIR_ROOT?>product/backend/add_voucher"><input type="submit" class="button_gray" value="<?php echo lang('product_voucher_add');?>" /></a></div>
</div>
<div class="clear" style="height:10px;"></div>

<div id="boxContent"></div>

<script>
$(document).ready(function (){
	loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
});
</script>