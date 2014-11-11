<header>
	<h1><?php echo lang('aboutus');?></h1>
	<hr>
	<div class="headImage">
		<img src="img/aboutus-h.png" alt="">
	</div>
</header>

<div class="innerContent">
	<div class="small-12 large-8 columns"><br>
		<?php 
		if(empty($getMain)){
			echo '<div style="text-align:center; margin:100px;">'.lang('nodata').'</div>';
		}else{
			$main_aboutus = $getMain["main_aboutus"];
			
			echo html_entity_decode($main_aboutus);
		}?>
	</div>
	<div class="small-6 columns"></div>
</div>