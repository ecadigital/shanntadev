<?php 
class Frontend extends CI_Controller{
	private $view;
	private $perpageProduct = 12;
	
	public function __construct()
    {
        parent::__construct();
    	$layout = ($this->request->getParam('layout') == "")?'default':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		// set lang
		$lang_id = $this->request->getParam('lang');
    	$this->bflibs->setLang($lang_id,$_SERVER['REQUEST_URI']);
    	
    	$actions=$this->bflibs->insertActionStackFront();
   	 	if(!empty($actions)){
			foreach($actions as $action)
			{
				$this->layout->setActionStack($action["name"],$action["view"]);
			}
   	 	}
   	 	$this->model = $this->load->model('shoppingcart/Shoppingcart_frontmodel');
   	 	$this->model->register = $this->view['addRegister'] = 300;
    }

	public function set_sesmember(){		
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			if(isset($data['member_type'])) $_SESSION['order']['member_type']=$data['member_type'];
			if(isset($data['member_title'])) $_SESSION['order']['member_title']=$data['member_title'];
			if(isset($data['member_fname'])) $_SESSION['order']['member_fname']=$data['member_fname'];
			if(isset($data['member_lname'])) $_SESSION['order']['member_lname']=$data['member_lname'];
			if(isset($data['member_bday'])) $_SESSION['order']['member_bday']=$data['member_bday'];
			if(isset($data['member_bmonth'])) $_SESSION['order']['member_bmonth']=$data['member_bmonth'];
			if(isset($data['member_byear'])) $_SESSION['order']['member_byear']=$data['member_byear'];
			if(isset($data['member_address'])) $_SESSION['order']['member_address']=$data['member_address'];
			if(isset($data['member_postcode'])) $_SESSION['order']['member_postcode']=$data['member_postcode'];
			if(isset($data['member_city'])) $_SESSION['order']['member_city']=$data['member_city'];
			if(isset($data['member_prephone'])) $_SESSION['order']['member_prephone']=$data['member_prephone'];
			if(isset($data['member_phone'])) $_SESSION['order']['member_phone']=$data['member_phone'];
			if(isset($data['member_email'])) $_SESSION['order']['member_email']=$data['member_email'];
			if(isset($data['chk_accept'])) $_SESSION['order']['chk_accept']=$data['chk_accept'];
			if(isset($data['chk_message'])) $_SESSION['order']['chk_message']=$data['chk_message'];
			if(isset($data['member_message'])) $_SESSION['order']['member_message']=$data['member_message'];
			if(isset($data['member_payment'])) $_SESSION['order']['member_payment']=$data['member_payment'];
			if(isset($data['transfer_bank'])) $_SESSION['order']['transfer_bank']=$data['transfer_bank'];				
		}
	}
	
	public function add_cart()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->view['num'] = 1;
			$this->model->setValue($data);
			$this->model->add_cart();
			/*echo "
			<script>
				window.location.reload();
			</script>";*/
		}
		//$this->layout->view('/frontend/add_cart', $this->view);
	}
	public function list_order()
	{
		$this->layout->disableLayout();
		$this->view['id'] = $id = $this->request->getParam('id');
		$this->view['member_point'] = $this->model->get_member_point($_SESSION['member_id']);
		$this->layout->view('/frontend/list_order', $this->view);
	}
	public function widget()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $this->request->getParam('lang');
		$this->view['contents'] = $this->model->getCartRef();
		$this->layout->view('/frontend/widget', $this->view);
	}
	public function cart()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $this->request->getParam('lang');
		$this->view['contents'] = $this->model->getCartRef();
		$this->layout->view('/frontend/cart', $this->view);
	}
	public function cart0()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $this->request->getParam('lang');
		$this->view['contents'] = $this->model->getCartRef();
		$this->layout->view('/frontend/cart0', $this->view);
	}
	public function cart1()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $this->request->getParam('lang');
		$this->view['type'] = $this->request->getParam('type');
		$this->view['contents'] = $this->model->getCartRef();
		$this->layout->view('/frontend/cart1', $this->view);
	}
	public function cart2()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $this->request->getParam('lang');
		$this->view['type'] = $this->request->getParam('type');
		$this->view['contents'] = $this->model->getCartRef();
		$this->layout->view('/frontend/cart2', $this->view);
	}
	public function cart3()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $this->request->getParam('lang');
		$this->view['type'] = $this->request->getParam('type');
		$this->view['contents'] = $this->model->getCartRef();
		$this->layout->view('/frontend/cart3', $this->view);
	}
	public function cart4()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $this->request->getParam('lang');
		$this->view['type'] = $this->request->getParam('type');
		$this->view['contents'] = $this->model->getCartRef();
		$this->view['listAllBank'] = $this->model->listAllBank();
		$this->layout->view('/frontend/cart4', $this->view);
	}
	public function cart5()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $this->request->getParam('lang');
		$this->view['order_id'] = $order_id = $this->request->getParam('id');
		$this->view['getOrder'] = $this->model->getOrder($order_id);
		$this->view['getOrderItem'] = $this->model->getOrderItem($order_id);
		$this->layout->view('/frontend/cart5', $this->view);
	}
	public function update_cart_widget() // update เฉพาะจำนวนสินค้า
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->update_cart_widget();
		}
	}
	public function update_cart() // update เฉพาะจำนวนสินค้า
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->update_cart();
		}
	}
	public function total_cart()
	{
		$this->layout->disableLayout();
		echo $this->model->total_items();
		//echo $this->model->total_items();
		//$this->layout->view('/frontend/total_cart', $this->view);
	}
	public function remove_cart()
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->remove_cart();
			echo $total_items = $this->model->total_items();
		}
	}
	public function checkout()
	{
		$this->layout->disableLayout();
		$this->view['contents'] = $this->model->getCart();
		$lang = $this->request->getParam('lang');
		if($data = $this->input->post()){
			$this->model->setValue($data);
			echo $this->model->addOrder($lang);
			unset($_SESSION['order']);
			$this->model->clear_cart();
		}
		//$this->layout->view('/frontend/checkout', $this->view);
	}
	/*public function load(){
		$this->layout->disableLayout();
		$this->view['total_items'] = $this->model->total_items();
		$this->layout->view('/frontend/load', $this->view);
	}
	public function cart()
	{
		$this->view['contents'] = $this->model->getCartRef();
		$this->view['total_items'] = $this->model->total_items();
		$this->view['total'] = $this->model->total();
		$this->layout->view('/frontend/cart', $this->view);
	}
	public function chkoption()
	{
		$this->layout->disableLayout();
		$this->layout->view('/frontend/chkoption', $this->view);
	}
	public function checkout_member()
	{
		$order_id = '';
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$order_id = $this->model->checkout();
		}
		$this->view['order_id'] = $order_id;
		$this->view['listProvince'] = $this->model->listProvince();
		$this->view['contents'] = $this->model->getCart();
		$this->view['total_items'] = $this->model->total_items();
		$this->view['total'] = $this->model->total();
		$this->layout->view('/frontend/checkout_member', $this->view);
	}
	public function checkout_register()
	{
		$order_id = '';
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$order_id = $this->model->checkout();
		}
		$this->view['order_id'] = $order_id;
		$this->view['listProvince'] = $this->model->listProvince();
		$this->view['listBank'] = $this->model->listBank();
		$this->view['contents'] = $this->model->getCart();
		$this->view['total_items'] = $this->model->total_items();
		$this->view['total'] = $this->model->total();
		$this->layout->view('/frontend/checkout_register', $this->view);
	}
	public function register()
	{
		$this->view['listProvince'] = $this->model->listProvince();
		$this->view['listBank'] = $this->model->listBank();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->register();
			$this->view['redirect']="<script>window.parent.location='".DIR_ROOT."shoppingcart/frontend/afterregister';</script>";
		}
		$this->layout->view('/frontend/register', $this->view);
	}
	public function afterregister()
	{
		$this->layout->view('/frontend/afterregister', $this->view);
	}
	public function list_cart()
	{
		$this->layout->disableLayout();
		$this->view['contents'] = $this->model->getCart();
		$this->view['total_items'] = $this->model->total_items();
		$this->view['total'] = $this->model->total();
		$this->layout->view('/frontend/list_cart', $this->view);
	}
	public function message()
	{
		$order_id = $this->request->getParam('order_id');
		$this->view['defaultlang'] = $this->bflibs->getDefaultLangId();
		$this->view['order_info'] = $this->model->order_info($order_id);
		$orderDetail = $this->model->orderDetail($order_id);
		$this->model->setValue($orderDetail);
		$this->model->sendmail('open');
		$this->model->sendmail('open_admin');
		$this->model->clear_cart();
		$this->layout->view('/frontend/message', $this->view);
	}
	public function cartorder()
	{
		$member = $this->session->userdata('member');
		$this->view['cartorder'] = $this->model->cartorder($member->member_id);
    	$this->layout->view('/frontend/cartorder', $this->view);
    }*/
}
?>