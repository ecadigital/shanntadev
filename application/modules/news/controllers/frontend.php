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
		
   	 	$this->model = $this->load->model('news/Newsmodel');
    }

	public function index()
	{
		$this->layout->disableLayout();
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['listNews'] = $this->model->listAllNews($lang_id);
		$this->layout->view('/frontend/index', $this->view);
	}
	public function detail()
	{
		$this->layout->disableLayout();
		$this->view['news_id'] = $news_id = $this->request->getParam('id');
		$this->view['lang'] = $lang_id = $this->request->getParam('lang');
		$this->view['getNews'] = $this->model->getNews($lang_id,$news_id);
		$this->view['randomNews'] = $this->model->randomNews($lang_id,$news_id);
		$this->layout->view('/frontend/detail', $this->view);
	}
}
?>