<header id="topmenu">
	<nav id="large-topmenu" class="row show-for-large-up">
		<ul class="inline-list">
			<li><a href="home.php"><?php echo $Array_lang['home'];?></a></li>
			<li><a href="lookbook.php"><?php echo $Array_lang['lookbook'];?></a></li>
			<li><a href="diy.php"><?php echo $Array_lang['jewelry'];?></a></li>
			<li class="productSelection"><a href="products.php"><?php echo $Array_lang['products'];?></a></li>
			<li class="logo"><a href="home.php"><img src="img/logo.png" alt=""></a></li>
			<li><a href="collection.php"><?php echo $Array_lang['collection'];?></a></li>
			<li><a href="news.php"><?php echo $Array_lang['newsandevent'];?></a></li>
			<li><a href="aboutus.php"><?php echo $Array_lang['aboutus'];?></a></li>
			<li><a href="contactus.php"><?php echo $Array_lang['contactus'];?></a></li>
		</ul>
	</nav>
	<nav id="medium-topmenu" class="show-for-medium-only">
		<div class="logo"><a href="#"><img src="img/logo.png" alt=""></a></div>
		<div class="row">
			<ul class="inline-list">
				<li><a href="home.php"><?php echo $Array_lang['home'];?></a></li>
				<li><a href="lookbook.php"><?php echo $Array_lang['lookbook'];?></a></li>
				<li><a href="diy.php"><?php echo $Array_lang['jewelry'];?></a></li>
				<li class="afterLarge productSelection"><a href="products.php"><?php echo $Array_lang['products'];?></a></li>
				<li><a href="collection.php"><?php echo $Array_lang['collection'];?></a></li>
				<li class="large"><a href="news.php"><?php echo $Array_lang['newsandevent'];?></a></li>
				<li class="afterLargeTwo"><a href="aboutus.php"><?php echo $Array_lang['aboutus'];?></a></li>
				<li class="last ta-right"><a href="contactus.php"><?php echo $Array_lang['contactus'];?></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</nav>
	<nav id="small-topmenu" class="show-for-small-only sticky">
		<div class="row" data-topbar data-options="sticky_on: small">
			<div class="small-2 columns ta-left">
				<a id="userInterface" href="#userInterfaceDetail"><i class="fa fa-user icons"></i></a>
			</div>
			<div class="small-8 columns ta-center">
				<a href="home.php"><img src="<?php echo __images__; ?>/logo.png" alt=""></a>
			</div>
			<div class="small-2 columns ta-right">
				<a id="navigator" href="#navigatorDetail"><i class="fa fa-navicon icons"></i></a>
			</div>
		</div> <!-- row -->
		<nav class="menus">
			<ul id="navigatorDetail">
				<li><a href="lookbook.php"><?php echo $Array_lang['lookbook'];?></a></li>
				<li><a href="diy.php"><?php echo $Array_lang['jewelry'];?></a></li>
				<li><a href="products.php"><?php echo $Array_lang['products'];?></a></li>
				<li><a href="collection.php"><?php echo $Array_lang['collection'];?></a></li>
				<li><a href="news.php"><?php echo $Array_lang['newsandevent'];?></a></li>
				<li><a href="aboutus.php"><?php echo $Array_lang['aboutus'];?></a></li>
				<li><a href="contactus.php"><?php echo $Array_lang['contactus'];?></a></li>
				<li class="row noBorder">
					<div class="small-5 columns ta-right"> Member Register </div>
					<div class="small-2 columns"> : </div>
					<div class="small-5 columns ta-left">
						<a href="#">FAQs</a> : <a href="#">Help</a>
					</div>
				</li>
				<li class="row noBorder">
					<!-- Order and Payment : <a href="#">Shipping Infomation</a> -->
					<div class="small-5 columns ta-right"> Order and Payment </div>
					<div class="small-2 columns"> : </div>
					<div class="small-5 columns ta-left">
						<a href="#">Shipping Infomation</a>
					</div>
				</li>
				<li class="row noBorder">
					<!-- Refunnd Policy : <a href="#">Terms of Sevice</a></li> -->
					<div class="small-5 columns ta-right"> Refunnd Policy </div>
					<div class="small-2 columns"> : </div>
					<div class="small-5 columns ta-left">
						<a href="#">Terms of Sevice</a>
					</div>
				</li>
				<li class="noBorder">
					<div class="row">
						<div class="small-2 columns">
							EN</div> 
						<div class="small-10 columns">
							<input type="text" placeholder="Search...">
						</div>
					</div>
				</li>
			</ul><!-- navigatorDetail -->
			<ul id="userInterfaceDetail">
				<li><a href="#"><i class="fa fa-user"></i> CHARINTIP</a></li>
				<li><a href="#"><i class="fa fa-shopping-cart"></i> MY Cart [<span class="widget_items">0</span>]</a></li>
				<li><a href="#"><i class="fa fa-ban"></i> CHECKOUT</a></li>
			</ul><!-- userInterfaceDetail -->
		</nav><!-- menus -->
	</nav> <!-- small-topmenu -->
	<div class="clearfix"></div>
	<div id="productPopup">
		<!--<div class="large-items-2 columns">
			<a href="#" data-self="<?php echo __images__;?>/assets/collection-product-1-hover.png" data-preview="<?php echo __images__;?>/demo/product3.png">
				<img src="<?php echo __images__;?>/assets/collection-product-1.png" alt="">
				<span>CHARM</span>
			</a>
		</div>
		<div class="large-items-2 columns">
			<a href="#" data-self="<?php echo __images__;?>/assets/collection-product-2-hover.png" data-preview="<?php echo __images__;?>/demo/product3.png">
				<img src="<?php echo __images__;?>/assets/collection-product-2.png" alt="">
				<span>BRACELETS</span>
			</a>
		</div>
		<div class="large-items-2 columns">
			<a href="#" data-self="<?php echo __images__;?>/assets/collection-product-3-hover.png" data-preview="<?php echo __images__;?>/demo/product3.png">
				<img src="<?php echo __images__;?>/assets/collection-product-3.png" alt="">
				<span>RINGS</span>
			</a>
		</div>    
		<div class="large-items-2 columns">
			<a href="#" data-self="<?php echo __images__;?>/assets/collection-product-4-hover.png" data-preview="<?php echo __images__;?>/demo/product3.png">
				<img src="<?php echo __images__;?>/assets/collection-product-4.png" alt="">
				<span>ERRINGS</span>
			</a>
		</div>
		<div class="large-items-2 columns">
			<a href="#" data-self="<?php echo __images__;?>/assets/collection-product-5-hover.png" data-preview="<?php echo __images__;?>/demo/product3.png">
				<img src="<?php echo __images__;?>/assets/collection-product-5.png" alt="">
				<span>NECKLACES AND PENDANTS</span>
			</a>
		</div>
		<div class="large-items-3 columns preview">
			<img src="<?php echo __images__;?>/demo/product3.png" alt="">
		</div>-->
	</div>
</header><!-- #topmenu -->