jQuery().ready(function(){
	
	var $content = $('#container');
	var height = $(document).height()-167;
	$("#content").css({'minHeight':height+'px'});

	/* Accordions
	/*----------------------------------------------------------------------*/
	$content.find('#left_sidebar').microAccordion({
		openSingle: true,
	});
	$("#left_sidebar .sub_section li a").click(function(){
		$(this).addClass('current');
	});
	
	/*  GOOGLE ANALYTIC
	----------------------------------------------------------------------------------------------- */	
	var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-29556234-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
//	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    ga.src = DIR_PUBLIC+'js/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	  
	/*  VALIDATOR
	----------------------------------------------------------------------------------------------- */	
	jQuery.extend(jQuery.validator.messages, {
		
		required: "ฟิลด์ที่จำเป็นต้องกรอก",
		remote: "ข้อมูลนี้ ไม่สามารถใช้ได้",
		email: "รูปแบบของ อีเมล์ไม่ถูกต้อง",
		minlength: $.validator.format("รหัสผ่านต้องไม่น้อยกว่า {0} ตัวอักษร"),
		equalTo: "รหัสผ่านที่กรอกไม่ตรงกัน",
		number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
		url: "รูปแบบลิงค์ที่กรอกไม่ถูกต้อง (ตัวอย่าง >> http://samplesite.com)"
	});
	
	jQuery.validator.addMethod(
    	"require_tinyMCE",
    	function(element){
    		tinymce.get(element).getContent()==''; 
    		return false;
    	},"This field is required."
    );
});

var addClass = function(cl, obj){

	$('div.micro').find("a."+cl).removeClass(cl);
	$(obj).addClass(cl);
}
var change_status = function(url){
	$.get(url,function(neworder){
		var count_order = $.trim(neworder);
		if(count_order > 0){
			$(".alertnotify .count").html(count_order);
		}else{
			$(".alertnotify").find(".count").remove();
		}
	});
}

function changeLangTop(id,repage){
	//alert(repage);
	$.ajax({ 
		url:  DIR_ROOT+'language/index/defaultadmin/id/'+id,
		success: function(response){ 
			location.reload();//loadAjax(repage,'#','');
		}
	});
}