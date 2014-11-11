<?php 
$num=0;
$txt_head = '';
$txt_slide = '';

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
				
		if($num==1) $txt_head .= '<div class="medium-2 columns item arrow_box " data-merge="1"><a href="javascript:void(0);">'.$name.'</a></div>';
		if($num==2) $txt_head .= '<div class="medium-2 columns item arrow_box " data-merge="1"><a href="javascript:void(0);">'.$name.'</a></div>';
		if($num==3) $txt_head .= '<div class="medium-2 columns item arrow_box " data-merge="1"><a href="javascript:void(0);">'.$name.'</a></div>';
		if($num==4) $txt_head .= '<div class="medium-2 columns item arrow_box active" data-merge="1"><a href="javascript:void(0);">'.$name.'</a></div>';
		if($num==5) $txt_head .= '<div class="medium-4 columns item arrow_box " data-merge="2"><a href="javascript:void(0);">'.$name.'</a></div>';
		
		$txt_slide .= '
		<article class="item">
			<section class="small-12 medium-7 medium-push-5 columns">
				<img src="'.$img_path.'" alt="">
			</section>
			<section class="small-12 medium-5 medium-pull-'.$pull.' columns details" '; if($num==5) $txt_slide .= ' style="margin-top:5px;"'; $txt_slide .= '>
				<h1'; if($num==5) $txt_slide .= ' style="font-size:30px;"'; else  $txt_slide .= ' style="font-size:40px;"'; $txt_slide .= '>'.strtoupper($keyhead).'</h1>
				<p><strong>'.$keymessage.'</strong></p>
				<a href="products.php?id='.$categories_id.'" class="button">'.lang('seeall').'</a>
			</section>
			<div class="clearfix"></div>
		</article>';
}}?>

<nav class="paginationCatagorieSlider row show-for-medium-up">
	<?php echo $txt_head;?>
	<div class="" data-merge="1"></div>
</nav>
<div class="catagorieSlider"><?php echo $txt_slide;?></div>