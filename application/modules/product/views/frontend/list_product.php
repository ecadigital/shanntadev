<?php 
$num=0;
if(!empty($listProduct)){
	$no=1;//($page-1)*$limit;
	foreach($listProduct as $list){
		$num++;
				
		$product_id = $list["product_id"];
		$img_db = $this->model->getFirstProductImage($product_id);
		
		$img_path = DIR_PUBLIC."images/noimage.png";
		if($img_db!=''){
			$path = "public/upload/product/thumbnails/".basename($img_db);
			$dir_file = DIR_FILE.$path;
			if(file_exists($dir_file)){
				$img_path = DIR_ROOT.$path;
			}
		}
		?>
	
		<article class="small-6 large-4 columns end products">
			<h1><?php echo $list['product_name'];?>
				<?php echo $list['product_detail'];?>
			</h1>
			<section class="small-10 columns small-centered" style="height:248px">
				<img src="<?php echo $img_path;?>" alt="" style="max-width:190px; max-height:248px;">
			</section>
			<section class="small-12 columns priceTag">
				<div class="small-6 columns price"><?php echo number_format($list['product_price']);?> <b>THB</b></div>
				<div class="small-6 columns"><a class="addToCart medium-8 large-7" href="javascript:alert(1);"><i class="fa fa-shopping-cart"></i> <b>ADD TO CART</b></a></div>
			</section>
			<section class="details" style="width:900px;">
				<div class="medium-6 columns productDetailTrack">
					<h1><?php echo $list['product_name'];?></h1>
					<div class="inner"><?php echo $list['product_detail'];?></div>
					<hr class="dotted">
					<div class="medium-6 large-8 columns price">
						<?php echo number_format($list['product_price']);?> <b>THB</b>
					</div>
					<div class="medium-6 large-4 columns">
						<a class="addToCart" href="#"><i class="fa fa-shopping-cart"></i> <b>ADD TO CART</b></a>
					</div>
					<div class="clearfix"></div>
					<hr class="dotted">
					<span>More Photo</span><br>
					<div class="thumbnails clearfix">
						<?php 
						$img_first='';
						$numImg=0;
		
						$listProductImages = $this->model->listProductImages($product_id);		
						if(empty($listProductImages)){
							foreach($listProductImages as $listImg){
								$path = "public/upload/product/thumbnails/".basename($listImg['product_images_path']);
								$dir_file = DIR_FILE.$path;
								if(file_exists($dir_file)){
									$numImg++;
									$img_path = DIR_ROOT.$path;
									if($numImg==1) $img_first = DIR_ROOT."public/upload/product/original/".basename($listImg['product_images_path']);
									echo '<div><img src="'.$img_path.'" alt="" style="max-width:108px; max-height:90px;"></div>';
								}									
							}
						}
						?>
					</div>
				</div>
				<div class="medium-6 columns productDetailTrack">
					<!-- <div class="fullImage">
						<?php if($img_first!='') echo '<img src="'.$img_first.'" alt="">';?>
					</div> -->
					<div class="fullImage">
						<img src="<?php echo __images__;?>/daisy.jpg" alt="">
						<!-- <img src="<?php echo __images__;?>/demo/product5.png" alt=""> -->
					</div>
				</div>
			</section>
		</article>
<?php }}?>
<script type="text/javascript">
	$(document).ready(function(){
		if(Modernizr.mq('only screen and (min-width: 40.063em)') || $("html").hasClass("lt-ie9")){
			$(".products").hover(function(){
				$(this).children(".priceTag").css("visibility","visible");
				$(this).children("h1").css("visibility","visible");
			},function(){
				$(this).children(".priceTag").css("visibility","hidden");
				$(this).children("h1").css("visibility","hidden");
			});
			$(".products").each(function(){
				$(this).colorbox({
					html: $(this).children(".details").html(),
					fixed: true,
					//maxWidth: "1000",
					previous: '<i class="fa fa-angle-left"></i>',
					next: '<i class="fa fa-angle-right"></i>',
					width: "100%",
					maxWidth: "1128",
					height: "auto",
					rel: "group1",
					onComplete: function(){
						$(".fullImage").zoom();
					}
				});
			});
		}
	});
</script>