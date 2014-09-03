<?php 
class Frontend extends CI_Controller{
	private $view;	
	
	public function __construct()
    {
        parent::__construct();
        
    	$layout = ($this->request->getParam('layout') == "")?'default':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		//$this->layout->disableLayout($layout);
   	 	$this->model = $this->load->model('main/Mainmodel');
    }
	
	public function map()
	{
    	$this->layout->disableLayout();
		$this->view['listEditMain'] = $listEditMain = $this->model->listEditMain();
		
		$latitude = 0;
		$longitude = 0;
		
		if(!empty($listEditMain)){
			$latitude = $listEditMain['main_latitude'];
			$longitude = $listEditMain['main_longitude'];
		}
		
		$this->view['latitude'] = $latitude;
		$this->view['longitude'] = $longitude;
		
		$this->layout->view('/frontend/map',$this->view);
	}
}
?>