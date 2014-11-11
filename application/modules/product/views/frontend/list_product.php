<?php 
$this->model = $this->load->model('product/Product_frontmodel');

$num=0;
if(!empty($listProduct)){
	$no=1;//($page-1)*$limit;
	foreach($listProduct as $list){
		$num++;
				
		$product_id = $list["product_id"];
		$product_name = $list["product_name"];
		$product_detail = $list["product_detail"];
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
			<h1><?php echo $product_name;?>
				<?php echo $product_detail;?>
			</h1>
			<section class="small-10 columns small-centered" style="height:248px">
				<img src="<?php echo $img_path;?>" alt="" style="max-width:190px; max-height:248px;">
			</section>
			<section class="small-12 columns priceTag">
				<div class="small-6 columns price"><?php echo number_format($list['product_price']);?> <b><?php echo $list['product_currency'];?></b></div>
				<div class="small-6 columns"><a class="addToCart medium-8 large-7" href="#"><i class="fa fa-shopping-cart"></i> <b><?php echo strtoupper(lang('addtocart'));?></b></a></div>
			</section>
			<section class="details" style="width:900px;">
				<div class="medium-6 columns productDetailTrack">
					<div id="v_addtocart_<?php echo $product_id;?>" class="v_addtocart" style="color:#31B404; display:none;"><img src="<?php echo DIR_PUBLIC?>images/elements/uploader/uploaded.png">&nbsp;&nbsp;<?php echo lang('v_addtocart1').' '.$list['product_name'].' '.lang('v_addtocart2');?></div>
					<h1><?php echo $list['product_name'];?></h1>
					<div class="inner"><?php echo $list['product_detail'];?></div>
					<hr class="dotted">
					<div class="medium-6 large-8 columns price">
						<?php echo number_format($list['product_price']);?> <b><?php echo $list['product_currency'];?></b>
					</div>
					<div class="medium-6 large-4 columns">
						<a class="addToCart" href="javascript:void(0)" onclick="addCart('<?php echo $list['product_id'];?>','<?php echo $lang_id;?>')"><i class="fa fa-shopping-cart"></i> <b><?php echo strtoupper(lang('addtocart'));?></b></a>
					</div>
					<div class="clearfix"></div>
					<hr class="dotted">
					<span><?php echo lang('morephoto');?></span><br>
					<div class="thumbnails clearfix">
						<?php 
						$img_first='';
						$numImg=0;
		
						$listProductImages = $this->model->listProductImages($product_id);		
						if(!empty($listProductImages)){
							foreach($listProductImages as $listImg){
								
								$path = "public/upload/product/original/".basename($listImg['product_images_path']);
								$dir_file = DIR_FILE.$path;
								if(file_exists($dir_file)){
									$numImg++;
									$img_path = DIR_ROOT.$path;
									if($numImg==1) $img_first = DIR_ROOT."public/upload/product/original/".basename($listImg['product_images_path']);
									echo '<div onclick="showFullImg(\''.$product_id.'\',\''.$img_path.'\')" ><img src="'.$img_path.'" alt="" style="max-width:108px; max-height:90px; cursor:pointer;" class="thumb_product_'.$product_id.'"></div>';
								}									
							}
						}
						?>
					</div>
				</div>
				<div class="medium-6 columns productDetailTrack">
					<div class="fullImage" id="fullImage_<?php echo $product_id;?>">
						<img src="<?php echo $img_first;?>" alt="">
					</div>
				</div>
			</section>
		</article>
<?php }}?>
<script type="text/javascript">
function showFullImg(product_id,path){
	//alert(product_id+'---'+$('div#cboxLoadedContent > div#fullImage_'+product_id).html());
	$('div#cboxLoadedContent #fullImage_'+product_id).html('<img src="'+path+'" alt="">');
	$(".fullImage").zoom();
}

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