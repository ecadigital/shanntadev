<?php 
class Shoppingcart_frontmodel extends CI_Model {
	
	private $tbl_product = 'product';
	private $tbl_product_images = 'product_images';
	private $tbl_product_categories = 'product_categories';
	private $tbl_sp_order = 'sp_order';
	private $tbl_sp_order_item = 'sp_order_item';
	private $tbl_sp_order_status = 'sp_order_status';
	private $tbl_sp_order_bank = 'sp_order_bank';
	private $tbl_member = 'member';
	
	public function setValue($val){
		$this->value = $val;
	}
	
	private function getValue(){
		return $this->value;
	}
	
	public function __construct(){
	
        parent::__construct();
        $this->load->library('cart');
        $this->defaultlang = $this->bflibs->getDefaultLangId();
	}
	
	public function addOrder(){
		
		$val = $this->getValue();
		
		$order_id = $this->bflibs->getLastID($this->tbl_sp_order,'order_id');
		$date = date('Y-m-d H:i:s');
		$member_id=$_SESSION['member_id'];
		
		$order_summary=0;
		$point_summary=0;
		
		$contents = $this->getCart();
		
		if(!empty($contents)){
			foreach($contents as $content){
				$product = $this->model->getProduct($content['id']);
				$qty = $content['qty'];
				$price = $product['product_price'];
				$total_price = $price*$qty;
				$point = $product['product_point'];
				$total_point = $point*$qty;
				
				$order_summary += $total_price;
				$point_summary += $total_point;
				$data_item = array(
							"order_id"=>$order_id,
							"product_id"=>$content['id'],
							"product_name"=>$product['product_name'],
							"product_detail"=>$product['product_detail'],
							"order_qty"=>$qty,
							"order_price"=>$product['product_price'],
							"order_discount"=>0,
							"order_point"=>$product['product_point'],
							"order_status"=>1
				);			
				$this->db->insert($this->tbl_sp_order_item,$data_item);
			}
		}
		
		$member_id = (isset($_SESSION['member_id'])) ? $_SESSION['member_id'] : 0;
		$member_discount = $this->model->get_member_discount($member_id);
		
		$member_first_name = '';
		$member_last_name = '';
		$member_address = '';
		$member_tel = '';
		if($val['radio_address']==0){
			$member_first_name = $val['member_first_name'];
			$member_last_name = $val['member_last_name'];
			$member_address = $val['member_address'];
			$member_tel = $val['member_tel'];
		}else{
			$member_first_name = $val['member_first_name_1'];
			$member_last_name = $val['member_last_name_1'];
			$member_address = $val['member_address_1'];
			$member_tel = $val['member_tel_1'];
		}
		
		$data = array(
				"order_id"=>$order_id,
				"member_id"=>$member_id,
				"order_discount"=>$member_discount.'%',
				"order_summary"=>$order_summary,
				"order_point"=>'',//$val['point'],
				"order_point_summary"=>$point_summary,
				"member_first_name"=>$member_first_name,
				"member_last_name"=>$member_last_name,
				"member_address"=>$member_address,
				"member_tel"=>$member_tel,
				"order_date"=>$date,
				"order_date_added"=>$date,
				"order_last_update"=>$date,
				"order_status_id"=>($val['payment']==1) ? 2 : 1,
				"order_payment"=>$val['payment'],
				"order_read"=>0
		);
		$this->db->insert($this->tbl_sp_order,$data);
		
		if($val['payment']==1){
			// add point //
			$old_point = $this->bflibs->getMemberPoint($member_id);
			$new_point = $old_point-$point_summary;
			$this->bflibs->updateMemberPoint($member_id,$new_point);			
		}	
		
		if($val['radio_address']==0){
			$data = array(
				"member_first_name"=>$member_first_name,
				"member_last_name"=>$member_last_name,
				"member_address"=>$member_address,
				"member_tel"=>$member_tel
			);
			$this->db->where("member_id",$member_id);			
			$this->db->update($this->tbl_member,$data);
		}
					
		return $order_id;
	}
	
	public function add_cart(){
		// ชื่อสินค้า ให้ default เปนภาษาอังกฤษ จะได้ไม่มีปัญหาเวลาส่งไป paypal //
		$val = $this->getValue();
		$thisCart = $this->getCart();
		$array = array();
		foreach($thisCart as $item){
			$array[] = $item['id'];
		}
		$select = $this->db->select(array("product_price"))
					->from($this->tbl_product)
					->where("product_id",$val['id'])
					->where("product_publish",'1');
		$query = $this->db->get();
		$result = $query->row_array();

		if(!in_array($val['id'],$array)){
			if(!empty($result)){
				$cart = array(
						'id'      => $val['id'],
		               	'qty'     => $val['qty'],
		               	'price'   => $result['product_price'],
		               	'name'    => $val['id'],
						'options' => array(/*'image' => $result['product_images'], 'code' => $result['product_code']*/)
				);
				$this->cart->insert($cart);
			}
		}
		else if(isset($val['rowid'])){
			$cart = array(
               'rowid' => $val['rowid'],
               'qty'   => $val['qty']
            );
			$this->cart->update($cart);
		}
		return $result;
	}
	
	
	/* CART
	------------------------------------------------------------------------------------*/
	
	public function update_cart() // update เฉพาะจำนวนสินค้า
	{
		$val = $this->getValue();
		if(!empty($val)){
			foreach($val['inp-qty'] as $rowid=>$qty){
				$qty = (empty($qty))?9999:$qty;
				$cart = array(
	               'rowid' => $rowid,
	               'qty'   => $qty
	            );
				$this->cart->update($cart);
			}
		}
	}
	public function remove_cart()
	{
		$val = $this->getValue();
		$cart = array(
			'rowid' => $val['rowid'],
			'qty'   => 0
		);
		$this->cart->update($cart);
	}
	public function clear_cart()
	{
		$this->cart->destroy();
	}
	public function getCart(){
		return $this->cart->contents();
	}
	public function getCartRef(){
		$contents = $this->cart->contents();
		foreach($contents as $content){
			if(empty($content['qty'])){
				$data = array("rowid"=>$content['rowid']);
				$this->setValue($data);
				$this->remove_cart();
			}
		}
		return $this->cart->contents();
	}
	public function total_items(){
		return $this->cart->total_items();
	}
	public function total(){
		return $this->cart->total();
	}
	
	
	/* OTHER
	------------------------------------------------------------------------------------*/
	public function get_member_point($id){
		
		$select = $this->db->select(array("member_point"))
					->from($this->tbl_member)
					->where("member_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return (!empty($result)) ? $result['member_point'] : 0;
	}
	public function get_member_discount($id){
		
		$select = $this->db->select(array("member_discount"))
					->from($this->tbl_member)
					->where("member_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return (!empty($result)) ? $result['member_discount'] : 0;
	}
	public function getProduct($id){
		
		$select = $this->db->select(array("product_name","product_detail","product_price","product_point"))
					->from($this->tbl_product)
					->where("product_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;	
	}
	public function getMember($id){
		
		$select = $this->db->select()
					->from($this->tbl_member)
					->where("member_id",$id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;	
	}
	public function getProductImage($id){
		
		$select = $this->db->select(array("product_images_path"))
					->from($this->tbl_product_images)
					->where("product_id",$id)
					->order_by("product_images_seq","asc");
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;	
	}
	public function listAllBank(){
	
		$select = $this->db->select()
				->from($this->tbl_sp_order_bank)
				->order_by("$this->tbl_sp_order_bank.bank_seq",'asc');
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;	
	}
}
?>