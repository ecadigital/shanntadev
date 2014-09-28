<?php 
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
}