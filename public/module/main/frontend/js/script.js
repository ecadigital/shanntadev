function loadPage(path){ //shoppingcart/frontend/cart/lang/'+lang_id
	$('#content').html('<div style="text-align:center; margin:40px;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+path,
		success: function(data){
			$('#content').html(data);			
		}
	});
}