<h3>รายการหมวดหมู่สินค้า</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>product/backend/index">รายการสินค้า</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	รายการหมวดหมู่สินค้า
    
    <div style="float:right;">
		<a href="<?php echo DIR_ROOT?>product/backend/add_categories"><input type="submit" class="button_gray" value="เพิ่มข้อมูลหมวดหมู่สินค้า" /></a>
    </div>
</div>
<div class="clear" style="height:10px;"></div>

<div id="boxContent"></div>

<script>
$(document).ready(function (){
	loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
});
</script>