$(document).ready(function(){
	
	$("#addCart").live('click',function(){ // add cart
		
		var id = $(this).closest(".wrap_product").attr('data-itemid');
		var data = "id="+id+"&qty=1";
		myDialogPost(DIR_ROOT+"shoppingcart/frontend/add_cart",data,450,180,'Add Cart');
		updateitems();
		$('div#wg_cart').trigger('click');
	});
	$("#addCartDetail").click(function(){
		var id = $(this).closest(".wrap_product").attr('data-itemid');
		var qty = $(this).siblings("#inp-qty").val();
		var rowid = $(this).closest(".wrap_product").attr('row-id');
		var data = "id="+id+"&qty="+qty+"&rowid="+rowid;
		myDialogPost(DIR_ROOT+"shoppingcart/frontend/add_cart",data,450,180,'Add Cart');
		updateitems();
		$('div#wg_cart').trigger('click');
	});
	
	$("#wrap-shopping-cart .remove-cart").live('click',function(){ // remove cart
		var $row = $(this).closest(".row_cart");
		var rowid = $row.attr("row-id");
		$.post(DIR_ROOT+"shoppingcart/frontend/remove_cart",{rowid : rowid},function(){
			$row.fadeOut('600', function() {
				$row.remove();
				var html = $.trim($("table#shopping-cart>tbody").html());
				if(html == '' || html == null){
					$("table#shopping-cart>tbody").html('<tr><td colspan="5" align="center"><span class="txt-head">Shopping cart is empty</span></td></tr>');
				}
				recalculate();
			});
		});
	});
	
	$(".quantity .plus").click(function(){ // increase quantity
		var $qty = $(this).siblings("#inp-qty");
		var newQty = (parseInt($qty.val()) < 999)?parseInt($qty.val())+1:999;
		$qty.val(newQty);
		recalculate();
	});
	$(".quantity .minus").click(function(){ // decrease quantity
		var $qty = $(this).siblings("#inp-qty");
		var newQty = (parseInt($qty.val()) > 0)?parseInt($qty.val())-1:0;
		$qty.val(newQty);
		recalculate();
	});
	$("td.qty input").keyup(function(){ // increase or decrease quantity
		recalculate();
	});
	$(".showlogin").live('click',function(){
		$("form.login").slideToggle();
	});
	
	$("button#cn_shopping").click(function(event) { // cancel shopping back to product page
		$.post(DIR_ROOT+"shoppingcart/frontend/update_cart",$('form#cart_form').serialize(),function(){window.location=DIR_ROOT+"product";});
		event.preventDefault();
	});
	$("button#cn_checkout").click(function(event) { // cancel checkout back to home page
		window.location=DIR_ROOT;
		event.preventDefault();
	});
	
	$("form#cart_form input#checkout").live('click',function(){ // for checkout
		if(!$(this).hasClass('disable')){
//			window.location=DIR_ROOT+"shoppingcart/frontend/checkout";
			myDialog(DIR_ROOT+"shoppingcart/frontend/chkoption",600,200,'รูปแบบการสั่งซื้อ ');
			return false;
		}
	});
	
	$(".alert_checkout.left").live('click',function(){ // for checkout
		window.location=DIR_ROOT+"shoppingcart/frontend/checkout_member";
		return false;
	});
	$(".alert_checkout.right").live('click',function(){ // for checkout
		window.location=DIR_ROOT+"shoppingcart/frontend/checkout_register";
		return false;
	});
	
	$("button#view_cart").live('click',function(){ // for view cart
		window.location=DIR_ROOT+"shoppingcart/frontend/cart";
		return false;
	});
	$("input#agreement").click(function(){
		if($(this).attr( 'checked' )){
			$("input#place_order").removeAttr('disabled').removeClass('disabled');
		}else{
			$("input#place_order").attr('disabled',true).addClass('disabled');
		}
	});
	$('input[name="mlm_pinid[]"]').keyup(function(){
		var text = '';
		$('input[name="mlm_pinid[]"]').each(function(){
			text += String($(this).val());
		});
		$("#mlm_pinid_hidden").val(text);
	});
	$('input[name="mlm_benefits_bank_accountnumber[]"]').keyup(function(){
		var text = '';
		$('input[name="mlm_benefits_bank_accountnumber[]"]').each(function(){
			text += String($(this).val());
		});
		$("#mlm_benefits_bank_accountnumber_hidden").val(text);
	});
	
	/* Widget Cart
	-----------------------------------------------------------------------------------------------*/
	
	$('div#wg_cart').click(function(){
		var $this = $(this);
		if($("div#wrap_popup").is(':hidden')){
			loadAjax(DIR_ROOT+"shoppingcart/frontend/list_cart",".list-item","");
			$this.addClass("menu-open").siblings(".popup-content").show();
		}else{
			$this.removeClass("menu-open").siblings(".popup-content").hide();
			$this.siblings(".popup-content").find(".list-item").empty();
		}
	});
	$(document).mouseup(function(e) {
		var obj = $(e.target);
		var wrap = obj.closest("#wrap_popup").attr('id');
		var id = obj.attr('id');
		if(wrap == 'wrap_popup' || id == 'fancybox-overlay' || id == 'fancybox-close'){
			if(id == 'view_cart'){
				window.location=DIR_ROOT+"shoppingcart/frontend/cart";
			}
			if(id == 'checkout'){
				if(!$(this).hasClass('disable')){
//					window.location=DIR_ROOT+"shoppingcart/frontend/checkout";
					myDialog(DIR_ROOT+"shoppingcart/frontend/chkoption",600,200,'รูปแบบการสั่งซื้อ ');
					return false;
				}
			}
		}else{
			if(obj.parent("div#wg_cart").length==0) {
				$("#wg_cart").removeClass('menu-open');
				$("div.popup-content").hide();
				$("div.list-item").empty();
				return false;
			}
		}
	});
	/* End Widget Cart
	-----------------------------------------------------------------------------------------------*/
	
	$("#shopping-cart>tbody tr, .order_detail>tbody tr").each(function(){
		$(this).find("#inp-qty").onlynum();
	});
});
var recalculate = function(){
	var totalQuantity = 0;
	var subtotal = 0;
	$("#shopping-cart>tbody tr, .order_detail>tbody tr").each(function(){
		var price = parseFloat($("td.price", this).text().replace(/([^0-9\.])/i, ''));
		
		price = isNaN(price)?0:price;
		var quantity = parseInt($("td.qty input#inp-qty", this).val());
		var cost = quantity * price;
		$("td.cost", this).text(number_format(cost, 2, '.', ','));
		totalQuantity += quantity;
		subtotal += cost;
	});
	var shipping = (subtotal > 4999 || subtotal == 0)?0:150;
	var total = parseFloat(subtotal + shipping);
	$("tr.subtitle td.total").text(number_format(subtotal, 2, '.', ','));
	
	$("tr.total td.qty>strong>span,tr.total td.qty>u>strong").text(String(totalQuantity));
	
	$("tr.total td.total>strong, tr.total td.total>strong>u").text(number_format(total, 2, '.', ','));
	$("tr.shipping td.total").text(number_format(shipping, 2, '.', ','));
	$.post(DIR_ROOT+"shoppingcart/frontend/update_cart",$("#cart_form").serialize(),function(){updateitems()});
	// disable checkout button
	if(totalQuantity == 0){$('#wrap-shopping-cart #checkout').addClass('disable');}
}
var updateitems = function(){
	$.get(DIR_ROOT+"shoppingcart/frontend/load",function(total_items){
		var $minicart = $("#my_cart .minicart-title");
		var total_item = total_items.split("#");
		var num = total_item[0];
		var text = total_item[1];
		if(num > 1){
			$("#my_cart span.total_items").html(text);
		}else{
			$minicart.html(text);
		}
	});
};