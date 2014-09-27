<?php 
$num=0;
if(!empty($listCategories)){
	$no=1;//($page-1)*$limit;
	foreach($listCategories as $list){
		$num++;
				
		$categories_id = $list["product_categories_id"];
		$name = $list["product_categories_name"];
		$keyhead = $list["product_categories_home_keyhead"];
		$keymessage = $list["product_categories_home_keymessage"];
		$position = $list["product_categories_home_position"];
		$img_db = $list["product_categories_home_path"];
		
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
	
		<article class="item">
			<section class="small-12 medium-7 medium-push-5 columns">
				<img src="<?php echo $img_path;?>" alt="">
			</section>
			<section class="small-12 medium-5 medium-pull-<?php echo $pull;?> columns details">
				<h1><?php echo strtoupper($keyhead);?></h1>
				<p><strong><?php echo $keymessage;?></strong></p>
				<a href="products.php?id=<?php echo $categories_id;?>" class="button"><?php echo lang('seeall');?></a>
			</section>
			<div class="clearfix"></div>
		</article>
<?php }}?>