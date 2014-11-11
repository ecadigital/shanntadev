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
    	
    	$actions=$this->bflibs->insertActionStackFront();
   	 	if(!empty($actions)){
			foreach($actions as $action)
			{
				$this->layout->setActionStack($action["name"],$action["view"]);
			}
   	 	}
   	 	$this->model = $this->load->model('contactus/Contactusmodel');
    }
	public function add()
	{		
    	$this->layout->disableLayout();
		if($data = $this->input->post()){
		
			$this->model->setValue($data);
			echo $contactus_id = $this->model->addContact();
			$this->model->sendmail();
			/*echo "
			<script>
				window.parent.alert('Send email complete. Please wait for contact immediately.');
				window.parent.reload();
			</script>";*/
		}
		//$this->layout->view('/frontend/index', $this->view);
	}
}
?>