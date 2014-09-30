function loadPage(path){ //shoppingcart/frontend/cart/lang/'+lang_id
	$('#content').html('<div style="text-align:center; margin:40px;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+path,
		success: function(data){
			$('#content').html(data);			
		}
	});
}

function loadFooter(lang_id){
	$('.boxFooter').html('<div style="text-align:center;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+'main/frontend/footer/lang/'+lang_id,
		success: function(data){
			$('.boxFooter').html(data);			
		}
	});
}
function loadSocial(lang_id,type){
	$('#boxSocial').html('<div style="text-align:center;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+'main/frontend/social/lang/'+lang_id+'/type/'+type,
		success: function(data){
			if(type=='small'){
				$('#boxSocialSmall').html(data);
			}else{
				$('#boxSocial').html(data);
			}
		}
	});
}