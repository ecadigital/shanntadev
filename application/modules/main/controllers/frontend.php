<?php 
class Frontend extends CI_Controller{
	private $view;	
	
	public function __construct()
    {
        parent::__construct();
        
    	$layout = ($this->request->getParam('layout') == "")?'default':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		// set lang
		$lang_id = $this->request->getParam('lang');
    	$this->bflibs->setLang($lang_id,$_SERVER['REQUEST_URI']);
		
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
	
	public function aboutus()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['getMain'] = $this->model->getMain($lang_id);
		$this->layout->view('/frontend/aboutus', $this->view);
	}
	public function contactus()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['getMain'] = $this->model->getMain($lang_id);
		$this->layout->view('/frontend/contactus', $this->view);
	}
	public function footer()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['getMain'] = $this->model->getMain($lang_id);
		$this->layout->view('/frontend/footer', $this->view);
	}
	public function social()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['type'] = $this->request->getParam('type');
		$this->view['getMain'] = $this->model->getMain('1');
		$this->layout->view('/frontend/social', $this->view);
	}
	
}
?>