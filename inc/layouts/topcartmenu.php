
<div id="topcartmenu" class="show-for-medium-up sticky">
	<div class="row" data-topbar data-options="sticky_on: ['medium','large']">
		<div class="medium-3 large-2 columns">
			<?php echo strtoupper($Array_lang['language']);?> : 
			<a href="<?php echo (isset($_GET['id'])) ? $_SERVER['PHP_SELF'].'?id='.$_GET['id'].'&lang=1' : $_SERVER['PHP_SELF'].'?lang=1';?>">TH</a> | 
			<a href="<?php echo (isset($_GET['id'])) ? $_SERVER['PHP_SELF'].'?id='.$_GET['id'].'&lang=2' : $_SERVER['PHP_SELF'].'?lang=2';?>">EN</a> | 
			<a href="<?php echo (isset($_GET['id'])) ? $_SERVER['PHP_SELF'].'?id='.$_GET['id'].'&lang=3' : $_SERVER['PHP_SELF'].'?lang=3';?>">CN</a> 
		</div>
		<div class="medium-3 columns ta-center">
			<div class="medium-10 searchBox">
				<a href="#"><i class="fa fa-search"></i></a><input type="text" placeholder="Search..">
			</div>
		</div>
		<div class="medium-6 columns ta-right">
			<ul>
				<li class="medium-4 large-3 columns right"><a href="#"><i class="fa fa-ban icon"></i> CHECKOUT</a></li>
				<li class="medium-4 large-3 columns right">
					<a href="#" class=""><i class="fa fa-shopping-cart icon"></i> MY CART [<span class="widget_items">0</span>]</a>
					<div class="sub selection" id="boxWidgetCart">
					<?php /*?>
						<div class="medium-7 columns head">Item</div>
						<div class="medium-2 columns head">Unit Price</div>
						<div class="medium-1 columns head">Qty.</div>
						<div class="medium-2 columns head">Cost</div>
						<div class="clearfix"></div>
						<div class="row first">
							<div class="medium-2 columns">
								<img src="<?php echo __images__;?>/demo/product5.png" alt="">
							</div>
							<div class="medium-5 columns">
								JAZZ GLITZ STUD EARRINGS HEMATITE GREEN
								<a href="#">[Remove]</a>
							</div>
							<div class="medium-2 columns">
								1,680 THB
							</div>
							<div class="medium-1 columns">
								<input type="text">
							</div>
							<div class="medium-2 columns ta-right">
								3,360 THB
							</div>
						</div><!-- row -->
						<div class="row">
							<div class="medium-2 columns">
								<img src="<?php echo __images__;?>/demo/product5.png" alt="">
							</div>
							<div class="medium-5 columns">
								JAZZ GLITZ STUD EARRINGS HEMATITE GREEN
								<a href="#">[Remove]</a>
							</div>
							<div class="medium-2 columns">
								1,680 THB
							</div>
							<div class="medium-1 columns">
								<input type="text">
							</div>
							<div class="medium-2 columns ta-right">
								3,360 THB
							</div>
						</div><!-- row -->
						<div class="row">
							<div class="medium-3 medium-offset-6 columns"><b>Subtotal:</b></div> 
							<div class="medium-3 columns ta-right"><b>12,264 THB</b></div>
						</div>
						<div class="row">
							<div class="medium-3 medium-offset-6 columns"><b>Shipping:</b></div>
							<div class="medium-3 columns ta-right"><b>250 THB</b></div>
						</div>
						<div class="row">
							<div class="medium-3 medium-offset-6 columns"><b>Total:</b></div>
							<div class="medium-3 columns ta-right"><b>12,289 THB</b></div>
						</div>
						<div class="row">
							<div class="medium-4 medium-offset-8 columns ta-right">
								<a href="shipping.php" class="button">My Selection</a>
							</div>
						</div>
					<?php */?>
					</div><!-- sub selection -->
				</li>
				<li class="medium-4 large-3 columns right">
					<a href="#"><i class="fa fa-user icon"></i> CHARINTIP</a>
					<div class="sub profile">
						<div class="medium-4 columns">
							<img src="img/profile.png" alt="none profile picture">
						</div>
						<div class="medium-8 columns">
							<h5>Charintip Bumrungsak</h5>
							<span>Bangkok, Thailand</span>
							<a href="#" class="button">View Profile</a>
						</div>
					</div><!-- sub profile -->
				</li>
				
				
			</ul>
	    </div>
    </div>
</div>


<script src="<?php echo DIR_PUBLIC;?>js/jquery-1.7.min.js"></script>
<script src="<?php echo DIR_PUBLIC;?>js/script.js"></script>
<script src="<?php echo DIR_PUBLIC;?>module/product/frontend/js/script.js"></script>
<script src="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/js/function.js"></script>
<script>
	loadWidgetCart('<?php echo $defaultLang;?>');
</script>