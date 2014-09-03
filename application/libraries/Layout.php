<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    var $ci;
    var $layout;
    var $loadedData;
	
    function __construct()
	{
		//parent::__construct();
		// i need the codeigniter super-object 
		// in all the functions
	
		$this->ci =& get_instance();
	}
	
    function Layout($layout = "index")
    {
        $this->ci =& get_instance();
        $this->layout = $layout;
    }

    function setLayout($layout)
    {
    	$this->loadedData=array();
      	$this->layout = $layout;
    }
    
	function getLayout()
    {
      	return $this->layout;
    }
    
	function disableLayout()
    {
    	$this->loadedData=array();
      	$this->layout = 'empty';
    }
    
	function setActionStack($name,$view, $data=null)
    {
    	$this->loadedData[$name] = $this->ci->load->view($view,$data,true);
    }
    
    function view($view, $data=null, $return=false)
    {
        $this->loadedData['content'] = $this->ci->load->view($view,$data,true);
        if($return)
        {
            $output = $this->ci->load->layout($this->layout, $this->loadedData, true);
            return $output;
        }
        else
        {
            $this->ci->load->layout($this->layout, $this->loadedData, false);
        }
    }
    function headMeta()
    {
    	return "meta tag";
    }
}
?>
