<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data"> 
	<thead> 
		<tr> 
			<th align="center" width="50"><?php echo lang('web_no');?></th>
			<th>ชื่อหมวดหมู่สินค้า</th>
			<th>รูปแบนเนอร์หน้าแรก</th>
			<th>รูปแบนเนอร์หน้าสินค้า</th>
            <th align="center" width="150"><?php echo lang('web_tool');?></th>
		</tr> 
	</thead>
	<tbody>
	<?php if(!empty($listCategories)){
		$no = 0;
		foreach($listCategories as $list){
			$product_categories_id = $list["product_categories_id"];
			$img_db_home = $list["product_categories_home_path"];
			$img_path_home = DIR_PUBLIC."images/noimage.png";
			if($img_db_home!=''){
				$path = "public/upload/product/thumbnails/".basename($img_db_home);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path_home = DIR_ROOT.$path;
				}
			}
			$img_db_banner = $list["product_categories_banner_path"];
			$img_path_banner = DIR_PUBLIC."images/noimage.png";
			if($img_db_banner!=''){
				$path = "public/upload/product/thumbnails/".basename($img_db_banner);
				$dir_file = DIR_FILE.$path;
				if(file_exists($dir_file)){
					$img_path_banner = DIR_ROOT.$path;
				}
			}
			?>
		<tr>
			<td align="center"><?php echo ++$no;?></td>
			<td>
				<a href="<?php echo DIR_ROOT?>product/backend/edit_categories/id/<?php echo $product_categories_id;?>"><?php echo $list['product_categories_name']?></a>
			</td>
			<td align="center"><img src="<?php echo $img_path_home?>" style="max-width:300px;" /></td>
			<td align="center"><img src="<?php echo $img_path_banner?>" style="max-width:300px;" /></td>
			<td align="center">
				<?php echo $this->bflibs->web_tool("publish",$module,array('id'=>$product_categories_id,'status'=>$list['product_categories_publish']),'publish_categories',$param,'list_categories',$target);?>
				<?php echo $this->bflibs->web_tool("up_parent",$module,array('id'=>$product_categories_id,'seq'=>$list['product_categories_seq'],'parent_id'=>$list['product_categories_parent_id']),'up_categories',$param,'list_categories',$target);?>
				<?php echo $this->bflibs->web_tool("down_parent",$module,array('id'=>$product_categories_id,'seq'=>$list['product_categories_seq'],'parent_id'=>$list['product_categories_parent_id']),'down_categories',$param,'list_categories',$target);?>
				<?php echo $this->bflibs->web_tool("edit",$module,array('id'=>$product_categories_id),'edit_categories');?>
				<?php echo $this->bflibs->web_tool("delete",$module,array('id'=>$product_categories_id),'delete_categories',$param,'list_categories',$target);?>
			</td>
		</tr>
		<?php }}else{?>
		<tr><td colspan="5" align="center"><?php echo lang('web_no_data');?></td></tr>
		<?php }?>
	</tbody>
</table>