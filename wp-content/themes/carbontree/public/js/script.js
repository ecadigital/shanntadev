(function( $ ){

	window.CarbonTree = function(){
		
		/*----------------------------------------------------------------------------
		 Initialise everything
		----------------------------------------------------------------------------*/
		var init = function (){
			flexsliders();
			wrapHeadingsWithSpans();
			replaceSVGS();
			matchSiblingsHeight();
			waypoints();
			beforeAfter();
			magnificPopup();
		};
		
		var flexsliders = function() {				
			// We need to disable 'useCSS' on iOS mobile devices because of bug in flexisliders library
			// which makes the sliders unresponsive when scrolling vertically and horizontally at the same time
			if( /iPhone|iPad|iPod/i.test(navigator.userAgent) ) {
				$('.m-slider').flexslider({
					directionNav : false,
					animation : 'slide',
					useCSS: false,
					controlsContainer : '.m-slider-controls'
				});
			}
			else  {
				$('.m-slider').flexslider({
					directionNav : false,
					animation : 'slide',
					useCSS: true,
					controlsContainer : '.m-slider-controls'
				});
			}
		};
		
		var wrapHeadingsWithSpans = function(){
			$('h1, .h1, .m-text-background').each(function(index, element){
				element = $(element);
				var str = $.trim(element.text());
				var words = str.split(" ");
				element.empty();
				$.each(words, function(i, word) {
					element.append( $("<span>").text(word) );
				});
			});
		};
		
		var replaceSVGS = function(){
			$('.svg-replace').each(function(index, element){
				var $this = $(this),
					svgReplacementData = $this.attr('data-svg-replacement');
				
				if( svgReplacmentPossible(svgReplacementData) )
				{
					$this.attr('src', svgReplacementData);
				}
			});
		};
		
		var svgReplacmentPossible = function(svgReplacementData){
			return ! Modernizr.svg && svgReplacementData !== '';
		};
		
		var matchSiblingsHeight = function(){
			$('.js-match-siblings-height').each(function(index, element){
				var $this = $(this),
					children = $this.children();
					maxHeight = Math.max.apply(null, children.map(function(){
						return $(this).height();
					}).get());
				
				children.height(maxHeight);
			});
		};
		
		var waypoints = function(){
			$('.waypoint').waypoint(function(direction){
				$(this).addClass('js-in-view');
				$(this).prev().addClass('show-timeline');
			}, {
				offset : '80%'
			});
			$('.waypoint').addClass('show-timeline-always').last().removeClass('show-timeline-always');
		};
		
		var beforeAfter = function () {
			$(window).load(function() {
				$(".before-after").twentytwenty();
			});
		};
		
		var magnificPopup = function () {
			$(window).load(function() {
				$(".magnific-popup-gallery").magnificPopup({
					delegate: 'a',
					type: 'image',
					gallery: {enabled: true}
				});
			});
		};
		
		/*----------------------------------------------------------------------------
		 Public API
		----------------------------------------------------------------------------*/
		return {
			init : function(){
				init();
			}
		};
	}();
	
	$(function(){
		CarbonTree.init();
	});

})( jQuery );