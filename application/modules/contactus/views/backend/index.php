<h3>รายการผู้ติดต่อ</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    รายการผู้ติดต่อ
</div>
<div class="clearfix formRow">
	<?php 
        echo $this->bflibs->mkSelect('perPage','#boxContent',$targetpage,$perPage);
        echo $this->bflibs->mkSelect('searchData','#boxContent',$targetpage);
    ?>
</div>
<div class="clear"></div>
<div id="boxContent"></div>

<script>
$(document).ready(function (){
	loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
});
</script>