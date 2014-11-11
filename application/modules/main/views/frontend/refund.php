<header>
	<h1><?php echo lang('refundpolicy');?></h1>
	<hr>
	<div class="headImage">
		<img alt="" src="img/contactus-h.png">
	</div>
</header>

<div class="innerContent">
	<?php 
	if(empty($getMain)){
		echo '<div style="text-align:center; margin:100px;">'.lang('nodata').'</div>';
	}else{
		$main_refund = $getMain["main_refund"];
		
		echo html_entity_decode($main_refund);
	}?>
</div>