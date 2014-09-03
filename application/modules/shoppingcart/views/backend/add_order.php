<?php if(isset($redirect)){ echo $redirect; }else{ ?>
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
                        <option value="<?php echo $list["member_id"]?>" ><?php echo $list["member_first_name"].' '.$list["member_last_name"];?></option>
                        <?php }}?>
                    </select>
                </div>
                <div class="grid1">&nbsp;</div>
                <div class="grid1">
                    <label class="lbl fl" for="sp_date"><?php echo lang('sp_date');?></label>
                    <span class="required"></span>
                </div>
                <div class="grid2">
                    <input type="text" id="sp_date" name="sp_date" value="<?php echo date("d/m/Y");?>">
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
                        <th width="5%" align="center">จำนวน</th>
                        <th width="12%" align="center">ราคา</th>
                        <th width="10%" align="center">รวม</th>
                        <th width="5%" align="center">แต้ม</th>
                        <th width="7%" align="center">รวมแต้ม</th>
                        <th align="center" width="50"><?php echo lang('web_tool');?></th> 
                    </tr> 
                </thead>
                <tbody id="boxAdd">
                    <tr>
                        <td align="center">#</td>
                        <td colspan="7">
                            <select id="product_id" name="product_id" style="width:500px;">
                                <option value="">- <?php echo lang('sp_select_product');?> -</option>
                                <?php if(!empty($listProduct)){foreach($listProduct as $list){?>
                                <option value="<?php echo $list["product_id"]?>" ><?php echo $list["product_name"]?></option>
                                <?php }}?>
                            </select>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <!--<tr>
                        <td colspan="3" align="right"><strong><?php echo lang('sp_subtotal');?></strong></td>
                        <td id="boxSumAmount" align="right">0</td>
                        <td id="boxSubTotal" align="right">0.00</td>
                        <td id="boxSubPoint" align="right">0</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong><?php echo lang('sp_dicsount');?> / <?php echo lang('sp_subpoint');?></strong></td>
                        <td colspan="2" align="right"><input id="discount" name="discount" size="10" placeholder="0" style="text-align:right;" onkeyup="sumAll()" onkeypress="return chkNumberPercent(event)"></td>
                        <td align="right"><input id="point" name="point" size="5" placeholder="0" style="text-align:right;" onkeyup="sumAll()" onkeypress="return chkNumberInteger(event)"></td>
                        <td><div></div></td>
                    </tr>-->
                    <tr>
                        <td colspan="2" align="right"><strong><?php echo lang('sp_total');?></strong></td>
                        <td id="boxSumAmount" align="right">0</td>
                        <td id="boxSumPrice" colspan="2" align="right">0.00</td>
                        <td id="boxSumPoint" colspan="2" align="right">0</td>
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
        </div>
    </form>
</div>
<style>
#boxSumPoint,#boxSumPrice{ font-weight:bold; }
tfoot tr td{ background-color:#E1E8FF; }
</style>
<script>
$(document).ready(function(){
	$("#order_form").validate({
		rules: {
			'member_id' : {
				required: true,
			},
		},
	   	submitHandler: function(form) {
			document.order_formAdd.submit();
	 	}
	});
	
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