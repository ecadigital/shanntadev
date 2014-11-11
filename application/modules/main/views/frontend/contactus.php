<?php 
$this->modelShop = $this->load->model('shop/Shopmodel');
?>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/css/style.css">
<header>
	<h1><?php echo lang('contactus');?></h1>
	<!-- <hr> -->
	<div class="headImage">
		<img src="img/contactus-h.png" alt="">
	</div>
</header>
<div class="innerContent">
	<div class="small-12 medium-7 columns">
		<?php 
		if(empty($getMain)){
			echo '<div style="text-align:center; margin:100px;">'.lang('nodata').'</div>';
		}else{
			$main_contact = $getMain["main_contact"];
			echo html_entity_decode($main_contact);
		}?>
		<img src="img/dummy-map.png" alt="">
	</div>
	<div class="small-12 medium-5 column">
		<!--<form id="contactus">-->
			<input type="text" id="c_name" name="c_name" placeholder="<?php echo lang('name');?>">
			<span class="errorspan"><?php echo lang('v_name');?></span>
			<input type="text" id="c_email" name="c_email" placeholder="<?php echo lang('email');?>">
			<span class="errorspan"><?php echo lang('v_email');?></span>
			<input type="text" id="c_phone" name="c_phone" placeholder="<?php echo lang('phone');?>">
			<span class="errorspan"><?php echo lang('v_phone');?></span>
			<textarea rows="5" id="c_message" name="c_message" placeholder"<?php echo lang('message');?>"></textarea>
			<span class="errorspan"><?php echo lang('v_message');?></span>
			<div class="ta-right">
				<input type="button" onclick="chkContact()"  value="<?php echo lang('sendmessage');?>" class="button">
			</div>
		<!--</form>-->
	</div>
	<div class="small-12 columns">
		<hr>
	</div>
	<div class="small-12 columns">
		<h2 style="color: #D8D2D6;"><?php echo lang('storelocation');?></h2>
	</div>
	<?php 
	$no=0;
	$listShop = $this->modelShop->listAllShop($lang);
	if(!empty($listShop)){
		foreach($listShop as $list){
			$no++;
			$shop_id = $list["shop_id"];
			$shop_name = $list["shop_name"];
			$shop_detail = $list["shop_detail"];
			$shop_date = $list["shop_date_added"];
			$img_db = $list["shop_image"];
			
			$img_path = DIR_PUBLIC."images/noimage.png";
			if($img_db!=''){
				$path = "public/upload/shop/original/".basename($img_db);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path = DIR_ROOT.$path;
				}
			}
			if($no>1) echo '<hr class="smallest">';
			echo '
			<div class="row">
				<div class="small-3 medium-1 columns">
					<div class="map-marker">
						<div>
							<img src="img/assets/marker.png" alt="">
							<span>'.$no.'</span>
						</div>
					</div>
				</div>
				<div class="small-9 medium-6 column">
					<h3>'.$shop_name.'</h3>
					'.html_entity_decode($shop_detail).'
				</div>
				<div class="small-12 medium-5 column">
					<img src="'.$img_path.'" alt="">
				</div>
			</div><!-- .row -->';
		}
	}
	?>
</div>

<script>
	function chkContact(){
		chk=1;
		
		if($('#c_message').val()==''){
			$('#c_message').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#c_message').removeClass('validate').next().hide();
		}
		
		if($('#c_phone').val()==''){
			$('#c_phone').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#c_phone').removeClass('validate').next().hide();
		}
		if($('#c_email').val()==''){
			$('#c_email').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#c_email').removeClass('validate').next().hide();
		}
		if($('#c_name').val()==''){
			$('#c_name').focus().addClass('validate').next().show();
			chk=0;
		}else{
			$('#c_name').removeClass('validate').next().hide();
		}
		
		if(chk==1){
			$.post( DIR_ROOT+'contactus/frontend/add', { 
				c_name: $('#c_name').val(),
				c_email: $('#c_email').val(),
				c_phone: $('#c_phone').val(),
				c_message: $('#c_message').val()
			}).done(function( data ) {
				if(data==''){
					//alert("<?php echo lang('duplicateemail');?>");
					//$('#member_email').focus();
				}else{
					alert("<?php echo lang('v_sendcomplete');?>");
					window.location.reload();
				}
			});
		}
	}
</script>