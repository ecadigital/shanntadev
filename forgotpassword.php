<?php require "inc/init.php";
$redirect = "forgot.php";?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <?php require 'inc/layouts/head-tag.php';?>
        <title>Shannta</title>
    </head>
    <body>
        <?php require "inc/layouts/browserhappy.php"; ?>
        <?php require "inc/layouts/topcartmenu.php"; ?>
        <?php require "inc/layouts/topmenu.php"; ?>
		
        <div id="content" class="row cart">
			<header>
				<div class="medium-4 columns">
					<h1><?php echo strtoupper($Array_lang['forgotpassword']);?></h1>
				</div>
				<div class="medium-8 columns">
				</div>
				<div class="clearfix"></div>
			</header>
			<form action="#" method="post" style="height:200px;">
				<div class="large-12 columns">&nbsp;</div>
				<div class="large-4 columns">&nbsp;</div>
				<div class="large-1 columns">
					<label for="forgot_username"><?php echo $Array_lang['username'];?></label>
				</div>
				<div class="large-3 columns ta-left" style="max-height:60px;">
					<input type="text" id="forgot_username" name="forgot_username">
					<span class="errorspan" style="top:-15px;"><?php echo $Array_lang['v_username'];?></span>
					<span class="errorspan" style="top:-15px;"><?php echo $Array_lang['v_incorrectemail'];?></span>
				</div>
				<div class="large-4 columns">&nbsp;</div>
				
				<div class="large-12 columns ta-center">
					<a class="button" href="javascript:void(0)" onclick="forgot()"><?php echo $Array_lang['submit'];?></a>
					<!--<a href="javascript:void(0)" onclick="forgot()"><button><b><?php echo $Array_lang['submit'];?></b></button></a>-->
				</div>
				<div class="clearfix"></div>
			</form>
		</div><!-- #content .row.cart -->
		
        <?php require "inc/layouts/footer-tag.php"; ?>
        <?php require "inc/layouts/javascript.php"; ?>
		
        <!-- javascript here -->
        <script type="text/javascript">
			function forgot(){
				chk=1;
				if($('#forgot_username').val()==''){
					$('#forgot_username').focus().addClass('validate').next().show();
					chk=0;
				}else{
					$('#forgot_username').removeClass('validate').next().hide();
				}
				if(chk==1){
					$.post( DIR_ROOT+'member/frontend/forgot_password', { 
						member_email: $('#forgot_username').val()
					}).done(function( data ) {
						if(data=='0'){
							$('#forgot_username').focus().addClass('validate').next().next().show();
						}else{
							$('#forgot_username').removeClass('validate').next().next().hide();
							alert('<?php echo $Array_lang['v_sendpass'];?>');
						}
					});
				}
			}
        </script>
    </body>
</html>
