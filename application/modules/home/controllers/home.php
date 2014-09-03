<?php 
class Home extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
		
		$layout = ($this->request->getParam('layout') == "")?'home':$this->request->getParam('layout');
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
    }
	public function index()
	{
		$this->layout->disableLayout();
		$this->modelMain = $this->load->model('main/Mainmodel');
		$listEditMain = $this->modelMain->listEditMain();
		if($listEditMain['main_intro_show']==0 || $listEditMain['main_intro']=='' || html_entity_decode($listEditMain['main_intro'])=='<p></p>'){
			echo '<script>window.location="'.DIR_ROOT.'home.php";</script>';
		}else{
			echo '<script>window.location="'.DIR_ROOT.'intro.php";</script>';
		}
		//$this->layout->view('index');
	}
}
?>