<?php 
class Frontend extends CI_Controller{
	private $view;	
	
	public function __construct()
    {
        parent::__construct();
        
    	$layout = ($this->request->getParam('layout') == "")?'default':$this->request->getParam('layout');
		$this->layout->setLayout($layout);
		//$this->layout->disableLayout($layout);
   	 	$this->model = $this->load->model('voucher/Voucher_frontmodel');
    }
	
	
    public function add_point()
    {
    	$this->layout->disableLayout();
		if($data = $this->input->post())
		{
			$this->model->setValue($data);
			$member_point_id = $this->model->addPoint($_SESSION['member_id']);
			
			if($member_point_id==''){
				echo "
				<script>
					alert('รหัสเลข Voucher หรือเบอร์โทรศัพท์ผิดค่ะ');
				</script>";
			}else{
				echo "
				<script>
					alert('เพิ่มพ้อยท์เรียบร้อยแล้ว');
					window.parent.location='".DIR_ROOT."point.php';
				</script>";
			}
		}
    }
}
?>