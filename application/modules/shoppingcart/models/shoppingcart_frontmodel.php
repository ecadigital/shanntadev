<?php 
class Shoppingcart_frontmodel extends CI_Model {
	
	private $tbl_product = 'product';
	private $tbl_product_lang = 'product_lang';
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
	
	public function addOrder($lang){
		
		$val = $this->getValue();
		
		$order_id = $this->bflibs->getLastID($this->tbl_sp_order,'order_id');
		$date = date('Y-m-d H:i:s');
		$member_id=(isset($_SESSION['member_id']) && $_SESSION['member_id']!='') ? $_SESSION['member_id'] : 0;
		
		$order_summary=0;
		
		$contents = $this->getCart();
		
		if(!empty($contents)){
			foreach($contents as $content){
				$product = $this->model->getProduct($lang,$content['id']);
				$qty = $content['qty'];
				$price = $product['product_price'];
				$total_price = $price*$qty;
				
				$order_summary += $total_price;
				$data_item = array(
							"order_id"=>$order_id,
							"product_id"=>$content['id'],
							"product_name"=>$product['product_name'],
							"product_detail"=>$product['product_detail'],
							"order_qty"=>$qty,
							"order_price"=>$product['product_price'],
							"order_currency"=>$product['product_currency'],
							"order_status"=>1
				);			
				$this->db->insert($this->tbl_sp_order_item,$data_item);
			}
		}
		
		$member_title = (isset($_SESSION['order']['member_title'])) ? $_SESSION['order']['member_title'] : '';
		$member_fname = (isset($_SESSION['order']['member_fname'])) ? $_SESSION['order']['member_fname'] : '';
		$member_lname = (isset($_SESSION['order']['member_lname'])) ? $_SESSION['order']['member_lname'] : '';
		$member_address = (isset($_SESSION['order']['member_address'])) ? $_SESSION['order']['member_address'] : '';
		$member_city = (isset($_SESSION['order']['member_city'])) ? $_SESSION['order']['member_city'] : '';
		$member_postcode = (isset($_SESSION['order']['member_postcode'])) ? $_SESSION['order']['member_postcode'] : '';
		$member_prephone = (isset($_SESSION['order']['member_prephone'])) ? $_SESSION['order']['member_prephone'] : '';
		$member_phone = (isset($_SESSION['order']['member_phone'])) ? $_SESSION['order']['member_phone'] : '';
		$member_message = (isset($_SESSION['order']['member_message'])) ? $_SESSION['order']['member_message'] : '';
		$member_payment = (isset($val['member_payment'])) ? $val['member_payment'] : '';
		$transfer_bank = (isset($val['transfer_bank'])) ? $val['transfer_bank'] : '';
		
		$data = array(
				"order_id"=>$order_id,
				"member_id"=>$member_id,
				"order_summary"=>$order_summary,
				"order_shipping"=>'0',
				"member_title"=>$member_title,
				"member_first_name"=>$member_fname,
				"member_last_name"=>$member_lname,
				"member_address"=>$member_address,
				"member_city"=>$member_city,
				"member_postcode"=>$member_postcode,
				"member_prephone"=>$member_prephone,
				"member_phone"=>$member_phone,
				"member_message"=>$member_message,
				"order_method"=>'',
				"order_date"=>$date,
				"order_date_added"=>$date,
				"order_last_update"=>$date,
				"order_status_id"=>($member_payment=='transfer') ? 1 : 2,
				"order_payment"=>$member_payment,
				"order_read"=>0
		);
		$this->db->insert($this->tbl_sp_order,$data);
		
		if($member_id!=0){
			$data = array(
					"member_address"=>$member_address,
					"member_city"=>$member_city,
					"member_postcode"=>$member_postcode,
					"member_prephone"=>$member_prephone,
					"member_phone"=>$member_phone
			);
			$this->db->where('member_id',$_SESSION['member_id']);
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
	public function update_cart_widget() // update เฉพาะจำนวนสินค้า
	{
		$val = $this->getValue();
		if(!empty($val)){
			foreach($val['winp-qty'] as $rowid=>$qty){
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
	public function getOrder($order_id){
		
		$select = $this->db->select()
					->from($this->tbl_sp_order)
					->where("order_id",$order_id);
		$query = $this->db->get();
		$result = $query->row_array();
		
		return $result;	
	}
	public function getOrderItem($order_id){
		
		$select = $this->db->select()
					->from($this->tbl_sp_order_item)
					->where("order_id",$order_id);
		$query = $this->db->get();
		$result = $query->result_array();
		
		return $result;	
	}
	
	public function getProduct($lang_id,$product_id){
		
		$select = $this->db->select(array("$this->tbl_product.product_id",
										"$this->tbl_product_lang.product_name",
										"$this->tbl_product_lang.product_detail",
										"$this->tbl_product_lang.product_price",
										"$this->tbl_product_lang.product_currency"))
				->from($this->tbl_product_lang)
				->join($this->tbl_product,"$this->tbl_product.product_id=$this->tbl_product_lang.product_id","left")
				->where("$this->tbl_product_lang.language_id",$lang_id)
				->where("$this->tbl_product.product_id",$product_id)
				->limit(1);
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
	
	/* CONTENT
	------------------------------------------------------------------------------------*/
	
	public function nav_cart($step){
		$txt = '
		<nav>
			<ul>
				<li class="small-4 medium-2 columns'; 
				if($step>=1) $txt .= ' checked'; 
				if($step==1) $txt .= ' current'; $txt .= '">
					<div class="large-4 columns">
						<div class="circle">1</div>
					</div>
					<div class="large-8 columns">
						<div class="stepNo">STEP 1</div>
						<div class="stepName">Register</div>
					</div>
				</li>
				<li class="small-4 medium-2 columns'; 
				if($step>=2) $txt .= ' checked'; 
				if($step==2) $txt .= ' current'; $txt .= '">
					<div class="large-4 columns">
						<div class="circle">2</div>
					</div>
					<div class="large-8 columns">
						<div class="stepNo">STEP 2</div>
						<div class="stepName">Delivery</div>
					</div>
				</li>
				<li class="small-4 medium-2 columns'; 
				if($step>=3) $txt .= ' checked'; 
				if($step==3) $txt .= ' current'; $txt .= '">
					<div class="large-4 columns">
						<div class="circle">3</div>
					</div>
					<div class="large-8 columns">
						<div class="stepNo">STEP 3</div>
						<div class="stepName">Review</div>
					</div>
				</li>
				<li class="small-4 medium-2 columns'; 
				if($step>=4) $txt .= ' checked'; 
				if($step==4) $txt .= ' current'; $txt .= '">
					<div class="large-4 columns">
						<div class="circle">4</div>
					</div>
					<div class="large-8 columns">
						<div class="stepNo">STEP 4</div>
						<div class="stepName">Payment</div>
					</div>
				</li>
				<li class="small-4 medium-2 columns end'; 
				if($step>=5) $txt .= ' checked'; 
				if($step==5) $txt .= ' current'; $txt .= '">
					<div class="large-4 columns">
						<div class="circle">5</div>
					</div>
					<div class="large-8 columns">
						<div class="stepNo">STEP 5</div>
						<div class="stepName">Confirmation</div>
					</div>
				</li>
			</ul>
		</nav>';
		
		return $txt;	
	}
	
	
}
?>