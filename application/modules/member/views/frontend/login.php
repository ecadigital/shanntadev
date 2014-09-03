<h3>เข้าสู่ระบบ</h3>

<iframe frameborder="0" width="0" height="0" id="myIframe_profile" name="myIframe_profile"></iframe>
<form name="form_profile" id="form_profile" target="myIframe_profile" action="<?php echo DIR_ROOT;?>member/frontend/login" method="post">
    <fieldset>
        <div class="row">
            <label for="member_first_name">ชื่อผู้ใช้</label>
            <div class="one whole padded">
                <input type="text" id="username" name="username" >
            </div>
      	</div>
        <div class="row">         
            <label for="member_first_name">รหัสผ่าน</label>
            <div class="one whole padded">
                <input type="password" id="password" name="password" >
            </div>
        </div>
        <div class="row">
            <div class="one whole padded">                                
                <input type="hidden" id="captcha" name="captcha" value=""></input>
                <input type="submit" value="เข้าสู่ระบบ" class="pull-right blue">
            </div>
        </div> 
    </fieldset>
</form>

<script>
$(document).ready(function(){
	$("#form_login").validate({
		rules: {
			'username' : {
				required: true,
			},
			'password' : {
				required: true,
			}
		},
		messages: {
			'username' :{
				required : "กรุณากรอกอีเมล์ของคุณ",
			},
			'password' :{
				required : "กรุณากรอกรหัสผ่าน",
			},
		},
	   	submitHandler: function(form) {
			document.form_login.submit();
	 	}
	});
});

</script>