jQuery().ready(function(){
	var height = $(document).height()-166;
	$("#content").css({'minHeight':height+'px'});
	$('.placeholder').each(function () {
		var label = $(this).find('label:first');
		var input = $(this).find('input:first');
		if (input.val() != '') {
			label.stop().hide();
		}
		input.focus(function () {
			if ($(this).val() == '') {
				label.stop().fadeTo(500, 0.5);
			}
		});
		input.blur(function () {
			if ($(this).val() == '') {
				label.stop().fadeTo(500, 1);
			}
		});
		input.keypress(function () {
			label.stop().hide();
		});
		input.keyup(function () {
			if ($(this).val() == '') {
				label.stop().fadeTo(500, 0.5);
			}
		});
	});
});