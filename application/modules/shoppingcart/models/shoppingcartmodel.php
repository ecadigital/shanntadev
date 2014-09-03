<?php
class Shoppingcartmodel extends CI_Model {
	private $tbl_admin_cfg = 'admin_cfg';
	private $tbl_product = 'product';
	private $tbl_product_images = 'product_images';
	private $tbl_product_categories = 'product_categories';
	private $tbl_product_promotion = 'product_promotion';
	private $tbl_member = 'member';
	
	private $tbl_sp_order = 'sp_order';
	private $tbl_sp_order_item = 'sp_order_item';
	private $tbl_sp_order_status = 'sp_order_status';
	private $tbl_sp_order_bank = 'sp_order_bank';
	private $tbl_sp_order_confirm = 'sp_order_confirm';
	
	private $listCategoriesParent=array();
	private $listCategories=array();
	private $member;
	private $defaultlang;
	//public $param;
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
	
	public function __construct(){
	
        parent::__construct();
        $admin = $this->session->userdata('admin');
		$this->member= $this->session->userdata('member');
		@$this->admin_id = $admin->admin_id;
		$this->ip = $this->bflibs->getIP();
		$this->defaultlang = $this->bflibs->getDefaultLangId();
	}
	

	/*  PRODUCT
	-------------------------------------------------------------------------------------------------------*/
	public function listAllProduct()
	{
		$query = $this->db->select(array("product_id","product_name","product_price","product_point"))
				->from($this->tbl_product)
				->where("product_publish", '1')
				->order_by("product_pin","desc")
				->order_by("product_name","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function getProduct($id)
	{
		$query = $this->db->select(array("product_id","product_name","product_price","product_point"))
				->from($this->tbl_product)
				->where("product_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}

	/*  MEMBER
	-------------------------------------------------------------------------------------------------------*/
	public function listAllMember()
	{
		$query = $this->db->select(array("member_id","member_first_name","member_last_name"))
				->from($this->tbl_member)
				->where("member_publish", '1')
				->order_by("member_first_name","asc")
				->order_by("member_last_name","asc");
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	/*  ORDER
	-------------------------------------------------------------------------------------------------------*/	
	public function listOrder($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select(array("$this->tbl_sp_order.order_id","$this->tbl_sp_order.order_summary","$this->tbl_sp_order.order_point_summary","$this->tbl_sp_order.order_date","$this->tbl_sp_order.order_read","$this->tbl_member.member_first_name","$this->tbl_member.member_last_name","$this->tbl_sp_order.order_status_id","$this->tbl_sp_order.order_tracking","$this->tbl_sp_order.order_discount","$this->tbl_sp_order.order_payment"))
				->from($this->tbl_sp_order)
				->join($this->tbl_member,"$this->tbl_member.member_id=$this->tbl_sp_order.member_id","left")
				->order_by("$this->tbl_sp_order.order_date_added",'desc');
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "(($this->tbl_member.member_first_name like '%".$sData."%') or ($this->tbl_member.member_last_name like '%".$sData."%'))";
			$this->db->where($where);
		}

		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#boxContent';
		$config['limit'] = $limit;
		$config['page'] = $page;
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->select_pagination();
	}
	public function listEditOrder($id){
		
		$select = $this->db->select()
				->from($this->tbl_sp_order)
				->join($this->tbl_member,"$this->tbl_member.member_id=$this->tbl_sp_order.member_id","left")
				->where("order_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(!empty($result)){
			$select = $this->db	->select()
										->from($this->tbl_sp_order_item)
										->where("order_id",$id);
			$query_item = $this->db->get();
			$result['order_item'] = $query_item->result_array();
		}
		return $result;
	}
	public function addOrder(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$numList = $val['numList'];
			
			$order_id = $this->bflibs->getLastID($this->tbl_sp_order,'order_id');
			$date = date('Y-m-d H:i:s');
			$order_summary=0;
			$point_summary=0;
			
			for($i=1;$i<=$numList;$i++){
				if(isset($val['id_'.$i])){
					$order_summary += $val['eachPrice_'.$i];
					$point_summary += $val['eachPoint_'.$i];
					$data_item = array(
								"order_id"=>$order_id,
								"product_id"=>$val['id_'.$i],
								"product_name"=>$val['name_'.$i],
								"order_qty"=>$val['amount_'.$i],
								"order_price"=>$val['price_'.$i],
								"order_discount"=>0,
								"order_point"=>$val['point_'.$i],
								"order_status"=>1
					);			
					$this->db->insert($this->tbl_sp_order_item,$data_item);
				}
			}
			
			//list($discount,$dis_type) = $this->getDiscount($val['discount']);
			//$order_summary = ($dis_type==1) ? $order_summary*(100-$val['discount'])/100 : $order_summary-$val['discount'];
			//$point_summary += $val['point'];
			
			$data = array(
					"order_id"=>$order_id,
					"member_id"=>$val['member_id'],
					"order_discount"=>'',//$val['discount'],
					"order_summary"=>$order_summary,
					"order_point"=>'',//$val['point'],
					"order_point_summary"=>$point_summary,
					"order_date"=>$this->bflibs->dateToDb($val['sp_date'],'date'),
					"order_date_added"=>$date,
					"order_last_update"=>$date,
					"order_status_id"=>1,
					"order_read"=>1
			);
			$this->db->insert($this->tbl_sp_order,$data);
			
			// add point //
			$member_id=$val['member_id'];
			$old_point = $this->bflibs->getMemberPoint($member_id);
			$new_point = $old_point+$point_summary;
			$this->bflibs->updateMemberPoint($member_id,$new_point);			
						
			return $order_id;
		}
	}
	
	public function deleteOrder($id){
		
		$select = $this->db->select(array('member_id','order_point_summary'))
				->from($this->tbl_sp_order)
				->where("order_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		if(!empty($result)){
			$member_id=$result['member_id'];
			$old_point = $this->bflibs->getMemberPoint($member_id);
			// ลบออกจากฐานข้อมูล //
			$new_point = $old_point-$result['order_point_summary'];
			$this->bflibs->updateMemberPoint($member_id,$new_point);
		}
		
		$this->db->where('order_id',$id);
		$this->db->delete($this->tbl_sp_order);
		$this->db->where('order_id',$id);
		$this->db->delete($this->tbl_sp_order_item);
	}
	public function change_status($order_id,$order_status){
		
		$date = date('Y-m-d H:i:s');
		$data = array(
				"order_status_id"=>$order_status/*,
				"order_status_update"=>$date*/
			);
		$this->db->where("order_id",$order_id);
		//$this->db->where("product_id",$product_id);
		
		$this->db->update($this->tbl_sp_order,$data);
	}
	public function change_tracking($order_id,$order_tracking){
		
		$date = date('Y-m-d H:i:s');
		$data = array(
				"order_tracking"=>$order_tracking/*,
				"order_status_update"=>$date*/
			);
		$this->db->where("order_id",$order_id);
		//$this->db->where("product_id",$product_id);
		
		$this->db->update($this->tbl_sp_order,$data);
	}
	public function getOrderConfirm($order_id){
	
		$query = $this->db->select()
				->from($this->tbl_sp_order_confirm)
				->where("order_id",$order_id);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	

	//###################################################
	public function rowList($num,$id,$name,$amount,$price,$point){
		$no = $num;
		$sumList = 'sumList(\''.$num.'\')';
		$delList = 'delList(\''.$num.'\')';
		$sumPrice = $amount*$price;
		$sumPoint = $amount*$point;
		
		$txt='<td align="center"><div id="boxId_'.$num.'">'.$no.'</div>
					<input type="hidden" id="id_'.$num.'" name="id_'.$num.'" value="'.$id.'" />
					<input type="hidden" id="eachPrice_'.$num.'" name="eachPrice_'.$num.'" value="'.$sumPrice.'" />
					<input type="hidden" id="eachPoint_'.$num.'" name="eachPoint_'.$num.'" value="'.$sumPoint.'" />
				</td>
				<td><input type="text" id="name_'.$num.'" name="name_'.$num.'" value="'.$name.'" style="width:90%;" /></td>
				<td align="right"><input id="amount_'.$num.'" name="amount_'.$num.'" value="'.$amount.'" onkeyup="'.$sumList.'" onkeypress="return chkNumberInteger(event)" size="5" style="text-align:right;" /></td>
				<td align="right"><input id="price_'.$num.'" name="price_'.$num.'" value="'.number_format($price,2).'" onkeyup="'.$sumList.'" onkeypress="return chkNumberOnly(event)" size="10" style="text-align:right;" /></td>
				<td id="boxEachPrice_'.$num.'" align="right">'.number_format($sumPrice,2).'</td>
				<td align="right"><input id="point_'.$num.'" name="point_'.$num.'" value="'.number_format($point).'" onkeyup="'.$sumList.'" onkeypress="return chkNumberPercent(event)" size="5" style="text-align:right;" /></td>
				<td id="boxEachPoint_'.$num.'" align="right">'.number_format($sumPoint).'</td>
				<td align="center"><a class="delete" title="'.lang('web_delete').'" href="javascript:void(0);" onclick="'.$delList.'" ></a></td>';
		return $txt;
	}
	public function rowShow($num,$id,$name,$amount,$price,$point){
		$no = $num;
		$sumPrice = $amount*$price;
		$sumPoint = $amount*$point;
		
		$txt='<td align="center">'.$no.'</td>
				<td>'.$name.'</td>
				<td align="right">'.number_format($amount).'</td>
				<td align="right">'.number_format($price,2).'</td>
				<td align="right">'.number_format($sumPrice,2).'</td>
				<td align="right">'.number_format($point).'</td>
				<td align="right">'.number_format($sumPoint).'</td>';
		return $txt;
	}
	public function getDiscount($discount){
		$dis_type=2;
		
		$Array_discount=str_split($discount);
		if($Array_discount[count($Array_discount)-1]=='%'){
			$discount=str_replace("%","",$discount);
			$dis_type=1;
		}
		
		return array($discount,$dis_type);
	}


	/*  CONFIRM
	-------------------------------------------------------------------------------------------------------*/	
	public function listConfirm($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select()
				->from($this->tbl_sp_order_confirm)
				->order_by("order_confirm_id",'desc');
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "((order_confirm_name like '%".$sData."%') or (order_confirm_bank like '%".$sData."%'))";
			$this->db->where($where);
		}

		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#boxContent';
		$config['limit'] = $limit;
		$config['page'] = $page;
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->do_pagination();
	}
	public function deleteConfirm($id){		
		$this->db->where('order_confirm_id',$id);
		$this->db->delete($this->tbl_sp_order_confirm);
	}
	
	
	/*  BANK
	-------------------------------------------------------------------------------------------------------*/	
	public function listBank($targetpage,$page,$limit,$sData=""){
	
		$select = $this->db->select()
				->from($this->tbl_sp_order_bank)
				->order_by("$this->tbl_sp_order_bank.bank_seq",'asc');
				
		if(!empty($sData)){
			$sData = urlDecode($sData);
			$where = "((bank_name like '%".$sData."%') OR (bank_branch like '%".$sData."%') OR (bank_account like '%".$sData."%') OR (bank_no like '%".$sData."%'))";
			$this->db->where($where);
		}

		$this->db->get();
		$config['query'] = $this->db->last_query();
		$config['targetpage'] = $targetpage;
		$config['target'] = '#boxContent';
		$config['limit'] = $limit;
		$config['page'] = $page;
		
		$this->load->library('bfpagination', $config);
		return list($paginaion,$page_description,$result) = $this->bfpagination->do_pagination();
	}
	public function listEditBank($id){
		
		$select = $this->db->select()
				->from($this->tbl_sp_order_bank)
				->where("bank_id",$id);		
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;
	}
	public function addBank(){
		
		$val = $this->getValue();
		if($val['captcha']=='')
		{
			$bank_id = $this->bflibs->getLastID($this->tbl_sp_order_bank,'bank_id');
			$bank_seq = $this->bflibs->getLastID($this->tbl_sp_order_bank,'bank_seq');
			$date = date('Y-m-d H:i:s');
			$bank_publish = (isset($val['bank_publish']))?$val['bank_publish']:0;
			$bank_pin = (isset($val['bank_pin']))?$val['bank_pin']:0;
			$data = array(
					"bank_id"=>$bank_id,
					"bank_name"=>$val['bank_name'],
					"bank_branch"=>$val['bank_branch'],
					"bank_account"=>$val['bank_account'],
					"bank_no"=>$val['bank_no'],
					"bank_date_added"=>$date,
					"bank_last_modified"=>$date,
					"bank_seq"=>$bank_seq,
					"bank_pin"=>$bank_pin,
					"bank_publish"=>$bank_publish
			);
			$this->db->insert($this->tbl_sp_order_bank,$data);			
			return $bank_id;
		}
	}
	public function editBank(){
		
		$val = $this->getValue();

		if($val['captcha']=='')
		{
			$bank_id = $val["bank_id"];
			$date = date('Y-m-d H:i:s');
			$bank_publish = (isset($val['bank_publish']))?$val['bank_publish']:0;
			$bank_pin = (isset($val['bank_pin']))?$val['bank_pin']:0;
			$data = array(
					"bank_name"=>$val['bank_name'],
					"bank_branch"=>$val['bank_branch'],
					"bank_account"=>$val['bank_account'],
					"bank_no"=>$val['bank_no'],
					"bank_last_modified"=>$date,
					"bank_pin"=>$bank_pin,
					"bank_publish"=>$bank_publish
			);

			$this->db->where('bank_id',$bank_id);
			$this->db->update($this->tbl_sp_order_bank,$data);
			return $val['bank_id'];
		}
	}
	public function deleteBank($id){
		
		$select = $this->db->select()
				->from($this->tbl_sp_order_bank);
		$this->db->where("bank_id",$id);
		$query = $this->db->get();
		$res = $query->row_array();

		if(!empty($res)){
			if($res['bank_image'] != ''){
				$file_name = basename($res['bank_image']);
				$path_ori = 'public/upload/bank/original/'.$file_name;
				$path_ori = DIR_FILE.$path_ori;
				
				$path_thumb = 'public/upload/bank/thumbnails/'.$file_name;
				$path_thumb = DIR_FILE.$path_thumb;
				
				if(file_exists($path_ori)){
					unlink($path_ori);
				}
				if(file_exists($path_thumb)){
					unlink($path_thumb);
				}
			}
		}
		$this->db->where('bank_id',$id);
		$this->db->delete($this->tbl_sp_order_bank);
	}
	
	/* UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	public function clearTmpImages(){
		$this->bflibs->remove_dir(DIR_FILE.'public/upload/bank/temp/'.$this->ip.'/',true);
	}
	public function movefile(){
		$module = 'bank';
		$temp = DIR_FILE.'/public/upload/'.$module.'/temp/';
		if(!file_exists($temp)){mkdir($temp);}
		$path = 'public/upload/'.$module.'/temp/'.$this->ip.'/';
		$dir_file = DIR_FILE.$path;
		
		//$path = 'public/upload/'.$this->request->getModuleName();
		//$dir_file = DIR_FILE.$path;
		if(!file_exists($dir_file)){mkdir($dir_file);}

		$config['upload_path'] = $dir_file;
		$config['allowed_types'] = 'gif|jpg|png|jpeg|tiff|pdf';
		$config['max_size']	= '5120';
		$config['overwrite']  = TRUE;
		$config['file_name'] = "bank_".md5(date('Ymdhis'));
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('Filedata'))
		{
			$error = array('error' => $this->upload->display_errors("<span>","</span>"));
			echo "";
		}
		else
		{
			$data = $this->upload->data();
			//$this->imagesResize($data['full_path']);
			$path = $path."/".$data['file_name'];
			echo $path;
		}
	}
	public function upload($file,$bank_id)
	{
		if(!empty($file)){
			$dir_file = DIR_FILE.'public/upload/bank/original/';
			if(!file_exists($dir_file)){mkdir($dir_file);}
			
			$ext = $this->bflibs->getExt($file);
			$file_name = 'bank_'.$bank_id."_".md5($key.date("mdhis")).".".$ext;
			$__dest = $dir_file.$file_name;
			$source = DIR_FILE.$file;

			copy($source, $__dest);
			unlink($source);
			//$this->updatePath('public/upload/'.$this->request->getModuleName().'/'.$file_name,$bank_id);
			if($this->imagesResize($__dest))$file = $this->updatePath('public/upload/bank/thumbnails/'.$file_name,$bank_id);

		}
	}
	private function imagesResize($pathImages)
	{
		$thump_path = 'public/upload/bank/thumbnails/';
		$dir_file = DIR_FILE.$thump_path;
		if(!file_exists($dir_file)){mkdir($dir_file);}
		$config['image_library'] = 'gd2';
		$config['source_image'] = $pathImages;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['new_image'] = DIR_FILE.$thump_path;
		$config['width'] = 100;
		$config['height'] = 100;

		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		if ( ! $this->image_lib->resize())
		{
			$error = $this->image_lib->display_errors();
			$status = false;
		}else{
			$status = true;
		}
		$this->image_lib->clear();
		return $status;
	}
	public function updatePath($path,$id){
		$this->deletePath($id);
		
		$data = array("bank_image"=>$path);
		$this->db->where('bank_id',$id);
		$this->db->update($this->tbl_sp_order_bank,$data);
	}
	public function deletePath($id){

		$query = $this->db->select("bank_image")
				->from($this->tbl_sp_order_bank)
				->where('bank_id',$id);				
		$query = $this->db->get();
		$result = $query->row_array();
		if(!empty($result)){
			$path = DIR_FILE.$result['bank_image'];
			if(file_exists($path)) unlink($path);
		}
	}
	public function delete_image()
	{
		$val = $this->getValue();
		if($val['image_path'] != ''){
			$path = DIR_FILE.$val['image_path'];
			unlink($path);
		}
	}
	/* END UPLOAD
	-----------------------------------------------------------------------------------------------------------*/
	
}
?>