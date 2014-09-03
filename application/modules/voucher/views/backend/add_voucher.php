<?php if(isset($redirect)){ echo $redirect; }else{ 
$this->model = $this->load->model('voucher/Vouchermodel');
?>
<script type="text/javascript" src="<?php echo DIR_PUBLIC ?>js/jquery.chosen.min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_PUBLIC ?>css/chzn.css" charset="utf-8" />

<h3>เพิ่ม Voucher</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index"><?php echo lang('menu_home');?></a>&nbsp;&nbsp;>&nbsp;&nbsp;
    <a href="<?php echo DIR_ROOT?>voucher/backend/index_voucher">ข้อมูล Voucher</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	เพิ่ม Voucher
</div>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
    <iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
    <form class="formElement" method="post" id="voucher_form" name="voucher_formAdd" target="myIframe" action="<?php echo DIR_ROOT?>voucher/backend/add_voucher">
        <div class="widget">
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="voucher_no">เลข Voucher</label>
                    <span class="required"></span>
                </div>
                <div class="grid4">
                    <input type="text" id="voucher_no" name="voucher_no" style="width:150px;">
                </div>
            </div>   
           	<div class="clear"></div> 
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="voucher_tel">เบอร์โทร</label>
                    <span class="required"></span>
                </div>
                <div class="grid6">
                    <input type="text" id="voucher_tel" name="voucher_tel" style="width:150px;">
                </div>
            </div>   
           	<div class="clear"></div>
            
            <div class="formRow">
                <div class="grid2">
                    <label class="lbl fl" for="voucher_point">จำนวนแต้มที่เพิ่ม</label>
                    <span class="required"></span>
                </div>
                <div class="grid6">
                    <input type="text" id="voucher_point" name="voucher_point" style="width:150px;">
                </div>
            </div>   
           	<div class="clear"></div>
            
            <div class="clear" style="height:0px;"></div>
            <div class="formRow">
				<input type="hidden" id="captcha" name="captcha" value=""></input>
				<input type="submit" class="button" value="<?php echo lang('web_save');?>"></input>
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>
				
<script>
$(document).ready(function(){
	
	$("#voucher_form").validate({
		rules: {
			'voucher_no' : {
				required: true,
			},
			'voucher_tel' : {
				required: true,
				number: true,
			},
			'voucher_point' : {
				required: true,
				number: true,
			},
	   },
	   submitHandler: function(form) {
			document.voucher_formAdd.submit();
		}
	});
});
</script>
<?php }?>