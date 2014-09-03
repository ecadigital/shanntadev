<?php 
$this->model = $this->load->model('shoppingcart/Shoppingcartmodel');
$this->modelProduct = $this->load->model('product/Productmodel');
//
$total_items = $this->model->total_items();
$list_cart = $this->model->getCartRef();
$total = $this->model->total();

$action = $this->request->getActionName();

if($action=='message') $total_items=0;
?>
<a href="<?php echo DIR_ROOT;?>shoppingcart/frontend/cart" class="shoppingcart"><span href="" class="num">[<?php echo $total_items;?>]</span></a>