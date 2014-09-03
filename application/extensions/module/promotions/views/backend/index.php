<div class="box_shadow">
	<div class="fr sep_to" id="content_actions">
		<button class="btn btn_blue sep_bo" onclick="loadAjax('<?php echo DIR_ROOT?>promotions/backend/add_promotions','#','')"><span><?php echo lang('web_add');?></span></button>
	</div>
	<div class="clearfix">
        <?php 
	        echo $this->bflibs->mkSelect('perPage','#boxContent',$targetpage,$perpage);
	        echo $this->bflibs->mkSelect('searchData','#boxContent',$targetpage);
        ?>
    </div>
	<div id="boxContent" class="clearfix"></div>
</div>
<script>
$(document).ready(function (){
	loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
});
</script>