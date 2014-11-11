<?php 
$admin= $this->session->userdata('admin');

$active_home = '';
$active_product = '';
$active_member = '';
$active_voucher = '';
$active_order = '';
$active_news = '';
$active_contactus = '';
$active_admin = '';

$active_other = '';

if(strpos(DIR_URI,DIR_ROOT.'main/backend/dashboard')===0) 				$active_home = 'active';
if(strpos(DIR_URI,DIR_ROOT.'product')===0) 				$active_product = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'collection')===0) 		$active_product = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'news')===0) 			$active_news = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'member')===0) 			$active_member = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'shoppingcart')===0) 	$active_order = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'contactus')===0) 		$active_contactus = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'slide')===0) 			$active_other = 'active';

else if(strpos(DIR_URI,DIR_ROOT.'main/backend/index/p/9')===0) 	$active_order = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'main/backend/index/p/10')===0) 	$active_order = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'main/backend/contact')===0) 	$active_contactus = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'jewely')===0) 			$active_other = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'faq')===0) 			$active_other = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'lookbook')===0) 			$active_other = 'active';
else if(strpos(DIR_URI,DIR_ROOT.'admin')===0) 			$active_admin = 'active';

else $active_home = 'active';
?>

<ul id="nav">
    <li class="<?php echo $active_home;?>" style="width:40px;"><a href="<?php echo DIR_ROOT?>main/backend/dashboard"><img src="<?php echo DIR_PUBLIC?>images/icons/color/home.png" height="20" /></a></li>
    <!--<li><a href="#">About</a></li>-->
    <li class="sub <?php echo $active_product;?>" style="width:150px;"><a href="#"><img src="<?php echo DIR_PUBLIC?>images/icons/color/shipping.png" height="20" /> สินค้า/คอลเลคชั่น</a>
        <ul>
            <li><a href="<?php echo DIR_ROOT?>product/backend/index">รายการสินค้า</a></li>
            <li><a href="<?php echo DIR_ROOT?>product/backend/index_categories">รายการหมวดหมู่สินค้า</a></li>
            <li><a href="<?php echo DIR_ROOT?>collection/backend/index">รายการคอลเลคชั่น</a></li>
            <li><a href="<?php echo DIR_ROOT?>collection/backend/index_categories">รายการหมวดหมู่คอลเลคชั่น</a></li>
        </ul>
    </li>
    <li class="sub <?php echo $active_order;?>" style="width:130px;"><a href="#"><img src="<?php echo DIR_PUBLIC?>images/icons/color/basket.png" height="20" />รายการสั่งซื้อ</a><?php /*?><?php echo DIR_ROOT?>shoppingcart/backend/add_order<?php */?>
        <ul>
            <li><a href="<?php echo DIR_ROOT?>shoppingcart/backend/index">รายการสั่งซื้อ</a></li>
            <li><a href="<?php echo DIR_ROOT?>shoppingcart/backend/index_confirm">รายการยืนยันการโอนเงิน</a></li>
            <li><a href="<?php echo DIR_ROOT?>shoppingcart/backend/index_bank">รายการบัญชีธนาคาร</a></li>
        </ul>
    </li>
    <?php if($admin->admin_group<=2){?>
        <li class="<?php echo $active_member;?>" style="width:130px;"><a href="<?php echo DIR_ROOT?>member/backend/index"><img src="<?php echo DIR_PUBLIC?>images/icons/color/customers.png" height="20" /> รายชื่อสมาชิก</a>
            <!--<ul>
                <li><a href="<?php echo DIR_ROOT?>member/backend/index">รายชื่อสมาชิก</a></li>
                <li><a href="<?php echo DIR_ROOT?>member/backend/add_member">เพิ่มสมาชิก</a></li>
                <li><a href="<?php echo DIR_ROOT?>member/backend/add_point">เพิ่ม/ลดแต้มสมาชิก</a></li>
                <li><a href="<?php echo DIR_ROOT?>member/backend/index_setting">ตั้งค่าข้อมูลอื่นๆ</a></li>
            </ul>-->
        </li>
        <!--
        <li class="sub <?php echo $active_voucher;?>" style="width:110px;"><a href="#"><img src="<?php echo DIR_PUBLIC?>images/icons/color/ticket.png" height="20" /> Voucher</a>
            <ul>
                <li><a href="<?php echo DIR_ROOT?>voucher/backend/index_voucher">รายการ Voucher</a></li>
                <li><a href="<?php echo DIR_ROOT?>voucher/backend/add_voucher">เพิ่ม Voucher</a></li>
            </ul>
        </li>-->
    <?php }?>
    
    
    
    <li class="sub <?php echo $active_contactus;?>" style="width:100px;"><a href="#"><img src="<?php echo DIR_PUBLIC?>images/icons/color/attibutes.png" height="20" />ติดต่อเรา</a>
        <ul>
            <li><a href="<?php echo DIR_ROOT?>contactus/backend/index">รายการผู้ติดต่อ</a></li>
            <li><a href="<?php echo DIR_ROOT?>main/backend/contact">  แก้ไขข้อมูลการติดต่อ</a></li>
            <li><a href="<?php echo DIR_ROOT?>shop/backend/index">  ข้อมูลที่ตั้งร้าน/สาขา</a></li>
        </ul>
    </li>
    
    <li class="sub <?php echo $active_other;?>" style="width:140px;"><a href="#"><img src="<?php echo DIR_PUBLIC?>images/icons/color/config.png" height="20" /> จัดการหน้าอื่นๆ</a>
        <ul>
			<li><a href="<?php echo DIR_ROOT?>news/backend/index"><img src="<?php echo DIR_PUBLIC?>images/icons/color/world.png" height="20" /> ข่าวและอีเว้นท์</a></li>
            <li><a href="<?php echo DIR_ROOT?>slide/backend/index"><img src="<?php echo DIR_PUBLIC?>images/icons/color/delicious.png" height="20" /> รายการภาพสไลด์</a></li>
			<li><a href="<?php echo DIR_ROOT?>jewely/backend/index"><img src="<?php echo DIR_PUBLIC?>images/icons/color/jewely.png" height="20" /> หน้า Jewely D.I.Y</a></li>
			<li><a href="<?php echo DIR_ROOT?>main/backend/aboutus"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" /> หน้า About us</a></li>
			<li><a href="<?php echo DIR_ROOT?>faq/backend/index"><img src="<?php echo DIR_PUBLIC?>images/icons/color/comment.png" height="20" /> หน้า FAQ</a></li>
			<li><a href="<?php echo DIR_ROOT?>lookbook/backend/index"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" /> หน้า LOOKBOOK</a></li>
			<li><a href="<?php echo DIR_ROOT?>main/backend/help"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" /> หน้าช่วยเหลือ</a></li>
			<li><a href="<?php echo DIR_ROOT?>main/backend/howtobuy"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" /> หน้าวิธีการสั่งซื้อสินค้าและชำระเงิน</a></li>
			<li><a href="<?php echo DIR_ROOT?>main/backend/shipping"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" /> หน้าข้อมูลการจัดส่ง</a></li>
			<li><a href="<?php echo DIR_ROOT?>main/backend/refund"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" /> หน้านโยบายการคืนเงิน</a></li>
			<li><a href="<?php echo DIR_ROOT?>main/backend/policy"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" /> หน้าเงื่อนไขการใช้บริการ</a></li>
            <li><a href="<?php echo DIR_ROOT?>main/backend/intro"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" />  จัดการหน้า Intro </a></li>
            <!--<li><a href="<?php echo DIR_ROOT?>slide/backend/add_slide"><img src="<?php echo DIR_PUBLIC?>images/icons/color/delicious.png" height="20" />  เพิ่มภาพสไลด์</a></li>
            <li><a href="<?php echo DIR_ROOT?>faq/backend/index"><img src="<?php echo DIR_PUBLIC?>images/icons/color/current-work.png" height="20" /> รายการคำถามที่พบบ่อย</a></li>
            <li><a href="<?php echo DIR_ROOT?>faq/backend/add_faq"><img src="<?php echo DIR_PUBLIC?>images/icons/color/current-work.png" height="20" />  เพิ่มคำถามที่พบบ่อย</a></li
            <li><a href="<?php echo DIR_ROOT?>main/backend/index/p/3"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" />  หน้าแรก : รู้จัก Have Reward</a></li>
            <li><a href="<?php echo DIR_ROOT?>main/backend/index/p/2"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" />  หน้าแรก : วิธีการซื้อขาย</a></li>
            <li><a href="<?php echo DIR_ROOT?>main/backend/index/p/5"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" />  หน้าแรก: วิธีแลก Voucher</a></li>
            <li><a href="<?php echo DIR_ROOT?>main/backend/index/p/4"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" />  หน้าแรก: Voucher คืออะไร</a></li>
            <li><a href="<?php echo DIR_ROOT?>main/backend/index/p/7"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" />  Footer: หน้าเติมแต้ม</a></li>
            <li><a href="<?php echo DIR_ROOT?>main/backend/index/p/8"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" />  Footer: หน้าวิธีแลกแต้ม</a></li>
            <li><a href="<?php echo DIR_ROOT?>main/backend/index/p/6"><img src="<?php echo DIR_PUBLIC?>images/icons/color/archives.png" height="20" />  Footer: ติดต่อสอบถาม </a></li>-->
        </ul>
    </li>
    
    <?php if($admin->admin_group<=2){?>
        <li class="sub <?php echo $active_admin;?>" style="width:115px;"><a href="#"><img src="<?php echo DIR_PUBLIC?>images/icons/color/user.png" height="20" />ผู้ดูแลระบบ</a>
            <ul>
                <li><a href="<?php echo DIR_ROOT?>admin/users/index/p/2"> Admin ระดับสูง </a></li>
                <li><a href="<?php echo DIR_ROOT?>admin/users/index/p/3"> Admin ระดับกลาง </a></li>
            </ul>
        </li>
    <?php }?>
</ul>