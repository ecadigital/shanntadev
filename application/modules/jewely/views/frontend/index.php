<?php 
$this->modelJewely = $this->load->model('jewely/Jewelymodel');
?>
<header>
	<h1>JEWELRY D.I.Y</h1>
	<!-- <hr> -->
	<div class="headImage">
		<img src="img/diy-h.png" alt="">
	</div>
</header>
<?php if(empty($getJewely)){?>
	<div style="height:150px; text-align:center; margin-top:50px;"><?php echo lang('nodata');?></div>
<?php }else{?>
<div class="innerContent">
	<div class="small-12 large-7 columns end">
		<h3><?php echo $getJewely['jewely_name'];?></h3>
		<p><!--<b>Artist : </b> Charintip B. --><b><?php echo lang('jewely_date');?> : </b> <?php echo date("d/m/Y",strtotime($getJewely['jewely_date_added']));?></p><br>
	</div>
	<div class="medium-8 large-7 medium-centered columns">
	</div><br>
	<div class="small-12 columns cms end"><?php echo html_entity_decode($getJewely['jewely_detail']);?></div><!-- CMS -->
	<div class="clearfix"></div>
	<hr>
	<?php 
	$listJewely = $this->modelJewely->listAllJewely($lang,$getJewely['jewely_id']);
	if(!empty($listJewely)){
	?>		
		<nav class="moreDiy">
			<h2>More D.I.Y</h2>
			<div>
				<?php 
				foreach($listJewely as $list){
					$jewely_id = $list["jewely_id"];
					$jewely_name = $list["jewely_name"];
					$img_db = $this->model->getFirstJewelyImage($jewely_id);
					$img_path = DIR_PUBLIC."images/noimage.png";
					if($img_db!=''){
						$path = "public/upload/jewely/thumbnails/".basename($img_db);
						$dir_file = DIR_FILE.$path;
						if(file_exists($dir_file)){
							$img_path = DIR_ROOT.$path;
						}
					}
					echo '
					<div class="item">
						<a href="diy.php?id='.$jewely_id.'">
							<img src="'.$img_path.'" alt="">
							<aside>'.$jewely_name.'</aside>
						</a>
					</div>';
				}?>
			</div>
		</nav><!-- moreDiy -->
	<?php }?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".moreDiy > div").owlCarousel({
			margin: 15,
			responsive: {
				0: {
					items: 2,
				},
				640:{
					items: 3,
				}
			}
		});
	});
</script>
<?php }?>

		<?php /*
if(!empty($listLookbook)){
	foreach($listLookbook as $list){
		$img_db = $list["lookbook_path"];
		$img_path = '';
		if($img_db!=''){
			$path = "public/upload/lookbook/original/".basename($img_db);
			$dir_file = DIR_FILE.$path;
			if(file_exists($dir_file)){
				$img_path = '<img src="'.DIR_ROOT.$path.'" alt="">';
			}
		}
		echo '
		<div class="row">
			<a href="#">'.$img_path.'</a>
		</div>';
	}
}*/