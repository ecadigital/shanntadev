<?php 
if(!empty($listCategories)){
	foreach($listCategories as $list){
		$collection_categories_id = $list["collection_categories_id"];
		$img_db = $list["collection_categories_banner_path"];
		$img_path = '';
		if($img_db!=''){
			$path = "public/upload/collection/original/".basename($img_db);
			$dir_file = DIR_FILE.$path;
			if(file_exists($dir_file)){
				$img_path = '<img src="'.DIR_ROOT.$path.'" alt="">';
				echo '
				<div class="row">
					<a href="products.php?col='.$collection_categories_id.'">'.$img_path.'</a>
				</div>';
			}
		}
	}
}