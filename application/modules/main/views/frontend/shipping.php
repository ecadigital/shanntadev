<header>
	<h1 style="font-weight:bold;color:#d8d2d5"><?php echo lang('shippinginformation');?></h1>
	<hr>
	<div class="headImage">
		<img src="img/shipping-h.png" alt="">
	</div>
</header>

<div class="innerContent">
	<div class="small-12 large-8 columns"><br>
		<?php 
		if(empty($getMain)){
			echo '<div style="text-align:center; margin:100px;">'.lang('nodata').'</div>';
		}else{
			$main_shipping = $getMain["main_shipping"];
			
			echo html_entity_decode($main_shipping);
		}?>
	</div>
	<div class="small-6 columns"></div>
</div>