$(document).ready(function(){

});
function loadListProduct(lang_id,product_categories_id){

	$.ajax({
		url : DIR_ROOT+'product/frontend/list_product/lang/'+lang_id+'/cat/'+product_categories_id,
		success: function(data){
			$('#content').html(data);
			
		}
	});
}