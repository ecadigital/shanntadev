<?php 
$member_id = (isset($_SESSION['member_id'])) ? $_SESSION['member_id'] : '';
$member_name = (isset($_SESSION['member_name'])) ? $_SESSION['member_name'] : '';
$member_fname = (isset($_SESSION['member_fname'])) ? $_SESSION['member_fname'] : '';
$member_lname = (isset($_SESSION['member_lname'])) ? $_SESSION['member_lname'] : '';
?>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/css/style.css">

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
				<li class="medium-4 large-3 columns right"><a href="<?php echo ($member_id=='') ? 'cart0.php' : 'cart1.php';?>"><i class="fa fa-ban icon"></i> CHECKOUT</a></li>
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
					<a href="#"><i class="fa fa-user icon"></i> <?php echo ($member_id=='') ? 'LOGIN' : $member_name;?></a>
					<div class="sub profile">
						<?php if($member_id==''){?>
							<div class="medium-4 large-offset-1 columns">
								<label for="widget_username"><strong><?php echo $Array_lang['username'];?> *</strong></label>
							</div>
							<div class="medium-6 columns" style="max-height:50px;" >
								<input type="text" id="widget_username" name="widget_username" style="height:1.8125rem;margin-bottom:8px;">
								<span class="errorspan"><?php echo $Array_lang['v_username'];?></span>
							</div>
							
							<div class="medium-4 large-offset-1 columns">
								<label for="widget_password"><strong><?php echo $Array_lang['password'];?> *</strong></label>
							</div>
							<div class="medium-6 columns" style="max-height:50px;" >
								<input type="password" id="widget_password" name="widget_password" style="height:1.8125rem;margin-bottom:8px;">
								<span class="errorspan"><?php echo $Array_lang['v_password'];?></span>
							</div>
							
							<div class="medium-12 columns ta-center" style="margin-top:10px !important;">
								<span class="errorspan" id="widget_incorrectlogin"><?php echo $Array_lang['v_incorrectlogin'];?></span>
							</div>
							<div class="medium-4 large-offset-1 columns">
								<a href="forgotpassword.php" class="forgot">Forgot</a>
							</div>
							<div class="medium-6 columns ta-right">
								<a href="javascript:void(0)" onclick="widgetLogin()" class="button"><?php echo $Array_lang['login'];?></a>
							</div>
						<?php }else{
							echo '
							<div class="medium-4 columns">
								<img src="img/profile.png" alt="none profile picture">
							</div>
							<div class="medium-8 columns">
								<h5>'.$member_name.'</h5>
								<span>Bangkok, Thailand</span>
								<a href="#" class="button">'.$Array_lang['viewprofile'].'</a>
								<a href="javascript:void(0)" onclick="logout()" class="button">'.$Array_lang['logout'].'</a>
							</div>';
						}?> 
					</div><!-- sub profile -->
				</li>
			</ul>
	    </div>
    </div>
</div>


<script src="<?php echo DIR_PUBLIC;?>js/jquery-1.7.min.js"></script>
<script src="<?php echo DIR_PUBLIC;?>js/script.js"></script>
<script src="<?php echo DIR_PUBLIC;?>module/main/frontend/js/script.js"></script>
<script src="<?php echo DIR_PUBLIC;?>module/product/frontend/js/script.js"></script>
<script src="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/js/function.js"></script>
<script>
	loadWidgetCart('<?php echo $defaultLang;?>');
	
	function widgetLogin(){
		chk=1;
		if($('#widget_password').val()==''){
			$('#widget_password').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#widget_password').removeClass('validate').next().hide();
		}
		if($('#widget_username').val()==''){
			$('#widget_username').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#widget_username').removeClass('validate').next().hide();
		}
		if(chk==1){
			$.post( DIR_ROOT+'member/frontend/login', { 
				widget_username: $('#widget_username').val(),
				widget_password: $('#widget_password').val()
			}).done(function( data ) {
				if(data=='0'){
					$('#widget_incorrectlogin').show();
				}else{
					window.location.reload();
				}
			});
		}
	}
	function logout(){
		$.post( DIR_ROOT+'member/frontend/logout', { 
		}).done(function( data ) {
			window.location.reload();
		});
	}
</script>