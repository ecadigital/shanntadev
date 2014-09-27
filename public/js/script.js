var DIR_ROOT = '/shanntadev/';
var DIR_PUBLIC = DIR_ROOT+'public/';

jQuery().ready(function(){
	
	/* To Top
	/*----------------------------------------------------------------------*/
	$(".toTop").click(function(data){
		$('html, body').animate({ scrollTop: 0 }, 'slow');
	});
	
	/* Table 
	/*----------------------------------------------------------------------*/
	$('.table_content tr,.table_content tbody tr').hover(function(){
		$(this).addClass('tb_hover');
	},function(){
		$(this).removeClass('tb_hover');
	});
});

var loadAjax = function(Url,Target,Func,loadding)
{	//alert(Url+'----'+Target+'----'+Func);
	var ajaxTarget = (Target == '#')?'#content':Target;
	if(loadding == '' || loadding){
		ajaxLoading();
	}
	$.ajax({
		url : Url+"/layout/ajax",
		async : false,
		success: function(data){
			if(Target=="" && Func!=""){
				var funcArr = Func.split('|');
            	$.each(funcArr,function(idx,func){eval(func);});
	   		}else{
	   			if(ajaxTarget!='')
	   			{
	   				$(ajaxTarget).html(data).fadeIn("slow");
	   			}
	   		}
			if(loadding == '' || loadding){
   				deleteLoading();
   			}
		}
	});
}
var loadAjaxPost = function(Url,Target,PostData,Func,loadding)
{
	var ajaxTarget = (Target == '#')?'#content':Target;
	if(loadding == '' || loadding){
		ajaxLoading();
	}
	$.ajax({
		url : Url+"/layout/ajax",
		async : false,
		type: "POST",
		data:PostData,
		success: function(data){
			if(Target=="" && Func!=""){
				var funcArr = Func.split('|');
	        	$.each(funcArr,function(idx,func){eval(func);});
	   		}else{
	   			if(ajaxTarget!='')
	   			{
	   				$(ajaxTarget).html(data).fadeIn("slow");
	   			}
	   		}
			if(loadding == '' || loadding){
   				deleteLoading();
   			}
		}
	});
}

var loadPage = function(Url,Target,loadding)
{
	var ajaxTarget = (Target == '#')?'#content':Target;
	var targetRep = (Target != '#')?ajaxTarget.replace('#','_'):'';
	var page = $(Target +" #pagination .pg-number.current").text();
	var limit = getInput("perPage"+targetRep);
	var q = getInput("searchData"+targetRep);
	if(loadding == '' || loadding){
		ajaxLoading();
	}
	$.ajax({
		url : Url+"/layout/ajax/page/"+page+"/limit/"+limit+"/q/"+q,
		async : false,
		success: function(data){
			if(ajaxTarget!='')
			{
				$(ajaxTarget).html(data).fadeIn("slow");
			}
			if(loadding == '' || loadding){
				deleteLoading();
			}
		}
	});
}

var ajaxLoading = function(){
	
	$("body").append('<div id="info_loading"><img src="'+DIR_PUBLIC+'images/icons/loader.gif"><div>loading</div></div>');
	toCenter("#info_loading");
	$(window).scroll(function () {
		toCenter("#info_loading");
	});
}

var toCenter = function (target) {
	$(target).css("position","absolute");
	$(target).css("top", (($(window).height() - $(target).outerHeight()) / 2) + $(window).scrollTop() + "px");
	$(target).css("left", (($(window).width() - $(target).outerWidth()) / 2) + $(window).scrollLeft() + "px");
}


var deleteLoading = function()
{
	$("#info_loading").remove();
}
var getInput = function(obj_name){

	return $('#'+obj_name).val();
}
var getRadio = function(obj_name)
{
	return $('[name='+obj_name+']:checked').val();
}
var getCheckbox= function (obj_name)
{
	var checkboxs = new Array();
	var count=0;
	
	$("input#"+obj_name).each(function(){
		if(this.checked){
			checkboxs.push($(this).val());
			count++;
		}
	});
	
	if(count==0){
	// เมื่อ checkbox ไม่มีการติ๊กเลือกอะไรใน checkbox ทุกๆ เลยจะมีการคืนค่าเป็น -1 
		checkboxs=-1;
	}
	return checkboxs;
}
var getCheckboxOne= function (obj_name)
{
	var checkboxs = new Array();
	var count=0;
	
	$(obj_name).each(function(){
		if(this.checked){
			checkboxs.push($(this).val());
			count++;
		}
	});
	
	if(count==0){
	// เมื่อ checkbox ไม่มีการติ๊กเลือกอะไรใน checkbox ทุกๆ เลยจะมีการคืนค่าเป็น -1 
		checkboxs=-1;
	}
	return checkboxs;
}

var getCheckboxByName= function (obj_name)
{
	var checkboxs = new Array();
	var count=0;
	
	$("input[name="+obj_name+"]").each(function(){
		if(this.checked){
			checkboxs.push($(this).val());
			count++;
		}
	});
	
	if(count==0){
	// เมื่อ checkbox ไม่มีการติ๊กเลือกอะไรใน checkbox ทุกๆ เลยจะมีการคืนค่าเป็น -1 
		checkboxs=-1;
	}
	return checkboxs;
}
var checkEmail = function(mail)
{
	var reg_ex = /^([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]/
	if ( reg_ex.test(mail)){
		return true;
	}
	else{
		return false;
	}
}
var removeTarget = function(target)
{
	$(target).fadeOut('600', function() { $(target).remove(); });
}

var displayNotify = function(text,type,target,autohide)
{
	/*text = '<p>'+text+'</p>';
	$(target).empty();
	var notify = $("<div>").attr({'id':type});//,'class':'notification closable'});
	switch(type)
	{
		case 'success' :{
			notify.addClass('bar_success').html(text).appendTo(target);
			break;
		}
		case 'info' :{
			notify.addClass('nNote nInformation').html(text).appendTo(target);
			break;
		}
		case 'error' :{
			notify.addClass('nNote nFailure').html(text).appendTo(target);
			break;
		}
		case 'warning' :{
			notify.addClass('nNote nWarning').html(text).appendTo(target);
			break;
		}
	}
	if(autohide==''){
		$('<span>').attr({'class':'closelink','title':'Close'}).click(function(){
			$(this).parent().fadeOut('600', function() { $(this).remove(); });
		}).appendTo('.closable');
		$('html, body').animate({ scrollTop: 0 }, 'slow');
	}else{
		$(this).fadeOut('600', function() { $(this).remove(); });
	}*/
	//text = '<p>'+text+'</p>';
	$(target).empty();
	var notify = $("<div>").attr({'id':type});//,'class':'notification closable'});
	switch(type)
	{
		case 'success' :{
			notify.addClass('bar_success').html(text).appendTo(target);
			break;
		}
		case 'info' :{
			notify.addClass('nNote nInformation').html(text).appendTo(target);
			break;
		}
		case 'error' :{
			notify.addClass('nNote nFailure').html(text).appendTo(target);
			break;
		}
		case 'warning' :{
			notify.addClass('nNote nWarning').html(text).appendTo(target);
			break;
		}
	}
	$('html, body').animate({ scrollTop: 0 }, 'slow');
	$(target).slideDown().delay(2000).slideUp();
	/*if(autohide==''){
		$('<span>').attr({'class':'closelink','title':'Close'}).click(function(){
			$(this).parent().fadeOut('600', function() { $(this).remove(); });
		}).appendTo('.closable');
		$('html, body').animate({ scrollTop: 0 }, 'slow');
	}else{
		$(this).fadeOut('600', function() { $(this).remove(); });
	}*/
}

function myDialog(Url,width,height,title)
{
	var html = $.ajax({
		url : Url,
		async : false
	}).responseText;
	$.fancybox(html,
	{
		'autoDimensions'	: false,
		'width'         	: width,
		'height'        	: height,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'centerOnScroll'	: true,
		'padding' 			: 0,
		'overlayShow'		: false,
		'titlePosition' 	: 'top',
		'titleFormat'		: function() {
			return '<div class="alert">'+title+'</div><div class="line_x_white"></div>';
		}
	});
}

function myDialogPost(Url,data,width,height,title)
{
	var html = $.ajax({
		type	: "POST",
		url 	: Url,
		data	: data,
		async : false
	}).responseText;
	
	$.fancybox(html,
	{
		'autoDimensions'	: false,
		'width'         	: width,
		'height'        	: height,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'centerOnScroll'	: true,
		'padding' 			: 0,
		'overlayShow'		: true,
		'titlePosition' 	: 'top',
		'titleFormat'		: function() {
			return '<div class="alert">'+title+'</div><div class="line_x_white"></div>';
		}
	});
}

function myAlert(txt,width,height)
{
	var txt = "<div style='text-align:center;font-size: 16px;margin-top:12px;'>"+txt+"</div>";
	$.fancybox(txt,
	{
		'autoDimensions'	: false,
		'width'         	: width,
		'height'        	: height,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'padding' : 0,
		'overlayShow'	: false,
		'titlePosition' 	: 'top',
		'titleFormat'		: function() {
			return '<span></span>';
		}
	});
}

function myConfirm(txt,width,height,textBoxBtnOk,textBoxBtnCancel,func)
{
	var txt = "<div style='text-align:center;font-size: 14px;margin-top:12px;'>"+txt+"</div>";
	txt += '<div style="width:150px;margin : 18px auto 5px;"><button id="BoxConfirmBtnOk" class="btn_default" style="margin-right:6px;">'+textBoxBtnOk+'</button> <button id="BoxConfirmBtnCancel" class="btn_default">'+textBoxBtnCancel+'</button></div>';
	width = (width=='')?350:width;
	height = (height=='')?98:height;
	$.fancybox(txt,
	{
		'autoDimensions'	: false,
		'width'         	: width,
		'height'        	: height,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'padding' : 0,
		'overlayShow'	: false,
		'titlePosition' 	: 'top',
		'titleFormat'		: function() {
			return '<span></span>';
		}
	});
	$('#BoxConfirmBtnOk').bind('click', $.bind(this, function(){
		eval(func);
		$.fancybox.close();
	}));
	$('#BoxConfirmBtnCancel').bind('click', $.bind(this, function(){
		$.fancybox.close();
	}));
}

function chk_beforedelete(txt,func,textBoxBtnOk,textBoxBtnCancel,categories_id)
{
	$.post(DIR_ROOT+'product/backend/chk_hasdata',{'id':categories_id},function(data){
		if($.trim(data) == 'false'){ // ไม่มีสินค้าในหมวดหมู่นั้นแล้ว
			confirmDialog(txt,func,textBoxBtnOk,textBoxBtnCancel);
		}else{
			// ยังมีสินค้าอยู่ไม่สามารถลบหมวดหมู่นั้นได้
			customDialog('ยังมีสินค้าในหมวดหมู่นี้อยู่ ไม่สามารถลบได้',textBoxBtnOk);
		}
	});
}

function popup(url,name,windowWidth,windowHeight){
    myleft=(screen.width)?(screen.width-windowWidth)/2:100;
    mytop=(screen.height)?(screen.height-windowHeight)/2:100;
    properties = "width="+windowWidth+",height="+windowHeight;
    properties +=",scrollbars=no,status=no,toolbar=no,menubar=no,location=no, top="+mytop+",left="+myleft;     
    window.open(url,name,properties);
}
function clearForm(ele) {
    $(ele).find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });
}
function ismaxlength(obj){
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>mlength)
	obj.value=obj.value.substring(0,mlength)
}
function number_format (number, decimals, dec_point, thousands_sep) {
    
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *    example 10: number_format('1.20', 2);
    // *    returns 10: '1.20'
    // *    example 11: number_format('1.20', 4);
    // *    returns 11: '1.2000'
    // *    example 12: number_format('1.2000', 3);
    // *    returns 12: '1.200'
    // *    example 13: number_format('1 000,50', 2, '.', ' ');
    // *    returns 13: '100 050.00'
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
var pagination = function (target) {
	$(this).keypress(function(event){
		if(event.which == 13){
			var url = DIR_ROOT+getInput('targetpage')+"/page/"+getInput('thispage');
			if(target == ''){
				window.location = url;
			}else{
				loadAjax(url,target,'','');
			}
		}
	});
};

/* Cookie
/*----------------------------------------------------------------------*/
var getCookie = function(Name){
	var re=new RegExp(Name+"=[^;]+", "i") //construct RE to search for target name/value pair
	if (document.cookie.match(re)) //if cookie found
		return document.cookie.match(re)[0].split("=")[1] //return its value
	return null
};

var setCookie = function(name, value){
	document.cookie = name + "=" + value + "; path=/"
};

/*function number_format (number, decimals, dec_point, thousands_sep) {
	var exponent = '';
	var numberstr = number.toString ();
	var eindex = numberstr.indexOf ('e');
	if (eindex > -1) {
	  exponent = numberstr.substring (eindex);
	  number = parseFloat (numberstr.substring (0, eindex));
	}
	if (decimals != null) {
	  var temp = Math.pow (10, decimals);
	  number = Math.round (number * temp) / temp;
	}
	var sign = number < 0 ? '-' : '';
	var integer = (number > 0 ?
	Math.floor (number) : Math.abs (Math.ceil (number))).toString ();
	var fractional = number.toString ().substring (integer.length + sign.length);
	dec_point = dec_point != null ? dec_point : '.';
	fractional = decimals != null && decimals > 0 || fractional.length > 1 ? (dec_point + fractional.substring (1)) : '';
	if (decimals != null && decimals > 0) {
	  for (i = fractional.length - 1, z = decimals; i < z; ++i) {
		  fractional += '0';
	  }
	}
	thousands_sep = (thousands_sep != dec_point || fractional.length == 0) ? thousands_sep : null;
	if (thousands_sep != null && thousands_sep != '') {
	  for (i = integer.length - 3; i > 0; i -= 3){
		  integer = integer.substring (0 , i) + thousands_sep + integer.substring (i);
	  }
	}
	return sign + integer + fractional + exponent;
}*/
function number_format (number, decimals, dec_point, thousands_sep) {
	var exponent = '';
	var numberstr = number.toString ();
	var eindex = numberstr.indexOf ('e');
	if (eindex > -1) {
	  exponent = numberstr.substring (eindex);
	  number = parseFloat (numberstr.substring (0, eindex));
	}
	if (decimals != null) {
	  var temp = Math.pow (10, decimals);
	  number = Math.round (number * temp) / temp;
	}
	var sign = number < 0 ? '-' : '';
	var integer = (number > 0 ?
	Math.floor (number) : Math.abs (Math.ceil (number))).toString ();
	var fractional = number.toString ().substring (integer.length + sign.length);
	dec_point = dec_point != null ? dec_point : '.';
	fractional = decimals != null && decimals > 0 || fractional.length > 1 ? (dec_point + fractional.substring (1)) : '';
	if (decimals != null && decimals > 0) {
	  for (i = fractional.length - 1, z = decimals; i < z; ++i) {
		  fractional += '0';
	  }
	}
	thousands_sep = (thousands_sep != dec_point || fractional.length == 0) ? thousands_sep : null;
	if (thousands_sep != null && thousands_sep != '') {
	  for (i = integer.length - 3; i > 0; i -= 3){
		  integer = integer.substring (0 , i) + thousands_sep + integer.substring (i);
	  }
	}
	return sign + integer + fractional + exponent;
}
function cutNumberSeparate(price){
	if(price=='') return 0;
	else{
		Array_price = price.split(",");
		return Array_price.join('');
	}
}
function getDiscount(discount){
	dis_type=2;
	
	if(discount!=''){
		Array_discount=discount.split('');
		if(Array_discount[Array_discount.length-1]=='%'){
			discount=discount.replace("%","");
			dis_type=1;
		}
	}	
	return discount+'||'+dis_type;
}
function chkNumberInteger(e){
	// 8 = backspace
	// 45 = minus for notebook
	// 46 = delete
	
	if( e.which!=0 && e.which!=8 && e.which!=45 && e.which!=46 && (e.which<48 || e.which>57) )
		return false;
	return true;
}
function chkNumberOnly(e){
	// 8 = backspace
	// 46 = delete
	// 110 = decimal point (for pc)
	// 190 = period (for notebook)
	if( e.which!=0 && e.which!=8 && e.which!=46 && (e.which<48 || e.which>57) && e.which!=110 && e.which!=190 )
		return false;
	return true;
}
function chkNumberPercent(e){
	// 8 = backspace
	// 37 = percent
	// 46 = delete
	// 110 = decimal point (for pc)
	// 190 = period (for notebook)
	if(e.which<48 || e.which>57){
		if( e.which!=0 && e.which!=8 && e.which!= 37 && e.which!=46 && e.which!=110 && e.which!=190)
			return false;
	}
	return true;
}