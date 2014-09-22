<?php require "inc/init.php";
$redirect = "product.php";
if(!isset($_GET['id'])) echo '<script>window.location="home.php";</script>';
else{
$product_categories_id = $_GET['id'];
?>
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
		
		<div id="boxBannerCategories">
			<!--<article class="row show-for-medium-up catagorieBanner">
				<section class="medium-6 large-7 medium-push-6 large-push-5 columns">
					<img src="<?php echo __images__;?>/demo/product3.png" alt="">
				</section>
				<section class="medium-6 large-5 medium-pull-6 large-pull-7 columns details">
					<h1>EARRINGS</h1>
					<article>
						<p><strong>Sterling silver, 14k gold. two-tone and an abundance of beautiful gemstones make up the PANDORA</strong></p>
					</article>
				</section>
			</article> catagorieBanner -->
		</div>
        <div id="content" class="row">
			<?php 
				/*echo '
				<article class="small-6 large-4 columns end products">
					<h1>test
						testddddddddddddd
					</h1>
					<section class="small-10 columns small-centered" style="height:248px">
						<img src="<?php echo  __images__;?>/demo/product5-thumbnail-1.png" alt="" style="max-width:190px; max-height:248px;">
					</section>
					<section class="small-12 columns priceTag">
						<div class="small-6 columns price">4,000 <b>THB</b></div>
						<div class="small-6 columns"><a class="addToCart medium-8 large-7" href="javascript:alert(1);"><i class="fa fa-shopping-cart"></i> <b>ADD TO CART</b></a></div>
					</section>
					<section class="details" style="width:900px;">
						<div class="medium-6 columns productDetailTrack">
							<h1>test</h1>
							<div class="inner">testddddddddddddd</div>
							<hr class="dotted">
							<div class="medium-6 large-8 columns price">
								4,000 <b>THB</b>
							</div>
							<div class="medium-6 large-4 columns">
								<a class="addToCart" href="#"><i class="fa fa-shopping-cart"></i> <b>ADD TO CART</b></a>
							</div>
							<div class="clearfix"></div>
							<hr class="dotted">
							<span>More Photo</span><br>
							<div class="thumbnails clearfix">
								<div><img src="<?php echo  __images__;?>/demo/product5-thumbnail-1.png" alt=""></div>
								<div><img src="<?php echo  __images__;?>/demo/product5-thumbnail-2.png" alt=""></div>
								<div><img src="<?php echo  __images__;?>/demo/product5-thumbnail-3.png" alt=""></div>
							</div>
						</div>
						<div class="medium-6 columns productDetailTrack">
							<div class="fullImage">
								<img src="<?php echo __images__;?>/demo/product5.png" alt="">
							</div>
						</div>
					</section>
				</article>
				
			
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
					</article>';
				
				}
			}*/
			?>		
		</div><!-- row -->
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
		
		<script>
			loadBannerCategories('<?php echo $defaultLang;?>','<?php echo $product_categories_id;?>');
			loadListProduct('<?php echo $defaultLang;?>','<?php echo $product_categories_id;?>');
		</script>
			
        <script type="text/javascript" src="<?php echo __js__; ?>/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="<?php echo __js__; ?>/jquery.zoom.min.js"></script>
        <!-- javascript here 
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
        </script>-->
    </body>
</html>
<?php }?>