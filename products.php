<?php require "inc/init.php"; ?>
<?php require_once("public/config/config.php.inc");
$redirect = "product.php";?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <?php require 'inc/layouts/head-tag.php';?>
        <link rel="stylesheet" href="<?php echo __css__; ?>/fractionslider.css">
        <link rel="stylesheet" href="<?php echo __css__; ?>/owl.carousel.css">
        <link rel="stylesheet" href="<?php echo __css__; ?>/colorbox.css">
        <title>Shannta</title>
    </head>
    <body>
        <?php require "inc/layouts/browserhappy.php"; ?>
        <?php require "inc/layouts/topcartmenu.php"; ?>
        <?php require "inc/layouts/topmenu.php"; ?>
        <article class="row show-for-medium-up catagorieBanner">
            <section class="medium-6 large-7 medium-push-6 large-push-5 columns">
                <img src="<?php echo __images__;?>/demo/product3.png" alt="">
            </section>
            <section class="medium-6 large-5 medium-pull-6 large-pull-7 columns details">
                <h1>EARRINGS</h1>
                <article>
                    <p><strong>Sterling silver, 14k gold. two-tone and an abundance of beautiful gemstones make up the PANDORA</strong></p>
                </article>
            </section>
        </article><!-- catagorieBanner -->
        <div id="content" class="row">
			<?php 
			$num=0;
			$arrList = $mysqli->query("SELECT 	product.product_id,product.product_price,
												product_lang.product_name,
												product_lang.product_detail 
								FROM product_lang 
								LEFT JOIN product ON product.product_id=product_lang.product_id
								WHERE product_lang.language_id='".$defaultLang."' AND product.product_categories_id='1'
								ORDER BY product.product_seq DESC");
				
			if($arrList->num_rows>0){
			while($list = $arrList->fetch_array(MYSQLI_ASSOC)){
				$num++;
				
				$product_id = $list["product_id"];
				$img_db = getFirstProductImage($mysqli,$product_id);
				
				$img_path = DIR_PUBLIC."images/noimage.png";
				if($img_db!=''){
					$path = "public/upload/product/thumbnails/".basename($img_db);
					$dir_file = DIR_FILE.$path;
					if(file_exists($dir_file)){
						$img_path = DIR_ROOT.$path;
					}
				}
				
				$arrImg = $mysqli->query("SELECT * FROM product_images WHERE product_id='".$product_id."' ORDER BY product_images_seq ASC");
				
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
								if($arrImg->num_rows>0){
									while($listImg = $arrImg->fetch_array(MYSQLI_ASSOC)){
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
							<div class="fullImage">
								<?php if($img_first!='') echo '<img src="'.$img_first.'" alt="">';?>
							</div>
						</div>
					</section>
				</article>
				
			<?php 
				/*echo '
					<article class="small-6 large-4 columns '; if($num%3==0) echo 'end '; echo 'products">
						<h1>'.$list['product_name'].'
							'.$list['product_detail'].'
						</h1>
						<section class="small-10 columns small-centered" style="height:248px">
							<img src="'.$img_path.'" alt="" style="max-width:190px; max-height:248px;">
						</section>
						<section class="small-12 columns priceTag">
							<div class="small-6 columns price">'.number_format($list['product_price']).' <b>THB</b></div>
							<div class="small-6 columns"><a class="addToCart" href="javascript:alert(1);"><i class="fa fa-shopping-cart"></i> <b>ADD TO CART</b></a></div>
						</section>
						<section class="details">
							<div class="medium-6 columns productDetailTrack">
								<h1>'.$list['product_name'].'</h1>
								<div class="inner">'.$list['product_detail'].'</div>
								<hr class="dotted">
								<div class="medium-6 large-8 columns price">
									'.number_format($list['product_price']).' <b>THB</b>
								</div>
								<div class="medium-6 large-4 columns">
									<a class="addToCart" href="#"><i class="fa fa-shopping-cart"></i> <b>ADD TO CART</b></a>
								</div>
								<div class="clearfix"></div>
								<hr class="dotted">
								<span>More Photo</span><br>
								<div class="thumbnails clearfix">
									<div><img src="'. __images__.'/demo/product5-thumbnail-1.png" alt=""></div>
									<div><img src="'. __images__.'/demo/product5-thumbnail-2.png" alt=""></div>
									<div><img src="'. __images__.'/demo/product5-thumbnail-3.png" alt=""></div>
								</div>
							</div>
							<div class="medium-6 columns productDetailTrack">
								<div class="fullImage">
									<img src="'. __images__.'/demo/product5.png" alt="">
								</div>
							</div>
						</section>
					</article>';*/
				
				}
			}
			?>		
		</div><!-- row -->
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
        <script type="text/javascript" src="<?php echo __js__; ?>/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="<?php echo __js__; ?>/jquery.zoom.min.js"></script>
        <!-- javascript here -->
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
                            rel: "group1"
                        });
                    });
                    $(".fullImage").zoom();
                }
            });
        </script>
    </body>
</html>
