<?php if(isset($redirect)){ echo $redirect; }else{
	$this->model = $this->load->model('shoppingcart/Shoppingcartmodel');
?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>module/shoppingcart/backend/js/function.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/ui_custom.css" charset="utf-8" />

<h3>เลขที่ใบสั่งซื้อ <?php echo str_pad($listEditOrder['order_id'],6,0,STR_PAD_LEFT);?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>shoppingcart/backend/index">รายการสั่งซื้อ</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เลขที่ใบสั่งซื้อ <?php echo str_pad($listEditOrder['order_id'],6,0,STR_PAD_LEFT);?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
    <div class="widget">
        <div class="formRow">
            <div class="grid1">
                <label class="lbl" for="member_id"><strong>ชื่อ</strong></label>
            </div>
            <div class="grid3"><?php echo $listEditOrder["member_first_name"].' '.$listEditOrder["member_last_name"];?></div>
            <div class="grid1">&nbsp;</div>
            <div class="grid1">
                <label class="lbl fl" for="sp_date"><strong>วันที่สั่งซื้อ</strong></label>
            </div>
            <div class="grid2"><?php echo $this->bflibs->timeString($listEditOrder['order_date'],'date');?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="widget">
        
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
            <thead> 
                <tr> 
                    <th align="center" width="50"><?php echo lang('web_no');?></th>
                    <th align="left">รายการสินค้า</th>
                    <th width="5%" align="center">จำนวน</th>
                    <th width="10%" align="center">ราคา/หน่วย</th>
                    <th width="10%" align="center">รวม</th>
                </tr> 
            </thead>
            <tbody id="boxAdd">
				<?php 
                $summary = 0;
                $amount_summary = 0;
                $point_summary = 0;
                if(!empty($listEditOrder['order_item'])){
                    foreach($listEditOrder['order_item'] as $num=>$order_item){
                        $sum = $order_item['order_qty']*$order_item['order_price'];
                        $summary += $sum;
                        $amount_summary += $order_item['order_qty'];
                        echo '<tr>'.$this->model->rowShow(($num+1),$order_item['product_id'],$order_item['product_name'],$order_item['order_qty'],$order_item['order_price']).'</tr>';
                    }
                }
                                
                ?>
            </tbody>
            <tfoot>
                <!--<tr>
                    <td colspan="3" align="right"><strong><?php echo lang('sp_subtotal');?></strong></td>
                    <td id="boxSumAmount" align="right"><?php echo number_format($amount_summary);?></td>
                    <td id="boxSubTotal" align="right"><?php echo number_format($summary,2);?></td>
                    <td id="boxSubPoint" align="right"><?php echo number_format($point_summary);?></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"><strong><?php echo lang('sp_dicsount');?> / <?php echo lang('sp_subpoint');?></strong></td>
                    <td colspan="2" align="right"><?php echo $listEditOrder['order_discount'];?></td>
                    <td align="right"><?php echo $listEditOrder['order_point'];?></td>
                </tr>-->
                <tr>
                    <td colspan="2" align="right"><strong><?php echo lang('sp_total');?></strong></td>
                    <td id="boxSumAmount" align="right" rowspan="3"><?php echo number_format($amount_summary);?></td>
                    <td id="boxSumPrice" colspan="2" align="right">
                        <?php echo number_format($summary,2);?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="widget">
        <table width="100%">
            <tr>
                <td width="50%" style="padding-left:20px;">
					<div style="margin-left:-20px; margin-bottom:10px;"><strong>ชื่อและที่อยู่ในการจัดส่ง</strong></div>
                    <div class="row" style="margin-bottom:10px;">
                        <label for="member_first_name">ชื่อ - นามสกุล : </label>&nbsp;&nbsp;
                        <?php echo $listEditOrder['member_first_name'].' '.$listEditOrder['member_last_name'];?>
                    </div>
                    <div class="row" style="margin-bottom:10px;">
                        <label for="member_address">ที่อยู่ : </label>&nbsp;&nbsp;
                        <?php echo $listEditOrder['member_address'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="member_city">จังหวัด : </label>&nbsp;&nbsp;
                        <?php echo $listEditOrder['member_city'];?>
                    </div>
                    <div class="row" style="margin-bottom:10px;">
                        <label for="member_postcode">รหัสไปรษณีย์ : </label>&nbsp;&nbsp;
                        <?php echo $listEditOrder['member_postcode'];?>
                    </div>
                    <div class="row" style="margin-bottom:10px;">
                        <label for="member_tel">เบอร์โทรศัพท์ : </label>&nbsp;&nbsp;
                        <?php echo $listEditOrder['member_phone'];?>
                    </div>
				</td>
                <td width="50%" style="vertical-align:top;"><strong>Tracking Number </strong>&nbsp;&nbsp;<?php echo ($listEditOrder['order_tracking']=='') ? '-' : $listEditOrder['order_tracking'];?></td>
            </tr>
      	</table>
    </div>
	<div class="widget">
        <div style="margin-top:10px; margin-bottom:10px;"><strong>ข้อมูลการชำระเงิน</strong></div>
        <table width="100%">
            <tr>
                <td width="50%" style="padding-left:20px;">
                    <div class="row" style="margin-bottom:10px;">
                        <?php 
						if($listEditOrder['order_payment']=='transfer') echo 'แจ้งชำระเงินผ่านการโอนเงิน';
						else if($listEditOrder['order_payment']=='paypal') echo 'แจ้งชำระเงินผ่าน Paypal';
						else if($listEditOrder['order_payment']=='credit') echo 'แจ้งชำระเงินผ่านการตัดบัตรเครดิต';
						?>
                    </div>
				</td>
            </tr>
      	</table>
    </div>
	<div class="widget">
        <div style="margin-top:10px; margin-bottom:10px;"><strong>ข้อความจากลูกค้า</strong></div>
        <table width="100%">
            <tr>
                <td width="50%" style="padding-left:20px;">
                    <div class="row" style="margin-bottom:10px;">
                        <?php echo ($listEditOrder['member_message']=='') ? '-' : $listEditOrder['member_message'];?>
                    </div>
				</td>
            </tr>
      	</table>
    </div>
</div>
<style>
#boxSumPoint,#boxSumPrice{ font-weight:bold; }
tfoot tr td{ background-color:#E1E8FF; }
</style>
<?php }?>