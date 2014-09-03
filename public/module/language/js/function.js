$(document).ready(function(){
	
	$(".switchlang").each(function(){
		var isDefault = $(this).attr('data-default');
		var $this = $(this);
		if(isDefault){
			$this.css({ opacity: 1 });
			
		}else{
			$this.css({ opacity: 0.5 });
			
			$this.hover(function(){
				$this.css({ opacity: 1 });
			},function(){
				$this.css({ opacity: 0.5 });
			});
		}
	});
});