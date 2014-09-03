$(document).ready(function(){
	$("td input.qty").keyup(function(){ // increase or decrease quantity
		if(isNaN($(this).val())) $(this).val('1');
		recalculate();
	});
	$("td a.remove-cart").click(function(){ // remove cart
		var $row = $(this).closest(".row");
		var rowid = $row.attr("row-id");
		$.post(DIR_ROOT+"shoppingcart/frontend/remove_cart",{rowid : rowid},function(){
			window.location.reload();
		});
	});
});

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