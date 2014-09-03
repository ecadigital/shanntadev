/* Upload Plugin
/*----------------------------------------------------------------------*/	
$.fn.uploadfile = function (options) {
	$this = $(this);
	$.getJSON(DIR_PUBLIC+'tmp/update/ip.php', function(data){
		
		var ip = data.ip;
	    var opts = $.extend({'id':$this.attr('id')}, $.fn.uploadfile.defaults, options);
	    if(opts.multi){
	        $this.uploadify({
	        	'buttonText' : opts.buttonText,
	        	'swf'      : DIR_PUBLIC+'images/swf/uploadify.swf',
	            'uploader' : DIR_ROOT+opts.module+'/backend/upload_images/check_login/ignor',
	            'removeCompleted' : opts.removeCompleted,
	            'fileTypeExts' : opts.fileTypeExts,
	            'multi' : opts.multi,
	            'onInit' : function(file, data, response) {
	            	$('#UploadQueue li.queue').each(function(){
	                	var src = $(this).text();
	                	var file_id = $(this).attr('id');
	                	var product_image_id = $(this).attr('data-itemid');
	            		var img = '<div class="wrap-imag"><img src="'+DIR_ROOT+src+'" /></div>';
	            		var link ='<a href="javascript:$(\'#'+opts.id+'\').uploadify(\'cancel\', \''+file_id+'\')"></a>';
	            		var tmp_queue ='<input type="hidden" id="'+opts.id+'_'+file_id+'" name="'+opts.id+'['+file_id+']" value="'+product_image_id+'">';
	    	        	$("#"+opts.id+"-queue").append('<div class="uploadify-queue-item" id="'+file_id+'"><div class="cancel edit">'+link+'</div>'+img+tmp_queue+'</div>');
	    	        	$(".wrap-imag").fadeIn(900);
	        		});
	    	    },
	            'onUploadSuccess' : function(file, data, response) {
	            	var obj = $("#"+file.id);
	            	var src = $.trim(data);
	            	var img = '<div class="wrap-imag"><img src="'+DIR_PUBLIC+'upload/'+opts.module+'/temp/'+ip+'/'+src+'" /></div>';
	            	obj.find(".data").hide().end().append(img);
	            	$(".wrap-imag").fadeIn(900,function(){
	            		$('.uploadify-progress').css({display:'none'});
	            	});
	            	obj.append('<input type="hidden" id="'+opts.id+'_'+file.id+'" name="'+opts.id+'['+file.id+']" value="'+src+'">');
	    	    }
	        });
	        $(".uploadify-queue .cancel").live('click',function(){
	            var id = $(this).parent().attr('id');
	            if($(this).hasClass('edit')){
	                var src = $("#UploadQueue li#"+id).attr('data-itemid');
	                $("#UploadQueue li#"+id).remove();
	                $("#"+opts.id+"-queue").append('<input type="hidden" id="FileCancel_'+id+'" name="FileCancel[]" value="'+src+'">');
	            }else{
	            	$("#"+opts.id+"_"+id).remove();
	            }
	        });
	        /*  SORT IMAGES
	    	----------------------------------------------------------------------------------------------- */
	    	$( "#"+opts.id+"-queue").sortable({
	    		cursor: 'move',
	    		tolerance: 'pointer',
	    		placeholder: 'placeholder'
	    	});
	    }else{
	    	$this.uploadify({
	        	'buttonText' : opts.buttonText,
	            'uploader' : DIR_ROOT+opts.module+'/backend/upload_images/check_login/ignor',
	            'removeCompleted' : opts.removeCompleted,
	            'fileTypeExts' : opts.fileTypeExts,
	            'multi' : opts.multi,
	            'onInit' : function(file, data, response) {
	            	$('#UploadQueueSingle li.queue').each(function(){
	                	var src = $(this).text();
	                	var file_id = $(this).attr('id');
	                	var product_image_id = $(this).attr('data-itemid');
	            		var img = '<div class="wrap-imag"><img src="'+DIR_ROOT+src+'" /></div>';
	            		var link ='<a href="javascript:$(\'#'+opts.id+'\').uploadify(\'cancel\', \''+file_id+'\')"></a>';
	            		var tmp_queue ='<input type="hidden" id="'+opts.id+'_'+file_id+'" name="'+opts.id+'['+file_id+']" value="'+product_image_id+'">';
	    	        	$("#"+opts.id+"-queue").append('<div class="uploadify-queue-item" id="'+file_id+'"><div class="cancel edit">'+link+'</div>'+img+tmp_queue+'</div>');
	    	        	$(".wrap-imag").fadeIn(900);
	    	        	tmp_id = file_id;
	    	        	editSingle = true;
	        		});
	    	    },
	    	    'onUploadStart' : function(){
	    	    	if(tmp_id != '' && typeof tmp_id !='undefined'){
	            		$("#"+tmp_id).remove();
	            		if(editSingle){
	            			var src = $("#UploadQueueSingle li#"+tmp_id).attr('data-itemid');
	            			$("#"+opts.id+"-queue").append('<input type="hidden" id="FileSingleCancel_'+tmp_id+'" name="FileSingleCancel[]" value="'+src+'">');
	            			editSingle = false;
	            		}
	            	}
	    	    },
	            'onUploadSuccess' : function(file, data, response) {
	    	    	
	            	var obj = $("#"+file.id);
	            	var src = $.trim(data);
	            	var img = '<div class="wrap-imag"><img src="'+DIR_PUBLIC+'upload/'+opts.module+'/temp/'+ip+'/'+src+'" /></div>';
	            	obj.find(".data").hide().end().append(img);
	            	$(".wrap-imag").fadeIn(900);
	            	obj.append('<input type="hidden" id="'+opts.id+'_'+file.id+'" name="'+opts.id+'['+file.id+']" value="'+src+'">');
	            	tmp_id = file.id;
	    	    }
	        });
	    	$("#map_upload-queue .cancel").live('click',function(){
	            var id = $(this).parent().attr('id');
	            if($(this).hasClass('edit')){
	                var src = $("#UploadQueueSingle li#"+id).attr('data-itemid');
	                $("#UploadQueueSingle li#"+id).remove();
	                $("#"+opts.id+"-queue").append('<input type="hidden" id="FileSingleCancel_'+id+'" name="FileSingleCancel[]" value="'+src+'">');
	            }else{
	            	$("#"+opts.id+"_"+id).remove();
	            }
	        });
	    }
	});
};
var tmp_id;
var editSingle;
$.fn.uploadfile.defaults = {
	buttonText : 'Choose Image',
	removeCompleted : false,
	fileTypeExts : '*.gif; *.jpg; *.png',
	module : 'product',
	multi : true,
};
/* End Upload Plugin
/*----------------------------------------------------------------------*/

/* Only Num Plugin
/*----------------------------------------------------------------------*/

$.fn.onlynum = function () {
	
	$(this).keypress(function(event){
		if(event.which && (event.which < 48 || event.which >57) && event.which != 8 && event.which != 46 ){
			event.preventDefault();
		}
	});
};

/* Next Focus
/*----------------------------------------------------------------------*/

$.fn.nextfocus = function () {
	var focusables = $(this).find(':focusable');
    focusables.keyup(function(e) {
        var maxchar = false;
        if ($(this).attr("maxlength")) {
            if ($(this).val().length >= $(this).attr("maxlength"))
                maxchar = true;
            }
        if (e.keyCode == 13 || maxchar) {
            var current = focusables.index(this),
                next = focusables.eq(current+1).length ? focusables.eq(current+1) : focusables.eq(0);
                next.focus();
        }
    });
};