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
   	 	$this->model = $this->load->model('product/Product_frontmodel');
   	 	//$this->model->register = $this->view['addRegister'] = 300;
    }

	public function list_product()
	{
		$this->layout->disableLayout();
		$lang_id = $this->request->getParam('lang');
		$product_categories_id = $this->request->getParam('cat');
		$this->view['listProduct'] = $this->model->listProduct($lang_id,$product_categories_id='');
		$this->layout->view('/frontend/list_product', $this->view);
	}
	public function update_cart() // update เฉพาะจำนวนสินค้า
	{
		$this->layout->disableLayout();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->update_cart();
		}
	}
	public function checkout()
	{
		$this->layout->disableLayout();
		$this->view['listBank'] = $this->model->listAllBank();
		$this->view['member_point'] = $this->model->get_member_point($_SESSION['member_id']);
		$this->view['getMember'] = $this->model->getMember($_SESSION['member_id']);
		$this->view['contents'] = $this->model->getCart();
		if($data = $this->input->post()){
			$this->model->setValue($data);
			$this->model->addOrder();
			$this->model->clear_cart();
			echo "
			<script>
				window.parent.location='".DIR_ROOT."orderreview.php';
			</script>";	
		}
		$this->layout->view('/frontend/checkout', $this->view);
	}
	public function list_order()
	{
		$this->layout->disableLayout();
		$this->view['id'] = $id = $this->request->getParam('id');
		$this->view['member_point'] = $this->model->get_member_point($_SESSION['member_id']);
		$this->layout->view('/frontend/list_order', $this->view);
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
		}
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