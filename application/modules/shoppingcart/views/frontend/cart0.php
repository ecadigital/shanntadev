<?php if(empty($contents)){?>
	<div style="height:150px; text-align:center; margin-top:50px;"><?php echo lang('nodata');?></div>
<?php }else{ ?>
<?php 
$this->modelMember = $this->load->model('member/Member_frontmodel');
?>
<header class="ta-center">
	<?php echo lang('securezone');?>
</header>
<article class="boxDotted">
	<section class="large-6 columns">
		<a href="javascript:void(0)" onclick="chkGuest()" class="guest">
			<h1><?php echo lang('continueguest');?></h1>
		</a>
	</section>
	<section class="large-6 columns ta-center">
		<h1 class="cart0head"><?php echo lang('existingmember');?></h1>
		<div>
			<?php echo lang('alreadysign');?>
			<br>
			<br>
		</div>
		<div class="large-3 columns">
			<label for="member_username"><?php echo lang('username');?></label>
		</div>
		<div class="large-9 columns">
			<input type="text" id="member_username" name="member_username">
		</div>
		<div class="large-3 columns">
			<label for="member_password"><?php echo lang('password');?></label>
		</div>
		<div class="large-9 columns">
			<input type="text" id="member_password" name="member_password">
			<a class="forgot" href="#"><?php echo lang('forgotpassword');?></a>
		</div>
		<div class="large-12 columns ta-center">
			<button><b><?php echo lang('signin');?></b></button>
		</div>
		<div class="large-12 columns noMember">
			<?php echo lang('notmember');?> <a href="cart1.php"><?php echo lang('registerhere');?></a>
		</div>
	</section>
	<div class="clearfix"></div>
</article>
<script>
	function chkGuest(){
		chk=1;
		if(chk==1){
			$.post( DIR_ROOT+'shoppingcart/frontend/set_sesmember', { 
				member_type: 'guest'
			}).done(function( data ) {
				window.location='cart2.php';
			});
		}
	}
</script>
<?php }?>