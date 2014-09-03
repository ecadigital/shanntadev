<?php if(isset($redirect)){ echo $redirect; }else{
	$this->model = $this->load->model('shoppingcart/Shoppingcartmodel');
?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>module/shoppingcart/backend/js/function.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/ui_custom.css" charset="utf-8" />

<h3>เลขที่ใบสั่งซื้อ Order#<?php echo $listEditOrder["order_id"];?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>shoppingcart/backend/index">รายการสั่งซื้อ</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เลขที่ใบสั่งซื้อ Order#<?php echo $listEditOrder["order_id"];?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
    <div class="widget">
        <div class="formRow">
            <div class="grid1">
                <label class="lbl" for="member_id"><strong><?php echo lang('sp_member');?></strong></label>
            </div>
            <div class="grid3"><?php echo $listEditOrder["member_first_name"].' '.$listEditOrder["member_last_name"];?></div>
            <div class="grid1">&nbsp;</div>
            <div class="grid1">
                <label class="lbl fl" for="sp_date"><strong><?php echo lang('sp_date');?></strong></label>
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
                    <th width="7%" align="center">แต้ม/หน่วย</th>
                    <th width="7%" align="center">รวมแต้ม</th>
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
                        $point_summary += $order_item['order_qty']*$order_item['order_point'];
                        echo '<tr>'.$this->model->rowShow(($num+1),$order_item['product_id'],$order_item['product_name'],$order_item['order_qty'],$order_item['order_price'],$order_item['order_point']).'</tr>';
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
                    <td id="boxSumPoint" colspan="2" align="right"><?php 
                        $point_summary += $listEditOrder['order_point'];
                        echo number_format($point_summary);?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><strong>ส่วนลด</strong></td>
                    <td id="boxSumPrice" colspan="2" align="right">
                        <?php 
						if($listEditOrder['order_payment']==2){
							echo $listEditOrder['order_discount'];
						}
						?>
                    </td>
                    <td id="boxSumPrice" colspan="2" align="right">
                        <?php 
						if($listEditOrder['order_payment']==1){
							echo $listEditOrder['order_discount'];
						}
						?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><strong>รวมสุทธิ</strong></td>
                    <td id="boxSumPrice" colspan="2" align="right">
                        <?php 
						if($listEditOrder['order_payment']==2){
							list($discount,$dis_type) = $this->model->getDiscount($listEditOrder['order_discount']);
							$summary = ($dis_type==1) ? $summary*(100-$listEditOrder['order_discount'])/100 : $summary-$listEditOrder['order_discount'];
							echo number_format($summary,2);
						}
						?>
                    </td>
                    <td id="boxSumPrice" colspan="2" align="right">
                        <?php 
						if($listEditOrder['order_payment']==1){
							list($discount,$dis_type) = $this->model->getDiscount($listEditOrder['order_discount']);
							$point_summary = ($dis_type==1) ? $point_summary*(100-$listEditOrder['order_discount'])/100 : $point_summary-$listEditOrder['order_discount'];
							echo number_format($point_summary);
						}
						?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="widget">
        <div style="margin-top:10px; margin-bottom:10px;"><strong>ชื่อและที่อยู่ในการจัดส่ง</strong></div>
        <table width="100%">
            <tr>
                <td width="50%">
                    <div class="row">
                        <label for="member_first_name"><strong>ชื่อจริง - นามสกุล</strong></label>&nbsp;&nbsp;
                        <?php echo $listEditOrder['member_first_name'].' '.$listEditOrder['member_last_name'];?>
                    </div>
                    <div class="row">
                        <label for="member_address"><strong>ที่อยู่</strong></label>&nbsp;&nbsp;
                        <?php echo $listEditOrder['member_address'];?>
                    </div>
                    <div class="row">
                        <label for="member_tel"><strong>เบอร์โทรศัพท์</strong></label>&nbsp;&nbsp;
                        <?php echo $listEditOrder['member_tel'];?>
                    </div>
                </td>
                <td width="50%"><strong>Tracking Number </strong>&nbsp;&nbsp;<?php echo ($listEditOrder['order_tracking']=='') ? '-' : $listEditOrder['order_tracking'];?></td>
            </tr>
      	</table>
    </div>
</div>
<style>
#boxSumPoint,#boxSumPrice{ font-weight:bold; }
tfoot tr td{ background-color:#E1E8FF; }
</style>
<?php }?>