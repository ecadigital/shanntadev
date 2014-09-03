<?php if(isset($redirect)) {echo $redirect;}else{?>
<h3>Profile</h3>

<div id="showWarning" style="height:40px;"></div>

<div class="fluid">
	<iframe frameborder="0" width="0" height="0" id="myIframe" name="myIframe"></iframe>
	<form target="myIframe" method="post" id="profile_form" name="profile_formEdit" enctype="multipart/form-data" action="<?php echo DIR_ROOT?>admin/admin/profile">
	<div class="widget">
        <div class="formRow">
            <div class="grid3">
                <label class="lbl fl" for="admin_user">Username</label>
                <span class="required"></span>
            </div>
            <div class="grid9">
                <input type="text" id="admin_user" name="admin_user" class="inpt" value="<?php echo $listEdit['admin_user'];?>" disabled="disabled">
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid3">
                <label class="lbl fl" for="admin_name">Name</label>
                <span class="required"></span>
            </div>
            <div class="grid9">
                <input type="text" id="admin_name" name="admin_name" class="inpt" value="<?php echo $listEdit['admin_name'];?>" >
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid3">
                <label class="lbl fl" for="admin_email">Email</label>
                <span class="required"></span>
            </div>
            <div class="grid9">
                <input type="text" id="admin_email" name="admin_email" class="inpt" value="<?php echo $listEdit['admin_email'];?>">
            </div>
            <div class="clear"></div>
        </div>
        <?php /*?><?php if(!empty($listLanguage) && count($listLanguage) > 1){?>
        <div class="formRow">
            <div class="grid3">
                <label class="lbl" for="admin_language">Admin Language</label>
            </div>
            <div class="grid9">
                <select id="admin_language" name="admin_language">
                    <option value="0">-Use Default-</option>
                    <?php foreach($listLanguage as $list){?>
                    <option value="<?php echo $list["language_id"]?>" <?php echo ($list["language_id"]==$listEdit['admin_language'])?'selected="selected"':'';?> ><?php echo $list["language_desc"]?></option>
                    <?php }?>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <?php }?><?php */?>
        <div class="clear" style="height:10px;"></div>
        <div class="formRow">
            <fieldset>
                <legend>Change Password</legend>
                <div class="formRow">
                    <div class="grid3">
                        <label class="lbl" for="old_admin_pass">Old Password</label>
                    </div>
                    <div class="grid8">
                        <input type="password" id="old_admin_pass" name="old_admin_pass" class="inpt">
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label class="lbl" for="admin_pass">New Password</label>
                    </div>
                    <div class="grid8">
                        <input type="password" id="admin_pass" name="admin_pass" class="inpt">
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3">
                        <label class="lbl" for="admin_pass_cf">Confirm Password</label>
                    </div>
                    <div class="grid8">
                        <input type="password" id="admin_pass_cf" name="admin_pass_cf" class="inpt">
                    </div>
                    <div class="clear"></div>
                </div>
            </fieldset>
        </div>
        <div class="clear" style="height:130px;"></div>
        <div class="formRow">
            <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $listEdit['admin_id']?>"></input>
            <input type="submit" class="button" value="Submit"></input>
            <div class="clear"></div>
        </div>
    	<div class="clear"></div>
	</div>
</form>
</div>

<script>
jQuery.extend(jQuery.validator.messages, {
	
	remote: "รหัสผ่านเดิมไม่ถูกต้อง",
});
$("#profile_form").validate({
	rules: {
		admin_user: {
			required: true
		},
		admin_email: {
			required: true,
			email: true
		},
		old_admin_pass: {
			remote: DIR_ROOT+"admin/admin/chk_password/id/"+<?php echo $listEdit['admin_id']?>
		},
		admin_pass: {
			minlength: 6,
			maxlength: 20
		},
		admin_pass_cf: {
			minlength: 6,
			maxlength: 20,
			equalTo: "#admin_pass"
		}
   },
   submitHandler: function(form) {
		document.profile_formEdit.submit();
 	}
});
</script>
<?php }?>