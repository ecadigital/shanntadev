<?php 
$this->modelJewely = $this->load->model('jewely/Jewelymodel');
?>
<header>
	<h1><?php echo lang('faq');?></h1>
	<!-- <hr> -->
	<div class="headImage">
		<img src="img/contactus-h.png" alt="">
	</div>
	<hr/>
</header>
<?php if(empty($listFaq)){?>
	<div style="height:150px; text-align:center; margin-top:50px;"><?php echo lang('nodata');?></div>
<?php }else{?>
<div class="innerContent">
	<?php 
	foreach($listFaq as $list){		
		echo '
		<div class="small-12 large-7 columns end">
			<h3>'.$list['faq_question'].'</h3>
		</div>
		<div class="small-12 columns cms end"><p>'.html_entity_decode($list['faq_answer']).'</p></div><!-- CMS -->
		<div class="clearfix"></div>
		<hr>';
	
	}?>
</div>
<?php }?>