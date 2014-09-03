<h3> Jewely D.I.Y</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
     Jewely D.I.Y
    
    <div style="float:right;">
		<a href="<?php echo DIR_ROOT?>jewely/backend/add_jewely"><input type="submit" class="button_gray" value="เพิ่ม Jewely D.I.Y" /></a>
    </div>
</div>
<div class="clearfix formRow" style="margin-top:10px;">
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