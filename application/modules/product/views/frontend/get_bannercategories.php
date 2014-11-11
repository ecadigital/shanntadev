<?php 
$num=0;
if(!empty($getCategories)){
			
	$categories_id = $getCategories["product_categories_id"];
	$name = $getCategories["product_categories_name"];
	$keyhead = $getCategories["product_categories_banner_keyhead"];
	$keymessage = $getCategories["product_categories_banner_keymessage"];
	$position = $getCategories["product_categories_banner_position"];
	$img_db = $getCategories["product_categories_banner_path"];
	
	$img_path = DIR_PUBLIC."images/noimage.png";
	if($img_db!=''){
		$path = "public/upload/product/original/".basename($img_db);
		$dir_file = DIR_FILE.$path;
		if(file_exists($dir_file)){
			$img_path = DIR_ROOT.$path;
		}
	}
	$pull = '7';
	if($position=='L') $pull = '7';
	else if($position=='C') $pull = '4';
	else if($position=='R') $pull = '1';
	?>
	
	<article class="row show-for-medium-up catagorieBanner">
		<section class="medium-6 large-7 medium-push-6 large-push-5 columns">
			<img src="<?php echo $img_path;?>" alt="">
		</section>
		<section class="medium-6 large-5 medium-pull-6 large-pull-7 columns details">
			<h1><?php echo strtoupper($keyhead);?></h1>
			<article>
				<p><?php echo $keymessage;?></p>
			</article>
		</section>
	</article>
<?php }?>