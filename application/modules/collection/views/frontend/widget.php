<?php 
if(!empty($getCategories)){
	$collection_categories_id = $getCategories["collection_categories_id"];
	$keyhead = $getCategories["collection_categories_home_keyhead"];
	$keymessage = $getCategories["collection_categories_home_keymessage"];
	$img_db = $getCategories["collection_categories_home_path"];
	$img_path = '';
	if($img_db!=''){
		$path = "public/upload/collection/original/".basename($img_db);
		$dir_file = DIR_FILE.$path;
		if(file_exists($dir_file)){
			$img_path = '<img src="'.DIR_ROOT.$path.'" alt="">';
		}
	}
	echo '
	<section class="small-7 medium-7 large-6 columns details">
		<h1>'.lang('collection').'</h1>
		<section>
			<h2>'.$keyhead.'</h2>
			<p>'.$keymessage.'<br></p>
			<a href="products.php?col='.$collection_categories_id.'" class="button">'.lang('seemore').'</a>
		</section>
	</section><!-- details -->
	<section class="small-5 medium-5 large-6 columns rightImage">
		'.$img_path.'<!-- height = 220px -->
	</section><!-- rightImage -->';
}