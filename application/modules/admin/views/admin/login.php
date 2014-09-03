<?php if(!isset($error)){
?>
<div id="loginForm">
    <div class="headLoginForm">
    Login Administrator
    </div>
    <div class="fieldLogin">    <div class="loginNotify">กรุณากรอก Username และ Password</div>

	<form method="post" id="login" style="margin-bottom:10px;">
        <label>Username</label><br>
        <input type="text" class="login" id="username" name="username"><br>
        <label>Password</label><br>
        <input type="password" class="login" id="password" name="password"><br>
        <div class="logControl">
			<input type="checkbox" class="check" id="remember_new" name="remember" value="1"/><label for="remember_new">Remember me</label>
        </div>
        <div style="margin-top:10px;">
        <input type="submit" class="button" value="Login">
        </div>
    </form>
    </div>
</div>
<script>
jQuery().ready(function(){
	// =========== login =========== //
	$("form#login, form#recover").submit(function(data){
		var warning = false;
		var thisId = $(this).attr('id');
		
		$("form#"+thisId+' input.required').each(function(){
			if(this.value == ''){
				warning = true;
				return false;
			}
		});
		if(warning){
			$(".loginNotify").slideDown('slow');
			return false;
		}else{
			var username = $("form#"+thisId+" #username").val();
			var password = $("form#"+thisId+" #password").val();
			var remember = getCheckboxOne("form#"+thisId+" input[name=remember]");
			$.post(DIR_ROOT+"admin/admin/login", { username: username, password: password,remember:remember  },
				function(data) {
					var data = $.trim(data);
					if(data === 'exist'){
						$(".loginNotify").html("ไม่พบ User นี้ในระบบ").slideDown('slow');
						return false;
					}
					else{
						window.location=DIR_ROOT+"product/backend/index";//+"admin/admin/index";
					}
		 		}
			);
			return false;
		}
		return false;
	});
});
</script>
<?php }else{ echo $error; }?>