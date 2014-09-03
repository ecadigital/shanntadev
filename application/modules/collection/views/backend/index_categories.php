<h3>รายการหมวดหมู่คอลเลคชั่น</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>collection/backend/index">รายการคอลเลคชั่น</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	รายการหมวดหมู่คอลเลคชั่น
    
    <div style="float:right;">
		<a href="<?php echo DIR_ROOT?>collection/backend/add_categories"><input type="submit" class="button_gray" value="เพิ่มข้อมูลหมวดหมู่คอลเลคชั่น" /></a>
    </div>
</div>
<div class="clear" style="height:10px;"></div>

<div id="boxContent"></div>

<script>
$(document).ready(function (){
	loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
});
</script>