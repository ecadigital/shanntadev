$(document).ready(function(){
	$(document).foundation();
	function addStyleAttribute($element, styleAttribute) {
	    if ($element.attr('style') != "undefined"){
	    	$element.attr('style', styleAttribute);
	    }else{
	    	$element.attr('style', $element.attr('style') + ';' + styleAttribute);
	    }
	}
	function menuClickable($menuName,$idDetail){
		$($menuName).click(function(){
			$smallTopmenu = $("#small-topmenu");
			$iconHover = $(this).children(".icons");
			$wholeIcon = $("#small-topmenu .icons");
			$idDetail = $($idDetail);
			$menus = $('#small-topmenu .menus');
			$wholeMenus = $('#small-topmenu .menus > *');
			if ($iconHover.hasClass("open")) {
				$wholeIcon.removeClass("open");
				$menus.slideUp("slow");
			}else{
				$iconHover.addClass("open");
				$wholeMenus.hide();
				$idDetail.show();
				$menus.slideDown("slow");
			};
		});
	}// menuClickable
	function formNavigator($navi){
        // $navi = $(".navigator > div > a");
        $navi = typeof $navi !== 'undefined' ? $navi : $(".navigator > div > a");
        if ($navi.length <= 1){
            $navi.parent().parent().css("width","117px");
        }
    } // FormNavigator

	menuClickable("#navigator","#navigatorDetail");
	menuClickable("#userInterface","#userInterfaceDetail");
	formNavigator();
	$("#topcartmenu ul > li > a").hover(function(){
		$sub = $(this).parent().children(".sub")
		$this = $(this)
		if ($sub.length > 0){
			$(this).addClass("active");
			$sub.addClass("active");
		}else{
			return false;
		}
		$sub.hover(function(){
			if ($this.hasClass("active") && $sub.hasClass("active")){

			}else{
				$this.addClass("active");
				$sub.addClass("active");
			}
		},function(){
			$this.removeClass("active");
			$sub.removeClass("active");
		});
	},function(){
		$(this).removeClass("active");
		$(this).parent().children(".sub").removeClass("active");
	});
	// if ($(".page header:has(hr)").length > 0){
	// 	$(".headImage").attr("style","top: -7.3125em;");
	// }
});