<?php 
$this->modelJewely = $this->load->model('jewely/Jewelymodel');

if(!empty($getJewely)){
	$jewely_id = $getJewely["jewely_id"];
	$jewely_name = $getJewely["jewely_name"];
	$jewely_detail = $getJewely["jewely_detail"];
	
	$img_db = $this->modelJewely->getFirstJewelyImage($jewely_id);
	$img_path = DIR_PUBLIC."images/noimage.png";
	if($img_db!=''){
		$path = "public/upload/jewely/original/".basename($img_db);
		$dir_file = DIR_FILE.$path;
		if(file_exists($dir_file)){
			$img_path = DIR_ROOT.$path;
		}
	}
	echo '
	<section class="small-7 medium-7 large-6 columns details">
		<h1>JEWELRY D.I.Y</h1>
		<section>
			<strong>'.$jewely_name.'</strong><br>
			<p>'.$this->bflibs->getSubString(strip_tags(html_entity_decode($jewely_detail)),100).' ... </p>
			<a href="diy.php?id='.$jewely_id.'" class="button">'.lang('readmore').'</a>
		</section>
	</section><!-- details -->
	<section class="small-5 medium-5 large-6 columns rightImage">
		<img src="'.$img_path.'" alt=""><!-- height = 220px -->
	</section><!-- rightImage -->';
}