<?php //if(empty($contents)){?>
	<!--<div style="height:150px; text-align:center; margin-top:50px;"><?php echo lang('nodata');?></div>-->
<?php //}else{ ?>
<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelMember = $this->load->model('member/Member_frontmodel');

$member_id = (isset($_SESSION['member_id'])) ? $_SESSION['member_id'] : '';
if($member_id!='') echo '<script>window.location="cart2.php";</script>';

$member_type = (isset($_SESSION['order']['member_type'])) ? $_SESSION['order']['member_type'] : '';
$member_title = (isset($_SESSION['order']['member_title'])) ? $_SESSION['order']['member_title'] : '';
$member_fname = (isset($_SESSION['order']['member_fname'])) ? $_SESSION['order']['member_fname'] : '';
$member_lname = (isset($_SESSION['order']['member_lname'])) ? $_SESSION['order']['member_lname'] : '';
$member_bday = (isset($_SESSION['order']['member_bday'])) ? $_SESSION['order']['member_bday'] : '';
$member_bmonth = (isset($_SESSION['order']['member_bmonth'])) ? $_SESSION['order']['member_bmonth'] : '';
$member_byear = (isset($_SESSION['order']['member_byear'])) ? $_SESSION['order']['member_byear'] : '';
?>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/css/style.css">
<header>
	<div class="medium-4 columns">
		<h1>Register</h1>
	</div>
	<div class="medium-8 columns">
		<?php if(!empty($contents)){ echo $this->model->nav_cart(1); }?>
	</div>
	<div class="clearfix"></div>
</header>
<form action="#" method="post">
	<div class="row">
		<div class="large-2 columns">
			<h2><?php echo lang('yourprofile');?></h2>
			<h3><?php echo lang('mandatoryfield');?></h3>
		</div>
		<div class="small-12 large-10 columns">
			<div class="medium-2 columns">
				<label for="member_title"><?php echo lang('title');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<select id="member_title" name="member_title">
					<option value=""><?php echo lang('select');?></option>
					<option value="mr" <?php if($member_title=='mr') echo 'selected="selected"';?>><?php echo lang('mr');?></option>
					<option value="mrs" <?php if($member_title=='mrs') echo 'selected="selected"';?>><?php echo lang('mrs');?></option>
					<option value="miss" <?php if($member_title=='miss') echo 'selected="selected"';?>><?php echo lang('miss');?></option>
				</select>
				<span class="errorspan" style="top:0px;"><?php echo lang('v_title');?></span>
			</div>
			<div class="medium-2 columns">
				<label for="member_fname"><?php echo lang('firstname');?> *</label>
			</div>
			<div class="medium-4-custom columns">
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
			</div>
			<div class="medium-2 columns">
				<label for="member_bday"><?php echo lang('dateofbirth');?></label>
			</div>
			<div class="medium-4-custom columns">
				<div class="medium-3 columns">
					<select id="member_bday" name="member_bday">
						<option value=""><?php echo lang('day');?></option>
						<?php for($d=1;$d<=31;$d++){
							echo '<option value="'.$d.'" '; if($member_bday==$d) echo 'selected="selected"'; echo '>'.$d.'</option>';
						}?>
					</select>
				</div>
				<div class="medium-5 columns">
					<select id="member_bmonth" name="member_bmonth">
						<option value=""><?php echo lang('month');?></option>
						<?php for($m=1;$m<=12;$m++){
							echo '<option value="'.$m.'" '; if($member_bmonth==$m) echo 'selected="selected"'; echo '>'.lang('month'.$m).'</option>';
						}?>
					</select>
				</div>
				<div class="medium-4 columns">
					<select id="member_byear" name="member_byear">
						<option value=""><?php echo lang('year');?></option>
						<?php for($y=date("Y")-10;$y>=1927;$y--){
							echo '<option value="'.$y.'" '; if($member_byear==$y) echo 'selected="selected"'; echo '>'.(($lang==1) ? ($y+543) : $y).'</option>';
						}?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<?php //if($member_type!='guest'){?>
	<div class="row">
		<div class="large-2 columns">
			<h2><?php echo lang('youraccount');?></h2>
			<br>
		</div>
		<div class="small-12 large-10 columns">
			<div class="medium-2 columns">
				<label for="member_email"><?php echo lang('email');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text" id="member_email" name="member_email">
				<span class="errorspan"><?php echo lang('v_email');?></span>
			</div>
			<div class="medium-2 columns">
				<label for="member_confirm_email"><?php echo lang('confirmemail');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<input type="text" id="member_confirm_email" name="member_confirm_email">
				<span class="errorspan"><?php echo lang('v_confirmemail');?></span>
			</div>
		</div>
		<div class="small-12 large-10 large-offset-2 columns">
			<div class="medium-2 columns">
				<label for="member_password"><?php echo lang('password');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<input type="password" id="member_password" name="member_password">
				<span class="errorspan"><?php echo lang('v_password');?></span>
			</div>
			<div class="medium-2 columns">
				<label for="member_confirm_password"><?php echo lang('confirmpassword');?> *</label>
			</div>
			<div class="medium-4-custom columns">
				<input type="password" id="member_confirm_password" name="member_confirm_password">
				<span class="errorspan"><?php echo lang('v_confirmpassword');?></span>
			</div>
		</div>
	</div> <!-- .row -->
	<?php //}?>
	
	<div class="navigator">
		<div>
			<a href="javascript:void(0)" onclick="chkCart1()" class="box right next"><?php echo (empty($contents)) ? lang('register') : lang('continue');?></a>
		</div>
	</div> <!-- .navigator -->
</form>

<script>
	//loadNavCart('<?php echo $lang;?>',1);
	function chkCart1(){
		chk=1;
		
		if($('#member_confirm_password').val()==''){
			$('#member_confirm_password').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_confirm_password').removeClass('validate').next().hide();
			
			if($('#member_password').val()!=$('#member_confirm_password').val()){
				$('#member_confirm_password').focus().addClass('validate').next().show();
				chk=0;
			}
		}
		if($('#member_password').val()==''){
			$('#member_password').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_password').removeClass('validate').next().hide();
		}
		
		if($('#member_confirm_email').val()==''){
			$('#member_confirm_email').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_confirm_email').removeClass('validate').next().hide();
			
			if($('#member_email').val()!=$('#member_confirm_email').val()){
				$('#member_confirm_email').focus().addClass('validate').next().show();
				chk=0;		
			}
		}
		if($('#member_email').val()==''){
			$('#member_email').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_email').removeClass('validate').next().hide();
		}
		
		if($('#member_lname').val()==''){
			$('#member_lname').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_lname').removeClass('validate').next().hide();
		}
		if($('#member_fname').val()==''){
			$('#member_fname').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_fname').removeClass('validate').next().hide();
		}
		if($('#member_title').val()==''){
			$('#member_title').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#member_title').removeClass('validate').next().hide();
		}
		
		if(chk==1){
			$.post( DIR_ROOT+'member/frontend/register', { 
				member_title: $('#member_title').val(),
				member_fname: $('#member_fname').val(),
				member_lname: $('#member_lname').val(),
				member_bday: $('#member_bday').val(),
				member_bmonth: $('#member_bmonth').val(),
				member_byear: $('#member_byear').val(),
				member_email: $('#member_email').val(),
				member_password: $('#member_password').val()
			}).done(function( data ) {
				if(data==''){
					alert("<?php echo lang('duplicateemail');?>");
					$('#member_email').focus();
				}else{
					<?php if(empty($contents)){?>
						window.location='home.php';
					<?php }else{?>
						window.location='cart2.php';
					<?php }?>
				}
			});
		}
	}
</script>
<?php //}?>