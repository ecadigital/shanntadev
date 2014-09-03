<h3><?php echo lang('product_promotion');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index"><?php echo lang('menu_home');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>product/backend/index"><?php echo lang('product_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <?php echo lang('product_promotion');?>
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