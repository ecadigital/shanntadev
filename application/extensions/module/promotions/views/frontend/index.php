<div id="boxContent">
	<?php if(!empty($listPromotions)){?>
		<ul class="promotions_rows">
		<?php foreach($listPromotions as $list){?>
			<li>
				<a href="<?php echo DIR_ROOT?>promotions/frontend/detail/id/<?php echo $list['promotions_id'];?>"><h3><?php echo $list['promotions_name'];?></h3></a>
			</li>
	<?php } ?>
		</ul>
	<?php }else{?>
		<div><?php echo lang('web_no_data');?></div>
	<?php }?>
	<?php echo $page_description.$paginaion;?>
</div>