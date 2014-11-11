$(document).ready(function(){

});


function loadListProduct(lang_id,product_categories_id){
	$('#content').html('<div style="text-align:center;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" /><div>');
	$.ajax({
		url : DIR_ROOT+'product/frontend/list_product/lang/'+lang_id+'/cat/'+product_categories_id,
		success: function(data){
			$('#content').html(data);
			
		}
	});
}
function loadListCollection(lang_id,collection_categories_id){
	$('#content').html('<div style="text-align:center;"><img src="'+DIR_PUBLIC+'images/icons/loader.gif" /><div>');
	$.ajax({
		url : DIR_ROOT+'collection/frontend/list_collection/lang/'+lang_id+'/cat/'+collection_categories_id,
		success: function(data){
			$('#content').html(data);
			
		}
	});
}
function loadListMenuHover(lang_id){
	$('#productPopup').html('<img src="'+DIR_PUBLIC+'images/icons/loader.gif" />');
	$.ajax({
		url : DIR_ROOT+'product/frontend/list_menuhover/lang/'+lang_id,
		success: function(data){
			$('#productPopup').html(data);
			
		}
	});
}
function loadListSlideCategories(lang_id){

	$.ajax({
		url : DIR_ROOT+'product/frontend/list_slidecategories/lang/'+lang_id,
		success: function(data){
			$('#slideCategories').html(data);
		
			var sync1 = $(".catagorieSlider");
			var sync2 = $(".paginationCatagorieSlider");
			var flag = false;
			var slides = sync1.owlCarousel({
				loop: true,
				items: 1,
				autoplay: true,
				autoplayHoverPause: true,
				onInitialized: function(e){
					if (sync2.children().hasClass("active")) {
						sync1.trigger('to.owl.carousel', [sync2.children(".active").index(), 300, true]);
					};
				  }
			}).on('change.owl.carousel', function(e) {
				sync2.children().removeClass("active");
				sync2.children().eq(e.relatedTarget.relative(e.property.value)).addClass("active");
			}).data('owl.carousel');
			var thumbs = sync2.on('click', '.item', function(e) {
					e.preventDefault();
					sync2.children().removeClass("active");
					sync1.trigger('to.owl.carousel', [$(this).index(), 300, true]);
					$(this).addClass("active");
			}).data('owl.carousel');
			
		}
	});
}
function loadBannerCategories(lang_id,product_categories_id){

	$.ajax({
		url : DIR_ROOT+'product/frontend/get_bannercategories/lang/'+lang_id+'/cat/'+product_categories_id,
		success: function(data){
			$('#boxBannerCategories').html(data);
			
		}
	});
}
function loadBannerCollection(lang_id,collection_categories_id){

	$.ajax({
		url : DIR_ROOT+'collection/frontend/get_bannercategories/lang/'+lang_id+'/cat/'+collection_categories_id,
		success: function(data){
			$('#boxBannerCategories').html(data);
			
		}
	});
}