<header>
	<h1><?php echo lang('newsandevent');?></h1>
	<div class="headImage">
		<img src="img/contactus-h.png" alt="">
	</div>
</header>
<div class="innerContent">
	<?php 
	$this->modelNews = $this->load->model('news/Newsmodel');
	$no=0;
	if(empty($listNews)){
		echo '<div style="text-align:center; margin:100px;">'.lang('nodata').'</div>';
	}else{
		foreach($listNews as $list){
			$no++;
			$news_id = $list["news_id"];
			$news_name = $list["news_name"];
			$news_detail = $list["news_detail"];
			$news_date = $list["news_date_added"];
			
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
			<a href="news1.php?id='.$news_id.'" class="row">
				<div class="medium-6'; echo ($no%2==1) ? '' : ' medium-push-6'; echo ' columns news2">
					<div class="arrow_box inner '; echo ($no%2==1) ? 'aright' : 'left'; echo '">
						<img src="'.$img_path.'" alt="">
					</div>
				</div>
				<div class="medium-6'; echo ($no%2==1) ? '' : ' medium-pull-6'; echo ' columns p-news">
					<h1 style="font-weight:bold;color:#d8d2d5">'.date("d.m.Y",strtotime($news_date)).'</h1>
					<h3>'.$news_name.'</h3>
						<p>'.$this->bflibs->getSubStr(strip_tags(html_entity_decode($news_detail)),0,220).'</p>
				</div>
			</a>';
		}
	}
	?>
	<!--<a href="news1.php" class="row">
		<div class="medium-6 columns news2">
			<div class="arrow_box inner aright">
				<img src="img/demo/news1.jpg">
			</div>
		</div>
		<div class="medium-6 columns p-news">
			<h1 style="font-weight:bold;color:#d8d2d5">25.04.2014</h1>
			<h3>The PANDORA story is about a company with a
				distinctive brand and distinctive products A
				that in just  years has made exceptional.</h3>
				<p>It all started nearly 30 years ago. Back in 1982 a jeweller’s shop that
				would one day become PANDORA was established in modest surro
				undings in Copenhagen, Denmark, by Danish goldsmith Per Enevold
				sen and his wife Winnie.</p>
		</div>
	</a>
	<a href="news1.php" class="row">
		<div class="medium-6 medium-push-6 columns news2">
			<div class="arrow_box inner left">
				<img src="img/demo/news3.jpg">
			</div>
		</div>
		<div class="medium-6 medium-pull-6 columns p-news">
			<h1 style="font-weight:bold;color:#d8d2d5">25.04.2014</h1>
			<h3>The PANDORA story is about a company with a
				distinctive brand and distinctive products A
				that in just  years has made exceptional.</h3>
				<p>It all started nearly 30 years ago. Back in 1982 a jeweller’s shop that
				would one day become PANDORA was established in modest surro
				undings in Copenhagen, Denmark, by Danish goldsmith Per Enevold
				sen and his wife Winnie.</p>
		</div>
	</a>
	<a href="news1.php" class="row">
		<div class="medium-6 columns news2">
			<div class="arrow_box inner aright">
				<img src="img/demo/news4.jpg">
			</div>
		</div>
		<div class="medium-6 columns p-news">
			<h1 style="font-weight:bold;color:#d8d2d5">25.04.2014</h1>
			<h3>The PANDORA story is about a company with a
				distinctive brand and distinctive products A
				that in just  years has made exceptional.</h3>
				<p>It all started nearly 30 years ago. Back in 1982 a jeweller’s shop that
				would one day become PANDORA was established in modest surro
				undings in Copenhagen, Denmark, by Danish goldsmith Per Enevold
				sen and his wife Winnie.</p>
		</div>
	</a>
	<a href="news1.php" class="row">
		<div class="medium-6 medium-push-6 columns news2">
			<div class="arrow_box inner left">
				<img src="img/demo/news2.jpg">
			</div>
		</div>
		<div class="medium-6 medium-pull-6 columns p-news">
			<h1 style="font-weight:bold;color:#d8d2d5">25.04.2014</h1>
			<h3>The PANDORA story is about a company with a
				distinctive brand and distinctive products A
				that in just  years has made exceptional.</h3>
				<p>It all started nearly 30 years ago. Back in 1982 a jeweller’s shop that
				would one day become PANDORA was established in modest surro
				undings in Copenhagen, Denmark, by Danish goldsmith Per Enevold
				sen and his wife Winnie.</p>
		</div>
	</a>-->
	<div class="clearfix"></div>
</div>

<?php /*
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
}*/