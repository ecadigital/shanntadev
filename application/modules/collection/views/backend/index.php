<h3>รายการคอลเลคชั่น</h3>
<div>
	<a href="<?php echo DIR_ROOT?>admin/admin/index">หน้าแรก</a>&nbsp;&nbsp;>&nbsp;&nbsp;
	รายการคอลเลคชั่น
    
    <div style="float:right;">
		<a href="<?php echo DIR_ROOT?>collection/backend/add_collection"><input type="submit" class="button_gray" value="เพิ่มข้อมูลคอลเลคชั่น" /></a>
    </div>
</div>
<div class="clearfix formRow" style="margin-top:10px;">
	<?php 
		$targetRep = ($target != '' && $target != '#content')?str_replace('#','_',$target):"";
        echo $this->bflibs->mkSelect('perPage','#boxContent',$targetpage,$perPage);
        //echo $this->bflibs->mkSelect('collectionType','#boxContent',$targetpage,$perPage);
	?>
        <p style="float:left;line-height: 2.2; margin-left:30px;"><strong>หมวดหมู่คอลเลคชั่น</strong>&nbsp;
            <select name="cat<?php echo $targetRep;?>" id="cat<?php echo $targetRep;?>" style="width:200px;" onchange="window.location='<?php echo DIR_ROOT.$thispage;?>/q/'+$('#searchData_boxContent').val()+'/limit/'+$('#perPage_boxContent').val()+'/page/1/type/'+$('#type_boxContent').val()+'/cat/'+$('#cat_boxContent').val()">
				<option value="" <?php if($cat=='') echo 'selected="selected"';?>>หมวดหมู่คอลเลคชั่นทั้งหมด</option>
				<?php 							
				if(!empty($listCategories)){
					foreach($listCategories as $list){
						echo '<option value="'.$list['collection_categories_id'].'" '; if($cat==$list['collection_categories_id']) echo 'selected="selected"'; echo '>'.$list['collection_categories_name'].'</option>';
					}
				}
				?>
            </select>
        &nbsp;</p>
		
        <p style="float:left;line-height: 2.2; margin-left:30px;"><strong>ประเภทคอลเลคชั่น </strong> &nbsp;
            <select name="type<?php echo $targetRep;?>" id="type<?php echo $targetRep;?>" style="width:200px;" onchange="window.location='<?php echo DIR_ROOT.$thispage;?>/q/'+$('#searchData_boxContent').val()+'/limit/'+$('#perPage_boxContent').val()+'/page/1/type/'+$('#type_boxContent').val()+'/cat/'+$('#cat_boxContent').val()">
				<option value="" 		<?php if($type=='') 	echo 'selected="selected"';?>>คอลเลคชั่นทั้งหมด</option>
				<option value="-" 		<?php if($type=='-') 	echo 'selected="selected"';?>>คอลเลคชั่นมาใหม่</option>
				<option value="hot" 	<?php if($type=='hot') 	echo 'selected="selected"';?>>คอลเลคชั่นยอดนิยม</option>
				<option value="rec" 	<?php if($type=='rec') 	echo 'selected="selected"';?>>คอลเลคชั่นแนะนำ</option>
				<!--<option value="pro" 	<?php if($type=='pro') 	echo 'selected="selected"';?>>คอลเลคชั่นโปรโมชั่น</option>-->
				<option value="sale" 	<?php if($type=='sale') echo 'selected="selected"';?>>คอลเลคชั่นลดราคา</option>
            </select>
        &nbsp;</p>
    <p style="float:right;">ค้นหา : <input type="text" onchange="window.location='<?php echo DIR_ROOT.$thispage;?>/q/'+$('#searchData_boxContent').val()+'/limit/'+$('#perPage_boxContent').val()+'/page/1/type/'+$('#type_boxContent').val()+'/cat/'+$('#cat_boxContent').val()" style="width:200px;" name="searchData_boxContent" id="searchData_boxContent"></p>
</div>
<div class="clear"></div>
<div id="boxContent"></div>

<script>
$(document).ready(function (){
	//loadAjax('<?php echo DIR_ROOT.$targetpage?>','#boxContent','');
	loadPage('<?php echo DIR_ROOT.$targetpage?>/type/<?php echo $type;?>/cat/<?php echo $cat;?>','#boxContent','');
});
</script>