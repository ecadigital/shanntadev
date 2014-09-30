<?php if(empty($contents)){?>
	<div style="height:150px; text-align:center; margin-top:50px;"><?php echo lang('nodata');?></div>
<?php }else{ ?>
<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelMember = $this->load->model('member/Member_frontmodel');

$member_id = (isset($_SESSION['member_id'])) ? $_SESSION['member_id'] : '';
$member_type = '';
$member_title = '';
$member_fname = '';
$member_lname = '';

if($member_id!=''){
	$getMember = $this->modelMember->getMember($member_id);
	if(!empty($getMember)){
		$member_type = 'member';
		$member_title = $getMember['member_title'];
		$member_fname = $getMember['member_first_name'];
		$member_lname = $getMember['member_last_name'];
	}
}
$member_type = (isset($_SESSION['order']['member_type'])) ? $_SESSION['order']['member_type'] : $member_type;
$member_title = (isset($_SESSION['order']['member_title'])) ? $_SESSION['order']['member_title'] : $member_title;
$member_fname = (isset($_SESSION['order']['member_fname'])) ? $_SESSION['order']['member_fname'] : $member_fname;
$member_lname = (isset($_SESSION['order']['member_lname'])) ? $_SESSION['order']['member_lname'] : $member_lname;
$member_address = (isset($_SESSION['order']['member_address'])) ? $_SESSION['order']['member_address'] : '';
$member_city = (isset($_SESSION['order']['member_city'])) ? $_SESSION['order']['member_city'] : '';
$member_postcode = (isset($_SESSION['order']['member_postcode'])) ? $_SESSION['order']['member_postcode'] : '';
$member_prephone = (isset($_SESSION['order']['member_prephone'])) ? $_SESSION['order']['member_prephone'] : '+66';
$member_phone = (isset($_SESSION['order']['member_phone'])) ? $_SESSION['order']['member_phone'] : '';
$chk_message = (isset($_SESSION['order']['chk_message'])) ? $_SESSION['order']['chk_message'] : '';
$member_message = (isset($_SESSION['order']['member_message'])) ? $_SESSION['order']['member_message'] : '';
?>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/css/style.css">
<header>
	<div class="medium-4 columns">
		<h1>DELIVERY</h1>
	</div>
	<div class="medium-8 columns"><?php echo $this->model->nav_cart(2);?></div>
	</div>
	<div class="clearfix"></div>
</header>
<form action="#" method="post">
	<div class="row">
		<div class="large-2 columns">
			<h2><?php echo lang('yourdeliveryaddress');?></h2>
			<h3><?php echo lang('mandatoryfield');?></h3>
		</div>
		<div class="small-12 large-10 columns">
			<div class="medium-2 columns">
				<label for="member_title"><?php echo lang('title');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<select id="member_title" name="member_title">
					<option value="">- <?php echo lang('select');?> -</option>
					<option value="mr" <?php if($member_title=='mr') echo 'selected="selected"';?>><?php echo lang('mr');?></option>
					<option value="mrs" <?php if($member_title=='mrs') echo 'selected="selected"';?>><?php echo lang('mrs');?></option>
					<option value="miss" <?php if($member_title=='miss') echo 'selected="selected"';?>><?php echo lang('miss');?></option>
				</select>
				<span class="errorspan" style="top:0px;"><?php echo lang('v_title');?></span>
			</div>
			<div class="medium-2 columns">
				<label for="member_fname"><?php echo lang('firstname');?> *</label>
			</div>
			<div class="medium-4-custom columns end">
				<input type="text" id="member_fname" name="member_fname" value="<?php echo $member_fname;?>">
				<span class="errorspan"><?php echo lang('v_firstname');?></span>
			</div>
		</div>
		<div class="small-12 large-10 large-offset-2 columns">
			<div class="medium-2 columns">
				<label for="member_lname"><?php echo lang('lastname');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text" id="member_lname" name="member_lname" value="<?php echo $member_lname;?>">
				<span class="errorspan"><?php echo lang('v_lastname');?></span>
			</div>
			<div class="medium-2 columns">
				<label for="member_address"><?php echo lang('address');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text" id="member_address" name="member_address" value="<?php echo $member_address;?>">
				<span class="errorspan"><?php echo lang('v_address');?></span>
			</div>
			<div class="medium-2 columns">
				<label for="member_postcode"><?php echo lang('postcode');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text" id="member_postcode" name="member_postcode" value="<?php echo $member_postcode;?>">
				<span class="errorspan"><?php echo lang('v_postcode');?></span>
			</div>
			<div class="medium-2 columns">
				<label for="member_city"><?php echo lang('city');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text" id="member_city" name="member_city" value="<?php echo $member_city;?>">
			</div>
			<div class="medium-2 columns">
				<label for="member_phone"><?php echo lang('phone');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<div class="small-3 columns">
					<input type="text" id="member_prephone" name="member_prephone" placeholder="+66" value="<?php echo $member_prephone;?>">
					<!--<select id="member_phone" name="member_phone">
						<option value="1">+1</option>
						<option value="66">+66</option>
						<option value="291">+291</option>
					</select>-->
				</div>
				<div class="small-9 columns">
					<input type="text" id="member_phone" name="member_phone" value="<?php echo $member_phone;?>">
				</div>
				<span class="errorspan"><?php echo lang('v_phone');?></span>
			</div>
			<div class="medium-2 columns">
				<label for="#"><?php echo lang('shippingmethod');?></label>
			</div>
			<div class="medium-4-custom columns">
				<select>
					<option value="0">Complimenttary Standart</option>
				</select>
			</div>
			<div class="medium-6 medium-offset-3-custom columns end">
				<input type="checkbox" id="chk_message" name="chk_message" value="1" <?php if($chk_message==1) echo 'checked="checked"';?>> <label for="chk_message"><?php echo lang('personalmessage');?></label>
				<div class="small-12" id="boxMessage" style="<?php if($chk_message!=1) echo 'display:none;';?>">
					<textarea name="member_message" id="member_message" style="height:70px;"><?php echo $member_message;?></textarea>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="navigator">
		<div>
			<?php if($member_type!='guest'){?>
				<a href="cart1.php" class="arrow_box left prev"><?php echo lang('previous');?></a>
			<?php }?>
			<a href="javascript:void(0)" onclick="chkCart2()" class="arrow_box right next"><?php echo lang('continue');?></a>
		</div>
	</div> <!-- .navigator -->
</form>


<script>
	//loadNavCart('<?php echo $lang;?>',1);
	function chkCart2(){
		chk=1;
		if($('#member_title').val()==''){
			$('#member_title').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_title').removeClass('validate').next().hide();
		}
		if($('#member_fname').val()==''){
			$('#member_fname').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_fname').removeClass('validate').next().hide();
		}
		if($('#member_lname').val()==''){
			$('#member_lname').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_lname').removeClass('validate').next().hide();
		}
		if($('#member_address').val()==''){
			$('#member_address').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_address').removeClass('validate').next().hide();
		}
		if($('#member_city').val()==''){
			$('#member_city').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_city').removeClass('validate').next().hide();
		}
		if($('#member_postcode').val()==''){// || isNaN($('#member_postcode').val())==true){
			$('#member_postcode').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_postcode').removeClass('validate').next().hide();
		}
		if($('#member_prephone').val()==''){
			$('#member_prephone').focus().addClass('validate').parent().next().next().show();
			chk=0;
		}else{
			$('#member_prephone').removeClass('validate').parent().next().next().hide();
		}
		if($('#member_phone').val()==''){
			$('#member_phone').focus().addClass('validate').parent().next().show();
			chk=0;
		}else{
			$('#member_phone').removeClass('validate').parent().next().hide();
		}
		if(chk==1){
			$.post( DIR_ROOT+'shoppingcart/frontend/set_sesmember', { 
				member_title: $('#member_title').val(),
				member_fname: $('#member_fname').val(),
				member_lname: $('#member_lname').val(),
				member_address: $('#member_address').val(),
				member_postcode: $('#member_postcode').val(),
				member_city: $('#member_city').val(),
				member_prephone: $('#member_prephone').val(),
				member_phone: $('#member_phone').val(),
				chk_message: $('#chk_message:checked').length,
				member_message: $('#member_message').val(),
			}).done(function( data ) {
				window.location='cart3.php';
			});
		}
	}
	$('#chk_message').click(function(){
		if($('#chk_message:checked').length==1) $('#boxMessage').slideDown();
		else{ $('#boxMessage').slideUp(); $('#member_message').val(''); }
	});
</script>
<?php }?>