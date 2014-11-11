<?php 
$this->model = $this->load->model('shop/Shopmodel');
?>
<h3>ข้อมูลที่ตั้งร้าน/สาขา</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">Home</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    ข้อมูลที่ตั้งร้าน/สาขา
	
    <div style="float:right;">
    	<a href="<?php echo DIR_ROOT?>shop/backend/add_shop"><input type="submit" class="button_gray" value="เพิ่มข้อมูลที่ตั้งร้าน/สาขา" /></a>&nbsp;&nbsp;
    </div>
</div>
<div class="clear"></div>
<div class="clearfix formRow" id="filter">
	<?php 
        echo $this->bflibs->mkSelect('perPage','#boxContent',$targetpage,$perPage);
        echo $this->bflibs->mkSelect('searchData','#boxContent',$targetpage);
    ?>
</div>
<div class="clear"></div>
<div id="boxContent"></div>

<script>
$(document).ready(function (){
	//loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
	loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
	$('#type_boxContent,#perPage_boxContent').change(function(){
		loadPage('<?php echo DIR_ROOT.$targetpage;?>','#boxContent');
	})
	$('#searchData_boxContent').keyup(function(){
		loadPage('<?php echo DIR_ROOT.$targetpage;?>/type/'+$('#type_boxContent').val(),'#boxContent');
	})
});
</script>