<?php 
class Index extends CI_Controller{
	private $view;
	public function __construct()
    {
        parent::__construct();
        $this->bflibs->setStack('admin');
    }
	
	public function main_manu()
	{
		$this->layout->disableLayout();
		$this->layout->view('/index/main_manu',$this->view);
	}
	public function sub_menu()
	{
		$this->layout->disableLayout();
		$this->layout->view('/index/sub_menu',$this->view);
	}
}
?>