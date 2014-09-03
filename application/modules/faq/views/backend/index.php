<h3> FAQ</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
     FAQ
    
    <div style="float:right;">
		<a href="<?php echo DIR_ROOT?>faq/backend/add_faq"><input type="submit" class="button_gray" value="เพิ่ม FAQ" /></a>
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