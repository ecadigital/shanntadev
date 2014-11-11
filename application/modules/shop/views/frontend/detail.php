<header>
	<h1><?php echo lang('newsandevent');?></h1>
	<div class="headImage">
		<img src="img/contactus-h.png" alt="">
	</div>
</header>
<div class="innerContent cms">
	<?php 
	$this->modelNews = $this->load->model('news/Newsmodel');
	$no=0;
	if(empty($getNews)){
		echo '<div style="text-align:center; margin:100px;">'.lang('nodata').'</div>';
	}else{
		$news_id = $getNews["news_id"];
		$news_name = $getNews["news_name"];
		$news_detail = $getNews["news_detail"];
		$news_date = $getNews["news_date_added"];
		
		$img_db = $this->modelNews->getFirstNewsImage($news_id);
		$img_path = DIR_PUBLIC."images/noimage.png";
		if($img_db!=''){
			$path = "public/upload/news/original/".basename($img_db);
			$dir_file = DIR_FILE.$path;
			if(file_exists($dir_file)){
				$img_path = DIR_ROOT.$path;
			}
		}
		echo '
		<div class="arrow_box inner bottom vleft contentHead">
			<img src="'.$img_path.'" alt="">
		</div>
		<h1 style="font-weight:bold;color:#d8d2d5">'.date("d.m.Y",strtotime($news_date)).'</h1>
		<h3>'.$news_name.'</h3>
		<p>'.html_entity_decode($news_detail).'</p>';
	}?>
</div><!-- .cms -->
<hr>
<?php 
if(!empty($randomNews)){
	$news_id = $randomNews["news_id"];
	$news_name = $randomNews["news_name"];
	$news_detail = $randomNews["news_detail"];
	$news_date = $randomNews["news_date_added"];
	
	$img_db = $this->modelNews->getFirstNewsImage($news_id);
	$img_path = DIR_PUBLIC."images/noimage.png";
	if($img_db!=''){
		$path = "public/upload/news/original/".basename($img_db);
		$dir_file = DIR_FILE.$path;
		if(file_exists($dir_file)){
			$img_path = DIR_ROOT.$path;
		}
	}
	echo '
	<div id="news-nav">
		<h2>'.lang('newsandeventmore').'</h2>
		<a href="news.php">'.lang('back').' ></a>
		<a href="news1.php?id='.$news_id.'">
			<div class="medium-6 columns">
				<div class="arrow_box inner aright">
					<img src="'.$img_path.'" alt="">
				</div>
			</div>
			<div class="medium-6 columns rightContent">
				<h1 style="font-weight:bold;color:#d8d2d5">'.date("d.m.Y",strtotime($news_date)).'</h1>
				<h3>'.$news_name.'</h3>
				<p>'.$this->bflibs->getSubStr(strip_tags(html_entity_decode($news_detail)),0,220).'</p>
			</div>
		</a>
	</div>';
}
?>