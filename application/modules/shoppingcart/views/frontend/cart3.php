<?php if(empty($contents)){?>
	<div style="height:150px; text-align:center; margin-top:50px;"><?php echo lang('nodata');?></div>
<?php }else{ ?>
<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$this->modelProduct = $this->load->model('product/Product_frontmodel');
$this->modelMember = $this->load->model('member/Member_frontmodel');

$member_type = (isset($_SESSION['order']['member_type'])) ? $_SESSION['order']['member_type'] : '';
$member_title = (isset($_SESSION['order']['member_title'])) ? $_SESSION['order']['member_title'] : '';
$member_fname = (isset($_SESSION['order']['member_fname'])) ? $_SESSION['order']['member_fname'] : '';
$member_lname = (isset($_SESSION['order']['member_lname'])) ? $_SESSION['order']['member_lname'] : '';
$member_address = (isset($_SESSION['order']['member_address'])) ? $_SESSION['order']['member_address'] : '';
$member_city = (isset($_SESSION['order']['member_city'])) ? $_SESSION['order']['member_city'] : '';
$member_postcode = (isset($_SESSION['order']['member_postcode'])) ? $_SESSION['order']['member_postcode'] : '';
$member_email = (isset($_SESSION['order']['member_email'])) ? $_SESSION['order']['member_email'] : '';
$chk_accept = (isset($_SESSION['order']['chk_accept'])) ? $_SESSION['order']['chk_accept'] : '';
$chk_message = (isset($_SESSION['order']['chk_message'])) ? $_SESSION['order']['chk_message'] : '';
$member_message = (isset($_SESSION['order']['member_message'])) ? $_SESSION['order']['member_message'] : '';

$name = lang($member_title).' '.$member_fname.' '.$member_lname;
$address = $member_address.' '.$member_city.' '.$member_postcode;

$summary = 0;
$shipping = 250;
?>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/css/style.css">
<header>
	<div class="medium-4 columns">
		<h1>REVIEW</h1>
	</div>
	<div class="medium-8 columns"><?php echo $this->model->nav_cart(3);?></nav></div>
	<div class="clearfix"></div>
</header>
<form action="#" method="post">
	<div class="row productTable shipping">
		<div class="medium-4 columns">
			<h2><?php echo lang('orderdetail');?></h2>
			<h3><?php echo lang('orderdetailbelow');?></h3>
		</div>
		<div class="small-12 medium-5 medium-offset-3 columns addressReview">
			<h2><?php echo lang('deliveryaddress');?></h2>
			<b><?php echo ($name=='') ? 'ไม่มีชื่อ' : $name;?></b>
			<div id="boxAddess"><?php echo ($address=='') ? 'ไม่มีที่อยู่' : $address;?></div>
			<div id="boxAddessEdit" class="row" style="display:none; margin-top:5px;">
				<div class="small-4 columns"><label for="member_address"><?php echo lang('address');?> *</label></div>
				<div class="small-8 columns">
					<textarea name="member_address" id="member_address" style="height:70px;"><?php echo $member_address;?></textarea>
				</div>
				
				<div class="small-4 columns"><label for="member_city"><?php echo lang('city');?> *</label></div>
				<div class="small-8 columns">
					<input type="text" id="member_city" name="member_city" value="<?php echo $member_city;?>">
				</div>
				
				<div class="small-4 columns"><label for="member_postcode"><?php echo lang('postcode');?> *</label></div>
				<div class="small-8 columns">
					<input type="text" id="member_postcode" name="member_postcode" value="<?php echo $member_postcode;?>">
				</div>
			</div>
			<a class="edit" onclick="showEdit()"><i class="fa fa-pencil icon"></i> <?php echo lang('edit');?></a>
		</div>
		<table>
			<tr>
				<td class="medium-2">
					<h4><?php echo lang('product');?></h4>
				</td>
				<td class="medium-8">
					<h4><?php echo lang('description');?></h4>
				</td>
				<td>
					<h4><?php echo lang('price');?></h4>
				</td>
			</tr>
			<?php 
			$i=0;
			foreach($contents as $content){
				$rowid = $content['rowid'];
				$product_id = $content['id'];
				$product = $this->modelProduct->getProduct($lang,$product_id);
				$qty = $content['qty'];
				$price = $product['product_price'];
				$currency = $product['product_currency'];
				if($currency==''){
					$currency = 'USD';
					if($lang==1) $currency = 'บาท';
					if($lang==3) $currency = 'CNY';
				}
				$name = $product["product_name"];
				$detail = $product["product_detail"];
				$img_db = $this->modelProduct->getFirstProductImage($product_id);
				
				
				$img_path = DIR_PUBLIC."images/noimage.png";
				if($img_db!=''){
					$path = "public/upload/product/thumbnails/".basename($img_db);
					$dir_file = DIR_FILE.$path;
					if(file_exists($dir_file)){
						$img_path = DIR_ROOT.$path;
					}
				}
				$i++;
				$total = $price*$qty;
				$summary += $total;
					
				echo '<tr '; if($i==1) echo 'class="first"'; echo '>
					<td class="image">
						<img src="'.$img_path.'" alt="">
					</td>
					<td>
						<h5>'.$name.'</h5>
						<div class="show-for-medium-up details">'.$detail.'</div>
					</td>
					<td>
						<div class="price"><span id="price_'.$i.'">'.number_format($price).'</span> <b>'.$currency.'</b></div>
					</td>
				</tr>';
			}?>
		</table>
		<?php 
		$currency = 'USD';
		if($lang==1) $currency = 'บาท';
		if($lang==3) $currency = 'CNY';
		?>
			
		<hr class="review">
		<div class="small-12 medium-7 columns optionalCheckbox" style="margin-top:-15px;">
			<input type="checkbox" name="chk_message" id="chk_message" value="1" <?php if($chk_message==1) echo 'checked="checked"';?>><label for="chk_message"> <?php echo lang('personalmessage');?></label>
			
			<div class="small-12" id="boxMessage" style="<?php if($chk_message!=1) echo 'display:none;';?>">
				<textarea name="member_message" id="member_message" style="height:70px;"><?php echo $member_message;?></textarea>
			</div>
		</div>
		<div class="small-12 medium-4 columns total" style="margin-top:-29px;">
			<div class="small-4 columns"><?php echo lang('shipping');?></div>
			<div class="small-8 columns ta-right"> <?php echo number_format($shipping);?> <?php echo $currency;?></div>
			<div class="small-4 columns"><b><?php echo lang('total');?></b></div>
			<div class="small-8 columns ta-right"><b><?php echo number_format($summary+$shipping);?> <?php echo $currency;?></b></div>
			<div class="clearfix"></div>
			<label class="checkbox"><input type="checkbox" name="chk_accept" id="chk_accept" value="1"> <?php echo lang('iaccept');?> <u><?php echo lang('termsandcon');?></u></label>
		</div>
	</div>
	<br>
	<div class="navigator">
		<div>
			<a href="cart2.php" class="arrow_box left prev"><?php echo lang('previous');?></a>
			<a href="javascript:void(0)" onclick="chkCart3()" class="arrow_box right next"><?php echo lang('continue');?></a>
		</div>
	</div> <!-- .navigator -->
</form>

<script>
	//loadNavCart('<?php echo $lang;?>',1);
	function chkCart3(){
		chk=1;
		if($('#chk_accept:checked').length==0){
			alert("<?php echo lang('alertterms');?>");
			chk=0;
		}
		if(chk==1){
			$.post( DIR_ROOT+'shoppingcart/frontend/set_sesmember', { 
				member_address: $('#member_address').val(),
				member_postcode: $('#member_postcode').val(),
				member_city: $('#member_city').val(),
				chk_message: $('#chk_message:checked').length,
				member_message: $('#member_message').val()
			}).done(function( data ) {
				window.location='cart4.php';
			});
		}
	}
	function showEdit(){
		$('#boxAddess').toggle();
		$('#boxAddessEdit').toggle();
	}
	$('#chk_message').click(function(){
		if($('#chk_message:checked').length==1) $('#boxMessage').slideDown();
		else{ $('#boxMessage').slideUp(); $('#member_message').val(''); }
	});
</script>
<?php }?>