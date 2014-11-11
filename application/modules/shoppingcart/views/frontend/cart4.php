<?php if(empty($contents)){?>
	<div style="height:200px; text-align:center; margin-top:100px;"><?php echo lang('nodata');?></div>		
<?php }else{ ?>
<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelMember = $this->load->model('member/Member_frontmodel');

$member_type = (isset($_SESSION['order']['member_type'])) ? $_SESSION['order']['member_type'] : '';
$member_payment = (isset($_SESSION['order']['member_payment'])) ? $_SESSION['order']['member_payment'] : '';
$transfer_bank = (isset($_SESSION['order']['transfer_bank'])) ? $_SESSION['order']['transfer_bank'] : '';
?>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/css/style.css">
<header>
	<div class="medium-4 columns">
		<h1>PAYMENT</h1>
	</div>
	<div class="medium-8 columns"><?php echo $this->model->nav_cart(4);?></div>
	<div class="clearfix"></div>
</header>
<form action="#" method="post">
	<div class="row">
		<div class="large-2 columns">
			<h2><?php echo strtoupper(lang('payment'));?></h2>
		</div>
		<div class="small-12 large-10 columns">
			<div class="medium-2 columns">
				<label for="member_payment"><?php echo lang('paymentmethod');?></label>
			</div>
			<div class="medium-4-custom columns end">
				<select name="member_payment" id="member_payment">
					<option value="transfer" <?php if($member_payment=='transfer') echo 'selected="selected"';?>><?php echo lang('transfer');?></option>
					<option value="credit"	<?php if($member_payment=='credit') echo 'selected="selected"';?>><?php echo lang('creditcard');?></option>
					<option value="paypal"	<?php if($member_payment=='paypal') echo 'selected="selected"';?>><?php echo lang('paypal');?></option>
				</select>
				<span class="errorspan"><?php echo lang('v_paymentmethod');?></span>
			</div>
		</div>
	</div>

	<div class="row" id="boxCreditCard" style="display:none;">
		<div class="large-2 columns">
			<h2><?php echo lang('detailcard');?></h2>
		</div>
		<div class="small-12 large-10 columns">
			<div class="medium-2 columns">
				<label for="#"><?php echo lang('card');?></label>
			</div>
			<div class="medium-10 columns end">
				<label><input type="radio" name="card" value="visa">&nbsp;&nbsp;<img src="<?php echo DIR_ROOT;?>img/assets/bank-1.png"></label>
				<label><input type="radio" name="card" value="master">&nbsp;&nbsp;<img src="<?php echo DIR_ROOT;?>img/assets/bank-2.png"></label>
			</div>
		</div>
		<div class="small-12 large-10 large-offset-2 columns">
			<div class="medium-2 columns">
				<label for="creditcard_number"><?php echo lang('cardnumber');?></label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text" id="creditcard_number" name="creditcard_number">
			</div>
			<div class="medium-2 columns">
				<label for="creditcard_name"><?php echo lang('namecardholder');?></label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text" id="creditcard_name" name="creditcard_name">
			</div>
		</div>
		<div class="small-12 large-10 large-offset-2 columns">
			<div class="medium-2 columns">
				<label for="creditcard_year"><?php echo lang('expiredate');?></label>
			</div>
			<div class="medium-4-custom columns">
				<div class="medium-6 columns">
					<select id="creditcard_year" name="creditcard_year">
						<?php for($y=date("Y");$y<=date("Y")+10;$y++){
							echo '<option value="'.$y.'">'.$y.'</option>';
						}?>
					</select>
				</div>
				<div class="medium-5 columns">
					<select id="creditcard_month" name="creditcard_month">
						<?php for($m=1;$m<=12;$m++){
							echo '<option value="'.$m.'">'.$m.'</option>';
						}?>
					</select>
				</div>
			</div>
			<div class="medium-2 columns">
				<label for="#"><?php echo lang('securitycord');?></label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text">
			</div>
		</div>
	</div> <!-- .row -->
	<div class="notice ta-center" id="boxVCreditCard" style="display:none;">
		<?php echo lang('v_creditcard');?>
	</div>
	
	<div class="row" id="boxTransfer">
		<div class="large-2 columns">
			<h2><?php echo strtoupper(lang('transfer'));?></h2>
		</div>
		<div class="small-12 large-10 columns">
			<div class="medium-2 columns">
				<label for="#"><?php echo lang('selectbank');?></label>
				<span id="v_bank" class="errorspan" style="top:-5px;"><?php echo lang('v_bank');?></span>
			</div>
			<div class="medium-10 columns end">
				<?php foreach($listAllBank as $listBank){
					$img_db = $listBank['bank_image'];
					$img_path = DIR_PUBLIC."images/noimage.png";
					if($img_db!=''){
						$path = "public/upload/bank/thumbnails/".basename($img_db);
						$dir_file = DIR_FILE.$path;
						if(file_exists($dir_file)){
							$img_path = DIR_ROOT.$path;
						}
					}
					echo '
					<div class="small-12 large-10 columns" style="padding-left:0px !important; margin-top:10px;">
						<div class="small-2 columns">
							<label for="transfer_bank_'.$listBank['bank_id'].'">
								<input type="radio" id="transfer_bank_'.$listBank['bank_id'].'" name="transfer_bank" class="transfer_bank" value="'.$listBank['bank_id'].'" '; if($transfer_bank==$listBank['bank_id']) echo 'checked="checked"'; echo '>&nbsp;&nbsp;<img src="'.$img_path.'" style="height:30px;">
							</label>
						</div>
						<div class="small-10 columns">
							<label for="transfer_bank_'.$listBank['bank_id'].'">
								<div class="small-3 columns">'.lang('bank_name').'</div>
								<div class="small-9 columns"><span style="font-weight:normal;">'.$listBank['bank_name'].'</span></div><br/>
								<div class="small-3 columns">'.lang('bank_branch').'</div>
								<div class="small-9 columns"><span style="font-weight:normal;">'.$listBank['bank_branch'].'</span></div><br/>
								<div class="small-3 columns">'.lang('bank_account').'</div>
								<div class="small-9 columns"><span style="font-weight:normal;">'.$listBank['bank_account'].'</span></div><br/>
								<div class="small-3 columns">'.lang('bank_no').'</div>
								<div class="small-9 columns"><span style="font-weight:normal;">'.$listBank['bank_no'].'</span></div><br/>
							</label>
						</div>
					</div><br/>';
				}?>
			</div>
		</div>
	</div> <!-- .row -->
	
	<div class="row" id="boxPaypal" style="display:none;">
		<div class="large-2 columns">
			<h2><?php echo strtoupper(lang('paypal'));?></h2>
		</div>
		<div class="small-12 large-10 columns">
			<div class="medium-2 columns">
				<label for="#"><?php echo lang('paypal');?></label>
			</div>
			<div class="medium-10 columns end">Coming Soon</div>
		</div>
	</div> <!-- .row -->
	
	
	<br>
	<div class="navigator">
		<div>
			<a href="cart3.php" class="arrow_box left prev"><?php echo lang('previous');?></a>
			<a href="javascript:void(0)" onclick="chkCart4()" class="arrow_box right next"><?php echo lang('continue');?></a>
		</div>
	</div> <!-- .navigator -->
</form>

<script>
	function chkCart4(){
		chk=1;
		if($('#member_payment').val()==''){
			$('#member_payment').addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_payment').removeClass('validate').next().hide();
		}
		if($('#member_payment').val()=='transfer' && isNaN($('.transfer_bank:checked').val())==true){
			$('#v_bank').show();
			chk=0;
		}else{
			$('#v_bank').hide();
		}
		if(chk==1){
			$.post( DIR_ROOT+'shoppingcart/frontend/checkout/lang/<?php echo $lang;?>', { 
				member_payment: $('#member_payment').val(),
				transfer_bank: $('.transfer_bank:checked').val(),
			}).done(function( data ) {
				window.location='cart5.php?id='+data;
			});
		}
	}
	
	$('#member_payment').change(function(){
		if($(this).val()=='credit'){
			$('#boxCreditCard').show();
			$('#boxVCreditCard').show();
			$('#boxTransfer').hide();
			$('#boxPaypal').hide();
		}
		else if($(this).val()=='transfer'){
			$('#boxCreditCard').hide();
			$('#boxVCreditCard').hide();
			$('#boxTransfer').show();
			$('#boxPaypal').hide();
		}
		else if($(this).val()=='paypal'){
			$('#boxCreditCard').hide();
			$('#boxVCreditCard').hide();
			$('#boxTransfer').hide();
			$('#boxPaypal').show();
		}
	})
	boxCreditCard
</script>
<?php }?>
