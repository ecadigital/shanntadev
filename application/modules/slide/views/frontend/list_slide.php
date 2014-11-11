<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<?php 
if(!empty($listSlide)){
	foreach($listSlide as $list){
		$slide_id = $list["slide_id"];
		$keyhead = $list["slide_keyhead"];
		$keymessage = $list["slide_keymessage"];
		$position = $list["slide_position"];
		$img_db = $list["slide_image"];
		
		$img_path = DIR_PUBLIC."images/noimage.png";
		if($img_db!=''){
			$path = "public/upload/slide/original/".basename($img_db);
			$dir_file = DIR_FILE.$path;
			if(file_exists($dir_file)){
				$img_path = DIR_ROOT.$path;
						
				$pull = '7';
				if($position=='L') $pull = '7';
				else if($position=='C') $pull = '4';
				else if($position=='R') $pull = '1';
				?>
				
				<div class="slide"> 
					<img src="<?php echo $img_path;?>" alt=""> 
					<div class="slide_content">
						<div class="slide_content_wrap">
							<h4 class="title"><?php echo $keyhead;?></h4>               
							<p class="description"><?php echo nl2br($keymessage);?></p> 
							<!--<a class="readmore" href="#">MORE CONTENT</a> -->
						</div>
					</div>
				</div>
				<!--
				<article class="row show-for-medium-up catagorieBanner">
					<section class="medium-6 large-7 medium-push-6 large-push-5 columns">
						<img src="<?php echo $img_path;?>" alt="">
					</section>
					<section class="medium-6 large-5 medium-pull-6 large-pull-7 columns details">
						<h1><?php echo strtoupper($keyhead);?></h1>
						<article>
							<p><strong><?php echo nl2br($keymessage);?></strong></p>
						</article>
					</section>
				</article>-->
			<?php 
			}
		}
	}
}?>