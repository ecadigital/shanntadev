$(document).ready(function(){
	
	$("#product_id").change(function(){	
		addCartList();
	});	
});


function addCartList(){
	//var numi = $('#numList');
	//var num = parseInt($('#numList').val()) + parseInt(1);
	//$('#numList').val(num);
	var chkID=1;

	id=$('#product_id').val().toLowerCase();
	
	numList=$('#numList').val();
	if(numList>0){
		for(no=1;no<=numList;no++){
			if($('#id_'+no).val()||$('#id_'+no)==null){
				oldID=$('#id_'+no).val().toLowerCase();
				if(oldID==id&&chkID==1){
					alert("สินค้าซ้ำค่ะ");
					$('#product_id').val('');
					$('#product_id').focus();
					$('#amount_'+no).focus();
					chkID=0;
				}
			}
		}
	}
		
	if(chkID==1){
		$.ajax({ 
			url:  DIR_ROOT+'shoppingcart/backend/showAjax/val/addList/id/'+id+'/num/'+numList, 
			success: function(response){
				if(response=='0'){
					alert("กรุณาเลือกสินค้าใหม่ค่ะ");
					$('#product_id').focus();
				}
				else{
					$('#product_id').val('');
					$('#product_id').focus();
					
					num = parseInt($('#numList').val()) + parseInt(1);
					$('#numList').val(num);
					
					// create new row list
					var ni = document.getElementById('boxAdd');
					var newdiv = document.createElement('tr');
					var divIdName = 'rowList_'+num;
					newdiv.setAttribute('id',divIdName);
					
					newdiv.innerHTML = response;
					ni.appendChild(newdiv);
					
					var listorder=$("#listorder").val();
					$("#listorder").val(listorder+divIdName+'|');
		
					sumList(num);
				}
			}
		});
	}
}
// คำนวณตอนกรอกข้อมูลแต่ละ id //
function sumList(id){
	//discount=0;
	//dis_type=2;
	
	if($('#amount_'+id).length > 0){
		// amount //
		amount = ( $('#amount_'+id).val() == '' ) ? 0 : $('#amount_'+id).val();
		$('#amount_'+id).val( number_format(amount,0,'','' ) );
		
		if($('#price_'+id).length > 0){
			price = ( $('#price_'+id).val() == '' ) ? 0 : $('#price_'+id).val();
			$('#price_'+id).val( price );
		}
		if($('#point_'+id).length > 0){
			point = ( $('#point_'+id).val() == '' ) ? 0 : $('#point_'+id).val();
			$('#point_'+id).val( point );
		}
		
	}/*
	if($('#point_'+id).length > 0){
		// dis //
		dis = ( $('#discount_'+id).val() == '' ) ? 0 : $('#discount_'+id).val();
		$('#discount_'+id).val( dis );
		
		txtDis=$('#discount_'+id).val();
		Arrar_dis=getDiscount(txtDis).split('|');
		discount=Arrar_dis[0];
		dis_type=Arrar_dis[1];
	}*/
	// คำนวณราคาแต่ละ id //
	sumEach(id);
	// ผลรวมท้ายตาราง //
	sumAll();
}

// คำนวณราคาแต่ละ id //
function sumEach(id){
	if($('#amount_'+id).length > 0){
		amount=$('#amount_'+id).val();
		// price //
		price=0;
		if($('#price_'+id).length > 0){
			price = ( $('#price_'+id).val() == '' ) ? 0 : $('#price_'+id).val();
		}
		eachPrice=(amount*price);
		// point //
		point=0;
		if($('#point_'+id).length > 0){
			point = ( $('#point_'+id).val() == '' ) ? 0 : $('#point_'+id).val();
		}
		eachPoint=(amount*point);
		
		$('#boxEachPrice_'+id).html(number_format(eachPrice,2,'.',','));
		$('#boxEachPoint_'+id).html(number_format(eachPoint,0,'.',','));
		$('#eachPrice_'+id).val(eachPrice);
		$('#eachPoint_'+id).val(eachPoint);
	}
}

// ผลรวมท้ายตาราง //
function sumAll(){
	num=$('#numList').val();
	if(num>0){
	
		amount=0;
		sum=0;
		point=0;
		total=0;
				
		for(id=1;id<=num;id++){
			if($('#amount_'+id).length > 0){
				amount=parseFloat(amount)+parseFloat($('#amount_'+id).val());
				sum=parseFloat(sum)+parseFloat($('#eachPrice_'+id).val());
				point=parseFloat(point)+parseFloat($('#eachPoint_'+id).val());
			}
		}

		$('#boxSumAmount').html(number_format(amount,0,'.',','));
		if($('#boxSubPrice').length > 0){
			$('#boxSubPrice').html(number_format(sum,2,'.',','));
		}
		
		// sum price //
		total = sum;
		if($('#discount').length > 0){
			txtDisext=$('#discount').val();
				
			Array_disext=getDiscount(txtDisext).split('|');
			disext=Array_disext[0];
			disext_type=Array_disext[1];
			
			
			if(disext_type=='1'){
				total=sum*((100-disext)/100);
			}
			else if(disext_type=='2'){
				total=sum-disext;
			}
		}
		//total=sum_dis;
		$('#boxSumPrice').html(number_format(total,2,'.',','));
		
		// sum point //
		if($('#boxSubPoint').length > 0){
			$('#boxSubPoint').html(number_format(point,0,'.',','));
		}
		if($('#point').length > 0){
			lastpoint = ($('#point').val()=='') ? 0 : $('#point').val();
			point = parseFloat(point)+parseFloat(lastpoint);
		}
		$('#boxSumPoint').html(number_format(point,0,'.',','));

		
	}
	chkListNumber();
}

// add list //
function getDiscount(discount){
	dis_type=2;
	
	if(discount!=''){
		Array_discount=discount.split('');
		if(Array_discount[Array_discount.length-1]=='%'){
			discount=discount.replace("%","");
			dis_type=1;
		}
	}
	return discount+'|'+dis_type;
}

// จัดลำดับรายการ //
function chkListNumber(){
	Array_order=$('#listorder').val().split('|');
	numOrder=Array_order.length;
	
	if(numOrder>0){
		no=1;
		for(i=0;i<numOrder;i++){
			if(Array_order[i]!=''&&Array_order[i]!='undefined'){
				Array_id=Array_order[i].split('_');
				if($('#boxId_'+Array_id[1]).length>0){
					$('#boxId_'+Array_id[1]).html( no );
					no=parseInt(no)+parseInt(1);
				}
			}
		}
	}
}

// ลบข้อมูลลิสต์รายการ //
function delList(no){
	if(confirm("ยืนยันการลบข้อมูล")){
		$('#rowList_'+no).fadeOut(500);
		$('#rowList_'+no).remove();
		sumAll();
	}
}

