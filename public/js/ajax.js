jQuery().ready(function(){
	/* Table 
	/*----------------------------------------------------------------------*/
	$('.table_content tr,.table_content tbody tr').hover(function(){
		$(this).addClass('tb_hover');
	},function(){
		$(this).removeClass('tb_hover');
	});
});