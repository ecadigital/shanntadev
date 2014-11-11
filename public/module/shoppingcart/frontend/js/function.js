$(document).ready(function(){
	/*$("div input.wqty").keyup(function(){ // increase or decrease quantity
		if(isNaN($(this).val())) $(this).val('1');
		w_recalculate();
	});
	$("div input.qty").keyup(function(){ // increase or decrease quantity
		if(isNaN($(this).val())) $(this).val('1');
		recalculate();
	});
	$(".wremove").click(function(){ // remove cart
		var $row = $(this).closest(".row");//alert($row);
		var rowid = $row.attr("row-id");
		$.post(DIR_ROOT+"shoppingcart/frontend/remove_cart",{rowid : rowid},function(){
			$row.remove();
		});
	});*/
	$("td a.remove-cart").click(function(){ // remove cart
		var $row = $(this).closest(".row");
		var rowid = $row.attr("row-id");
		$.post(DIR_ROOT+"shoppingcart/frontend/remove_cart",{rowid : rowid},function(){
			window.location.reload();
		});
	});
});


function removeCartWidget(rowid,lang_id){
	var $row = $('#wremove_'+rowid).closest(".row");
	$.post(DIR_ROOT+"shoppingcart/frontend/remove_cart",{rowid : rowid},function(data){
		$row.remove();
		loadWidgetCart(lang_id);
		$('.widget_items').html(data);		
	});
}
function changeQty(i){
	if(isNaN($("#wqty_"+i).val())) $("#wqty_"+i).val("1");
	w_recalculate();
}

function w_recalculate(){

	sum_price = 0;
	numlist=$("#numlist").val();
	for(num=1;num<=numlist;num++){
		price = ($("#wprice_"+num).length>0) ? $("#wprice_"+num).html() : 0;
		price = cutNumberSeparate(price);
		qty = $("#wqty_"+num).val();
		total = price*qty;
		sum_price = parseFloat(sum_price)+parseFloat(total);
		$("#wtotal_"+num).html(number_format(total,0,".",","));
	}
	shipping = $("#wshipping").html();
	shipping = cutNumberSeparate(shipping);
	summary = parseFloat(sum_price)+parseFloat(shipping);
	
	$("#wsubtotal").html(number_format(sum_price,0,".",","));
	$("#wsummary").html(number_format(summary,0,".",","));
	
	
	$.post(DIR_ROOT+"shoppingcart/frontend/update_cart_widget",$("form#form_cart_widget").serialize(),function(){  loadTotalItems();  });

}

var recalculate = function(){
	sum_qty = 0;
	sum_price = 0;
	sum_point = 0;
	$("#shopping-cart>tbody tr").each(function(){
		ele_qty = $("td input.qty",this);
		qty = ele_qty.val();
		price = ele_qty.next().val();
		point = ele_qty.next().next().val();
		
		total_price = qty*price;
		$("td .total_price",this).html(number_format (total_price, 0, '.', ','));
		
		total_point = qty*point;
		$("td .total_point",this).html(number_format (total_point, 0, '.', ','));
		
		sum_qty = parseInt(sum_qty)+parseInt(qty);
		sum_price = parseFloat(sum_price)+parseFloat(total_price);
		sum_point = parseFloat(sum_point)+parseFloat(total_point);
	});
	$("#sum_qty").html(number_format (sum_qty, 0, '.', ','));
	$("#sum_price").html(number_format (sum_price, 0, '.', ','));
	$("#sum_point").html(number_format (sum_point, 0, '.', ','));
	
	$.post(DIR_ROOT+"shoppingcart/frontend/update_cart",$("form#form_cart").serialize(),function(){  });

}



function addCart(id,lang_id){	
	$.post(DIR_ROOT+"shoppingcart/frontend/add_cart", { 
		id: id,
		qty: 1
	}).done(function( data ) {
		//alert($('#v_addtocart_'+id).html()+'----#v_addtocart_'+id);
		$('.v_addtocart').slideDown().delay(2000).slideUp();
		loadWidgetCart(lang_id);
		//window.location.reload()
	});
	
}
function loadWidgetCart(lang_id){
	$('#boxWidgetCart').html('<div style="text-align:center; margin:40px;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /><div>');
	$.ajax({
		url : DIR_ROOT+'shoppingcart/frontend/widget/lang/'+lang_id,
		success: function(data){
			data = $.parseJSON(data);
			$('#boxWidgetCart').html(data['widget_box']);
			$('.widget_items').html(data['widget_items']);			
		}
	});
}
function loadTotalItems(){
	$('.widget_items').html('<img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:10px;" />');
	$.ajax({
		url : DIR_ROOT+'shoppingcart/frontend/total_cart',
		success: function(data){
			$('.widget_items').html(data);			
		}
	});
}
/*function loadNavCart(lang_id,step){
	$('#nav_cart').html('<div><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+'shoppingcart/frontend/nav_cart/lang/'+lang_id+'/step/'+step,
		success: function(data){
			$('#nav_cart').html(data);			
		}
	});
}*/
function loadCart(lang_id){
	$('#content').html('<div style="text-align:center; margin:40px;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+'shoppingcart/frontend/cart/lang/'+lang_id,
		success: function(data){
			$('#content').html(data);			
		}
	});
}
function loadCart0(lang_id){
	$('#content').html('<div style="text-align:center; margin:40px;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+'shoppingcart/frontend/cart0/lang/'+lang_id,
		success: function(data){
			$('#content').html(data);			
		}
	});
}
function loadCarts(lang_id,num){
	$('#content').html('<div style="text-align:center; margin:40px;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+'shoppingcart/frontend/cart'+num+'/lang/'+lang_id,
		success: function(data){
			$('#content').html(data);			
		}
	});
}
function loadCart5(lang_id,order_id){
	$('#content').html('<div style="text-align:center; margin:40px;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" style="width:30px;" /></div>');
	$.ajax({
		url : DIR_ROOT+'shoppingcart/frontend/cart5/lang/'+lang_id+'/id/'+order_id,
		success: function(data){
			$('#content').html(data);			
		}
	});
}