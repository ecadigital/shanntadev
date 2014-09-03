<?php $pagination = true;
$this->model = $this->load->model('collection/Collectionmodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="7%"><?php echo lang('web_image');?></th>
			<th>ชื่อคอลเลคชั่น</th>
			<th width="15%" align="center">หมวดหมู่คอลเลคชั่น</th>
			<th width="10%" align="center">ราคา</th>
			<th width="15%" align="center"><?php echo lang('collection_update');?></th>
            <th align="center" width="170"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listCollection)){
		$no=($page-1)*$limit;
		foreach($listCollection as $list){
			$collection_id = $list["collection_id"];
			$img_db = $this->model->getFirstCollectionImage($collection_id);
			$img_path = DIR_PUBLIC."images/noimage.png";
			if($img_db!=''){
				$path = "public/upload/collection/thumbnails/".basename($img_db);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path = DIR_ROOT.$path;
				}
			}
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td align="center">
				<img src="<?php echo $img_path?>" style="max-width:150px;" />
			</td>
			<td>
				<a href="<?php echo DIR_ROOT?>collection/backend/edit_collection/id/<?php echo $collection_id;?>" class="bluesky" target="_blank"><strong><?php echo $list['collection_name'];?></strong></a>
				<div><i><?php echo nl2br($list['collection_detail']);?></i></div>
			</td>
			<td align="center">
				<?php echo $list['collection_categories_name']?>
			</td>
			<td align="right">
				<?php 
				if($list['collection_discount']==''||$list['collection_discount']==0||$list['collection_discount']=='0%'){
					echo number_format($list['collection_price']);
				}else{
					echo '
					<div style="height:15px;"><div style="float:left; font-weight:bold;"><i>ราคาเดิม</i></div></div>
					<div style="height:15px;"><div style="float:right; text-decoration:line-through;"><i>'.number_format($list['collection_price']).'</i></div></div>
					<div style="height:15px;"><div style="float:left; font-weight:bold;"><i>ส่วนลด</i></div></div>
					<div style="height:15px;"><div style="float:right;"><i>'.$list['collection_discount'].'</i></div></div>
					<div style="height:15px;"><div style="float:left; font-weight:bold;">ราคาสุทธิ</div></div>
					<div style="height:15px;"><div style="float:right;">'.number_format($list['collection_newprice']).'</div></div>';
				}
				?>
			</td>
            <td align="center"><?php echo $this->bflibs->timeString($list['collection_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("rec",$module,array('id'=>$collection_id,'status'=>$list['collection_rec']),'rec_collection','','list_collection',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("hot",$module,array('id'=>$collection_id,'status'=>$list['collection_hot']),'hot_collection','','list_collection',$target,$pagination);?>
				<?php //echo $this->bflibs->web_tool("pro",$module,array('id'=>$collection_id,'status'=>$list['collection_pro']),'pro_collection','','list_collection',$target,$pagination);?>
				<?php //echo $this->bflibs->web_tool("sale",$module,array('id'=>$collection_id,'status'=>$list['collection_sale']),'sale_collection','','list_collection',$target,$pagination);?>
                <!--<div style="padding-top:20px;">-->
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$list['collection_id'],'seq'=>$list['collection_seq']),'up_collection',$param,'list_collection/type/'.$type,$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$list['collection_id'],'seq'=>$list['collection_seq']),'down_collection',$param,'list_collection/type/'.$type,$target);?>
				<?php //echo $this->bflibs->web_tool("pin",$module,array('id'=>$collection_id,'status'=>$list['collection_pin']),'pin_collection','','list_collection',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$collection_id,'status'=>$list['collection_publish']),'publish_collection','','list_collection',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$collection_id),'edit_collection');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$collection_id),'delete_collection',$param,'list_collection',$target);?>
				<!--</div>-->
				
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="7" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php if(!empty($listCollection)) echo $page_description.$paginaion;?>