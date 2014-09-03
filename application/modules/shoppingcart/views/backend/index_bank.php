<h3><?php echo lang('sp_bank_ii');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <?php echo lang('sp_bank_ii');?>
    
    <div style="float:right;">
		<a href="<?php echo DIR_ROOT?>shoppingcart/backend/add_bank"><input type="submit" class="button_gray" value="เพิ่มบัญชีธนาคาร" /></a>
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