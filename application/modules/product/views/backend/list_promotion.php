<?php $pagination = true;
$this->model = $this->load->model('product/Productmodel');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th align="center" width="7%"><?php echo lang('web_image');?></th>
			<th><?php echo lang('product_promotion');?></th>
			<th width="20%" align="center"><?php echo lang('web_categories');?></th>
			<th width="15%" align="center"><?php echo lang('product_update');?></th>
            <th align="center" width="180"><?php echo lang('web_tool');?></th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
	if(!empty($listPromotion)){
		$no=($page-1)*$limit;
		foreach($listPromotion as $list){
			$product_promotion_id = $list["product_promotion_id"];
			$product_id = $list["product_id"];
			$img_db = $this->model->getFirstProductImage($product_id);
			$img_path = DIR_PUBLIC."images/noimage.png";
			if($img_db!=''){
				$path = "public/upload/product/thumbnails/".basename($img_db);
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
				<a href="<?php echo DIR_ROOT?>product/backend/edit_promotion/id/<?php echo $product_promotion_id;?>" class="bluesky" target="_blank"><strong><?php echo $list['product_promotion_name'];?></strong></a>
				<div><a href="<?php echo DIR_ROOT?>product/backend/edit_product/id/<?php echo $product_id;?>" class="bluesky" target="_blank"><?php echo $list['product_name']?></a></div>
			</td>
			<td align="center"><?php echo $list['product_categories_name']?></td>
            <td align="center"><?php echo $this->bflibs->timeString($list['product_promotion_last_modified']);?></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("pin",$module,array('id'=>$product_promotion_id,'status'=>$list['product_promotion_pin']),'pin_promotion','','list_promotion',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$product_promotion_id,'status'=>$list['product_promotion_publish']),'publish_promotion','','list_promotion',$target,$pagination);?>
				<?php echo $this->bflibs->web_tool("up",$module,array('id'=>$product_promotion_id,'seq'=>$list['product_promotion_seq']),'up_promotion',$param,'list_promotion',$target);?>
				<?php echo $this->bflibs->web_tool("down",$module,array('id'=>$product_promotion_id,'seq'=>$list['product_promotion_seq']),'down_promotion',$param,'list_promotion',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$product_promotion_id),'edit_promotion');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$product_promotion_id),'delete_promotion',$param,'list_promotion',$target);?>
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="6" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>
<div class="clearfix"></div>
<?php echo $page_description.$paginaion;?>