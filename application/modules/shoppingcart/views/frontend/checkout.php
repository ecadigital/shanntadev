<script type="text/javascript" src="<?php echo DIR_PUBLIC;?>module/shoppingcart/frontend/js/function.js"></script>

<h3>ช่องทางการชำระเงิน</h3>
            
<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
$sum_price = 0;
$sum_point = 0;

if(!empty($contents)){
	foreach($contents as $content){
		$product = $this->model->getProduct($content['id']);
		$qty = $content['qty'];
		$price = $product['product_price'];
		$total_price = $price*$qty;
		$point = $product['product_point'];
		$total_point = $point*$qty;
				
		$member_id = (isset($_SESSION['member_id'])) ? $_SESSION['member_id'] : 0;
		$member_discount = $this->model->get_member_discount($member_id);
		if($member_discount!=''){
			$price = $price*((100-$member_discount)/100);
			$point = $point*((100-$member_discount)/100);
			$total_price = $total_price*((100-$member_discount)/100);
			$total_point = $total_point*((100-$member_discount)/100);
		}
		
		$sum_price += $total_price;
		$sum_point += $total_point;
	}
}

if($sum_price==0&&$sum_point==0){
	/* echo '<script>window.location="cart.php";</script>';	*/
	?>
    <div>ไม่พบข้อมูล</div>
    <br/>
    <div class="row">
        <div align="right">
			<a href="product.php"><button class="yellow right"><i class="icon-chevron-left medium"></i>&nbsp;&nbsp;กลับไปเลือกสินค้า</button></a>
        </div>
    </div>
    <?php
}else{
?>

<iframe frameborder="0" width="0" height="0" id="myIframe_checkout" name="myIframe_checkout"></iframe>
<form class="formElement" method="post" id="form_checkout" name="form_checkout" target="myIframe_checkout" action="<?php echo DIR_ROOT?>shoppingcart/frontend/checkout">
<table class="responsive">
    <thead>
        <tr>
            <th style="background-color:#f2f2f2!important; color:#666666;">กรุณาเลือกช่องทางการชำระเงิน</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <h4><input type="radio" id="payment_1" name="payment" value="1" <?php echo ($member_point<$sum_point || $member_point==0) ? 'disabled="disabled"' : 'checked="checked"'; ?>> ตัดจากแต้ม (คุณมีแต้มสะสมคงเหลือ <?php echo number_format($member_point);?> แต้ม)</h4>
                <h5><p style="color:red;"><?php echo ($member_point<$sum_point || $member_point==0) ? 'คุณมีแต้มไม่เพียงพอ' : 'ต้องการตัดแต้มจำนวน '.number_format($sum_point).' แต้ม';?></p></h5>
                <h5><p style="color:red;"><?php echo ($member_point<$sum_point || $member_point==0) ? '': 'ยอดแต้มคงเหลือหลังจากหักแต้มแล้ว <strong>'.number_format($member_point-$sum_point).'</strong> แต้ม';?>
                <br>
                <h4><input type="radio" id="payment_2" name="payment" value="2" <?php if($sum_price==0) echo 'disabled="disabled"'; else if($member_point<$sum_point) echo 'checked="checked"';  ?>> โอนเงิน <?php echo number_format($sum_price);?> บาท</h4>
                <h5><p>ชื่อบัญชี..</p>
                <table class="responsive" id="shopping-cart">
                    <thead>
                        <tr>
                            <th data-width="55%" style="background-color:#f2f2f2!important; color:#666666;">ธนาคาร</th>
                            <th data-width="15%" style="background-color:#f2f2f2!important; color:#666666;"><center>สาขา</center></th>
                            <th data-width="15%" style="background-color:#f2f2f2!important; color:#666666;"><center>ชื่อบัญชี</center></th>
                            <th data-width="15%" style="background-color:#f2f2f2!important; color:#666666;"><center>เลขที่บัญชี</center></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(!empty($listBank)){
                        foreach($listBank as $list){
                            $bank_id = $list["bank_id"];
                            $img_db = $list["bank_image"];
                            $img_path = DIR_PUBLIC."layout/default/images/empty.png";
                            if($img_db!=''){
                                $path = "public/upload/bank/thumbnails/".basename($img_db);
                                $dir_file = DIR_FILE.$path;
                                if(file_exists($dir_file)){
                                    $img_path = DIR_ROOT.$path;
                                }
                            }
                            echo '
                            <tr>
                                <td><img src="'.$img_path.'" style="width:25px; height:25px;" />&nbsp;&nbsp;'.$list['bank_name'].'</td>
                                <td><center>'.$list['bank_branch'].'</center></td>
                                <td><center>'.$list['bank_account'].'</center></td>
                                <td><center>'.$list['bank_no'].'</center></td>
                            </tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
		 	
<br/>
<h3>ชื่อและที่อยู่ในการจัดส่ง</h3>

<div style="line-height:30px;"><input type="radio" name="radio_address" id="radio_address_0" value="0" checked="checked" /> ที่อยู่เดิม (หากแก้ไขจะอัพเดตให้อัตโนมัติ)</div>
<div style="line-height:30px;"><input type="radio" name="radio_address" id="radio_address_1" value="1" /> ที่อยู่ใหม่</div>
<table class="responsive" id="boxAddress_0">
    <tr>
        <td>
            <div class="row">
                <label for="member_first_name">ชื่อจริง - นามสกุล</label>
                <div class="one third padded">
                    <input type="text" id="member_first_name" name="member_first_name" placeholder="ชื่อจริง" value="<?php echo $getMember['member_first_name'];?>">
                    <div><label class="error" for="member_first_name" generated="true"></label></div>
                </div>
                <div class="one third padded">
                    <input type="text" id="member_last_name" name="member_last_name" placeholder="นามสกุล" value="<?php echo $getMember['member_last_name'];?>">
                    <div><label class="error" for="member_last_name" generated="true"></label></div>
                </div>
            </div>
            <div class="row">
                <label for="member_address">ที่อยู่</label>
                <div class="one whole padded">
                    <textarea id="member_address" name="member_address" placeholder="ที่อยู่(ใช้สำหรับจัดส่งสินค้า)"><?php echo $getMember['member_address'];?></textarea>
                </div>
            </div>
            <div class="row">
                <label for="member_tel">เบอร์โทรศัพท์</label>
                <div class="one third padded">
                    <input type="text" id="member_tel" name="member_tel" placeholder="เบอร์โทรศัพท์" value="<?php echo $getMember['member_tel'];?>">
                </div>
            </div>
        </td>
    </tr>
</table>
<table class="responsive" id="boxAddress_1" style="display:none;">
    <tr>
        <td>
            <div class="row">
                <label for="member_first_name">ชื่อจริง - นามสกุล</label>
                <div class="one third padded">
                    <input type="text" id="member_first_name_1" name="member_first_name_1" placeholder="ชื่อจริง" value="">
                    <div><label class="error" for="member_first_name_1" generated="true"></label></div>
                </div>
                <div class="one third padded">
                    <input type="text" id="member_last_name_1" name="member_last_name_1" placeholder="นามสกุล" value="">
                    <div><label class="error" for="member_last_name_1" generated="true"></label></div>
                </div>
            </div>
            <div class="row">
                <label for="member_address">ที่อยู่</label>
                <div class="one whole padded">
                    <textarea id="member_address_1" name="member_address_1" placeholder="ที่อยู่(ใช้สำหรับจัดส่งสินค้า)"></textarea>
                </div>
            </div>
            <div class="row">
                <label for="member_tel">เบอร์โทรศัพท์</label>
                <div class="one third padded">
                    <input type="text" id="member_tel_1" name="member_tel_1" placeholder="เบอร์โทรศัพท์" value="">
                </div>
            </div>
        </td>
    </tr>
</table>
            	
<br/>
<div class="row">
    <div align="right">
        <a href="<?php echo DIR_ROOT;?>cart.php"><button type="button" class="yellow right"><i class="icon-chevron-left medium"></i>&nbsp;&nbsp;กลับไปที่ตะกร้าสินค้า</button></a>
        <?php if( ($member_point>=$sum_point && $sum_point>0 ) || $sum_price>0){ echo '<button type="button" id="bt_submit" class="blue right">ส่งรายการสินค้า&nbsp;&nbsp;<i class="icon-chevron-right medium"></i></button>'; }?>
    </div>
</div>
</form>
<script>
$(document).ready(function () {
	$('#radio_address_0').click(function(){
		$('#boxAddress_1').hide();
		$('#boxAddress_0').slideDown();
	});
	$('#radio_address_1').click(function(){
		$('#boxAddress_0').hide();
		$('#boxAddress_1').slideDown();
	});
	$('#bt_submit').click(function(){
		chk=1;
		if($('#radio_address_0').attr('checked')=='checked'){
			if($('#member_tel').val()==''){
				 $('#member_tel').addClass('error');
				 $('#member_tel').focus();
				 chk=0;
			}else{
				 $('#member_tel').removeClass('error');
			}
			if($('#member_address').val()==''){
				 $('#member_address').addClass('error');
				 $('#member_address').focus();
				 chk=0;
			}else{
				 $('#member_address').removeClass('error');
			}
			if($('#member_last_name').val()==''){
				 $('#member_last_name').addClass('error');
				 $('#member_last_name').focus();
				 chk=0;
			}else{
				 $('#member_last_name').removeClass('error');
			}
			if($('#member_first_name').val()==''){
				 $('#member_first_name').addClass('error');
				 $('#member_first_name').focus();
				 chk=0;
			}else{
				 $('#member_first_name').removeClass('error');
			}
		}else{
			if($('#member_tel_1').val()==''){
				 $('#member_tel_1').addClass('error');
				 $('#member_tel_1').focus();
				 chk=0;
			}else{
				 $('#member_tel_1').removeClass('error');
			}
			if($('#member_address_1').val()==''){
				 $('#member_address_1').addClass('error');
				 $('#member_address_1').focus();
				 chk=0;
			}else{
				 $('#member_address_1').removeClass('error');
			}
			if($('#member_last_name_1').val()==''){
				 $('#member_last_name_1').addClass('error');
				 $('#member_last_name_1').focus();
				 chk=0;
			}else{
				 $('#member_last_name_1').removeClass('error');
			}
			if($('#member_first_name_1').val()==''){
				 $('#member_first_name_1').addClass('error');
				 $('#member_first_name_1').focus();
				 chk=0;
			}else{
				 $('#member_first_name_1').removeClass('error');
			}
		}
		if(chk==1){
			if(confirm('ยืนยันการทำรายการหรือไม่')){
				document.getElementById('form_checkout').submit();
			}	
		}
	})
});
</script>
<?php }?>