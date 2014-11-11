<header>
	<h1><?php echo lang('orderandpayment');?></h1>
	<hr>
	<div class="headImage">
		<img alt="" src="img/contactus-h.png">
	</div>
</header>

<div class="innerContent">
	<div class="small-12 large-8 columns"><br>
		<?php 
		if(empty($getMain)){
			echo '<div style="text-align:center; margin:100px;">'.lang('nodata').'</div>';
		}else{
			$main_howtobuy = $getMain["main_howtobuy"];
			
			echo html_entity_decode($main_howtobuy);
		}?>
	</div>
	<div class="small-6 columns"></div>
</div>