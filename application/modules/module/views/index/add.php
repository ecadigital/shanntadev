<?php if(isset($redirect)) {echo $redirect;}else{?>
<div class="clearfix">
	<div class="fr">
		<button class="btn btn_blue sep_bo" onclick="loadAjax('<?php echo DIR_ROOT?>module/index/index','#','')"><span><?php echo lang('web_back');?></span></button>
	</div>
</div>
<?php if(!empty($listExtensionModule)){?>
<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
<form class="formElement" method="post" id="module_form" name="module_formAdd" enctype="multipart/form-data" target="myIframe" action="<?php echo DIR_ROOT?>module/index/add">
	<fieldset class="brdrrad_4">
	<legend><h1><?php echo lang('web_add_module');?></h1></legend>
		<div id="showWarning"></div>
		<div id="module_accordion">				
			<div class="micro">
				<input type="radio" id="buildModule" name="module_buildfrom" value="1" class="accordion" checked="checked"/><label class="accordion" >&nbsp;&nbsp;<?php echo "สร้างโมดูลเอง";?></label>
			</div>
			<div class="micro">
				<input type="radio" id="selectModule" name="module_buildfrom" value="2" class="accordion"/><label class="accordion" >&nbsp;&nbsp;<?php echo "สร้างโมดูลจาก Extension";?></label>
				<ul class="sub_section clearfix">
					<li>
						<fieldset class="brdrrad_4 lbl">
							<legend class="sep_bo"><?php echo lang('web_select_type_module');?></legend>
							<div class="clearfix">
							<?php if(!empty($listExtensionModule)){foreach($listExtensionModule as $list){?>
								<span class="dp50">
									<label for='extension_id_<?php echo $list['extension_id'];?>'><input type="radio" id="extension_id_<?php echo $list['extension_id'];?>" name="extension_id" value="<?php echo $list['extension_id'];?>" />&nbsp;&nbsp;<?php echo $list['extension_name'];?></label>
								</span>
							<?php }}?>
							</div>
							<label for="extension_id" class="error"><?php echo lang('web_select_above');?></label>
						</fieldset>
					</li>
				</ul>
			</div>
		</div>

		<div class="sep_bo">
			<label class="lbl fl" for="module_name"><?php echo lang('web_module_name');?></label>
			<span class="required"></span><div class="clearfix"></div>
			<input type="text" id="module_name" name="module_name" class="inpt" >
		</div>
		<div class="sep_bo">
			<label class="lbl" for="module_desc"><?php echo lang('web_desc');?></label>
			<input type="text" id="module_desc" name="module_desc" class="inpt long" >
		</div>
		<input type="hidden" id="captcha" name="captcha" value=""></input>
		<input type="submit" value="<?php echo lang('web_save');?>" class="btn"></input>
	</fieldset>
</form>
<script>
$("#module_form").validate({
	rules: {
		module_name: {
			required: true,
			remote: DIR_ROOT+"module/index/chk_modulename"
		},
		extension_id: {
			required: true
		}
   },
   submitHandler: function(form) {
		document.module_formAdd.submit();
 	}
});

/* Module Accordions
/*----------------------------------------------------------------------*/

$("#module_accordion").each(function () {

	var obj = $(this);
	var o = 'micro-open';
	var c = 'micro-close';
	var openSingle = true;
	var tc = 'input.accordion,label.accordion';
	
	obj.children('div.micro').children(tc).click(function () {

		var a = $(this);
		if (openSingle) {
            obj.children('div.micro').each(function () {

                if(!a.hasClass(o)){
                	($(this).children(tc).hasClass(o)) ? $(this).children(tc).addClass(c).removeClass(o).siblings('.sub_section').slideToggle():'';
                	(a.get(0).tagName != 'INPUT')?$(this).children('input:radio').removeAttr('checked'):'';
                }
            });
        }
		a.addClass(o).siblings('.sub_section').slideToggle();
		(a.hasClass(c)) ? a.addClass(o).removeClass(c) : a.addClass(c).removeClass(o);
		a.siblings('input:radio').attr('checked','checked');
	}).each(function () {
		$(this).addClass(c).siblings('.sub_section').css('display', 'none');
	});
});

</script>
<?php }else{?>
<div id="showWarning"></div>
<script>window.parent.displayNotify('<?php echo lang('web_module_warning');?>','error','#showWarning')</script>
<?php }}if(isset($error)) {echo $error;}?>