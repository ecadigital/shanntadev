<?php 
$num=0;
if(!empty($getCategories)){
			
	$categories_id = $getCategories["collection_categories_id"];
	$img_db = $getCategories["collection_categories_banner_path"];
	
	$img_path = DIR_PUBLIC."images/noimage.png";
	if($img_db!=''){
		$path = "public/upload/collection/original/".basename($img_db);
		$dir_file = DIR_FILE.$path;
		if(file_exists($dir_file)){
			$img_path = DIR_ROOT.$path;
		}
	}
	?>
	
	<article class="row show-for-medium-up catagorieBanner">
		<section class="medium-12 columns">
			<img src="<?php echo $img_path;?>" alt="">
		</section>
	</article>
<?php }?>