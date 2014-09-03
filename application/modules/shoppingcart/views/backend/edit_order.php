<?php if(isset($redirect)){ echo $redirect; }else{
	$this->model = $this->load->model('shoppingcart/Shoppingcartmodel');
?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC?>module/shoppingcart/backend/js/function.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/ui_custom.css" charset="utf-8" />

<h3><?php echo lang('sp_add');?></h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>shoppingcart/backend/index"><?php echo lang('sp_ii');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
	<?php echo lang('sp_add');?>
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form class="formElement" method="post" id="order_form" name="order_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>shoppingcart/backend/add_order">
        <div class="widget">
            <div class="formRow">
                <div class="grid1">
					<label class="lbl" for="member_id"><?php echo lang('sp_member');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid3">
					<select id="member_id" name="member_id" class="sep_bo">
                    	<option value=""><?php echo lang('sp_member_select');?></option>
						<?php if(!empty($listMember)){foreach($listMember as $list){?>
                        <option value="<?php echo $list["member_id"]?>" <?php echo ($list["member_id"] == $listEditOrder['member_id'])?'selected="selected"':'';?> ><?php echo $list["member_first_name"].' '.$list["member_last_name"];?></option>
                        <?php }}?>
                    </select>
                </div>
                <div class="grid1">&nbsp;</div>
                <div class="grid1">
                    <label class="lbl fl" for="sp_date"><?php echo lang('sp_date');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="sp_date" name="sp_date" value="<?php echo $this->bflibs->dateToShow($listEditOrder['order_date'],'date');?>">
                </div>
            </div>
           	<div class="clear"></div>
        </div>
        <div class="widget">
            
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
                <thead> 
                    <tr> 
                        <th align="center" width="50"><?php echo lang('web_no');?></th>
                        <th align="left">รายการสินค้า</th>
                        <th width="12%" align="center">ราคา</th>
                        <th width="5%" align="center">จำนวน</th>
                        <th width="7%" align="center">รวม</th>
                        <th width="7%" align="center">แต้มสะสม</th>
                        <th align="center" width="50"><?php echo lang('web_tool');?></th> 
                    </tr> 
                </thead>
                <tbody id="boxAdd">
                    <tr>
                        <td align="center">#</td>
                        <td colspan="6">
                            <select id="product_id" name="product_id" style="width:500px;">
                                <option value="">- <?php echo lang('sp_select_product');?> -</option>
                                <?php if(!empty($listProduct)){foreach($listProduct as $list){?>
                                <option value="<?php echo $list["product_id"]?>" ><?php echo $list["product_name"]?></option>
                                <?php }}?>
                            </select>
                        </td>
                    </tr>
                </tbody>
                <?php 
				$summary = 0;
				$amount_summary = 0;
				$point_summary = 0;
				if(!empty($listEditOrder['order_item'])){
					foreach($listEditOrder['order_item'] as $num=>$order_item){
						$sum = $order_item['order_qty']*$order_item['order_price'];
						$summary += $sum;
						$amount_summary += $order_item['order_qty'];
						$point_summary += $order_item['order_point'];
						echo '<tr>'.$this->model->rowList(($num+1),$order_item['product_id'],$sum,$order_item['product_name'],$order_item['order_qty'],$order_item['order_price'],$order_item['order_point']).'</tr>';
					}
				}
								
				?>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><?php echo lang('sp_subtotal');?></td>
                        <td id="boxSumAmount" align="right"><?php echo number_format($amount_summary);?></td>
                        <td id="boxSubTotal" align="right"><?php echo number_format($summary,2);?></td>
                        <td id="boxSubPoint" align="right"><?php echo number_format($point_summary);?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><?php echo lang('sp_dicsount');?><span class="txt_notify" style="top:-7px; position:relative;">(ก)</span> / <?php echo lang('sp_subpoint');?><span class="txt_notify" style="top:-7px; position:relative;">(ข)</span></td>
                        <td colspan="2" align="right"><input id="discount" name="discount" size="10" placeholder="0" style="text-align:right;" onkeyup="sumAll()" onkeypress="return chkNumberPercent(event)" value="<?php echo $listEditOrder['order_discount'];?>"></td>
                        <td align="right"><input id="point" name="point" size="5" placeholder="0" style="text-align:right;" onkeyup="sumAll()" onkeypress="return chkNumberInteger(event)" value="<?php echo $listEditOrder['order_point'];?>"></td>
                        <td><div></div></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><?php echo lang('sp_total');?></td>
                        <td colspan="2" id="boxSumTotal" align="right">
							<?php 
							list($discount,$dis_type) = $this->model->getDiscount($listEditOrder['order_discount']);
							$summary = ($dis_type==1) ? $summary*(100-$listEditOrder['order_discount'])/100 : $summary-$listEditOrder['order_discount'];
							echo number_format($summary,2);?>
                        </td>
                        <td id="boxSumPoint" align="right"><?php 
							$point_summary += $listEditOrder['order_point'];
							echo number_format($point_summary);?></td>
                        <td><div></div></td>
                    </tr>
                </tfoot>
            </table>
            <div class="formRow" style="margin-bottom:20px;">
                <input type="hidden" id="numList" name="numList" value="0" />
                <input type="hidden" id="code" name="code" value="1" />
                <input type="hidden" id="listorder" name="listorder" value="" />
                
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
            <div>
                <div class="txt_notify">
                    <div>(ก) สามารถให้ส่วนลดราคาสินค้าเพิ่มเติมได้ที่ท้ายตาราง โดยสามารถกรอกเป็นจำนวน หรือเปอร์เซ็นต์ก็ได้ เช่น </div>
                    <div><span style="color:#900;"><strong>100</strong></span> หมายถึง ลดราคาอีก 10 บาท จากราคารวมทั้งหมด</div>
                    <div><span style="color:#900;"><strong>10%</strong></span> หมายถึง ลดราคาอีก 10% จากราคารวมทั้งหมด</div>
                </div>
                <div class="clear" style="height:15px;"></div>
                <div class="txt_notify">
                    <div>(ข) สามารถเพิ่มหรือลดแต้มสะสมได้จากท้ายตาราง โดยเป็นจำนวนเต็มบวกหรือจำนวนเต็มลบเท่านั้น เช่น</div>
                    <div><span style="color:#900;"><strong>10</strong></span> หมายถึง เพิ่มแต้มให้อีก 10 แต้มแก่สมาชิกคนที่สั่งซื้อ</div>
                    <div><span style="color:#900;"><strong>-10</strong></span> หมายถึง ลบแต้มอีก 10 แต้มออกจากสมาชิกคนที่สั่งซื้อ</div>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
.ui-datepicker{ z-index:1000; }
</style>
<script>
$(document).ready(function(){
	$('.ui-datepicker').css('z-index',1000);
	$("#sp_date").datepicker({
		dateFormat: "dd/mm/yy",
		dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"], 
		monthNames: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
		monthNamesShort: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
		changeMonth: true,
		changeYear: true
	});
});
</script>
<?php }?>