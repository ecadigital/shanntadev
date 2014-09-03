<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bfpagination
{
	private $db_lib;
	private $ci;
	private $query		= "";
	private $targetpage  = "";
	private $loadpage	= "";
	private $target		= "";
	private $limit		= 0;
	private $page		= 0;

	public function __construct($props = array())
	{
		if (count($props) > 0)
		{
			$this->initialize($props);
		}
		$this->ci = $CI =& get_instance();
		$this->db_lib = $CI->load->database('default', TRUE);
	}

	public function initialize($config = array())
	{
		$defaults = array(
					'query'			=> '',
					'limit'			=> 10,
					'targetpage'	=> '',
					'loadpage'		=> 'ajax', // ajax,normal
					'target'		=> '#',
					'page'			=> '',
					'pgfirst'		=> true,
					'pgprev'		=> true,
					'pgnext'		=> true,
					'pglast'		=> true,
					'pgnumber'		=> true,
					'current'		=> true,
					'pgdesc'		=> true,
					'pgsearch'		=> false,
					'loadDefault'	=> true
				);


		foreach ($defaults as $key => $val)
		{
			if (isset($config[$key]))
			{
				$method = 'set_'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($config[$key]);
				}
				else
				{
					$this->$key = $config[$key];
				}
			}
			else
			{
				$this->$key = $val;
			}
		}
	}
	public function set_query($val)
	{
		$this->query = $val;
	}
	public function set_targetpage($val)
	{
		$this->targetpage = $val;
	}
	public function set_limit($val)
	{
		$this->limit = $val;
	}
	public function set_loadpage($val)
	{
		$this->loadpage = $val;
	}
	public function set_target($val)
	{
		$this->target = $val;
	}
	public function set_page($val)
	{
		$this->page = $val;
	}
	public function do_pagination(){
		
		$targetpage=DIR_ROOT.$this->targetpage."/page/";
		$page = $this->page;
		$limit = $this->limit;
		$loadpage = $this->loadpage;
		$target = $this->target;
		
		$query_all = $this->db_lib->query($this->query);
		$result_all = $query_all->result_array();
		$total_pages = count($result_all);
		$start = ($this->page)?($page - 1) * $limit:0;
		
		//$query = $this->db_lib->query($this->query." limit $start, $limit ");
		if($limit=='all') $query = $this->db_lib->query($this->query." ");
		else 				$query = $this->db_lib->query($this->query." limit $start, $limit ");
		
		$result = $query->result_array();
		if (empty($page)) $page = 1;
		$prev = $page - 1;
		$next = $page + 1;
		$lastpage = ($limit=='all') ? 1 : ceil($total_pages/$limit);// = ceil($total_pages/$limit);
		$lpm = $lastpage + 1;
		$pagination = $page_description = "";
		
		if($lastpage > 1 || $this->loadDefault){
			$pagination .= '<div id="pagination">';
			
			// first
			if($page > 1){
				if($this->pgfirst){$pagination.= ($loadpage == 'normal')?'<a class="pg-first" href="'.$targetpage.'1">'.lang('web_page_first').'</a>':'<a  class="pg-first" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.'1\',\''.$target.'\',\'\')">'.lang('web_page_first').'</a>';}
				if($this->pgprev){$pagination.= ($loadpage == 'normal')?'<a class="pg-prev" href="'.$targetpage.$prev.'">'.lang('web_page_previous').'</a>':'<a  class="pg-prev" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$prev.'\',\''.$target.'\',\'\')">'.lang('web_page_previous').'</a>';}
			}else{
				if($this->pgfirst){$pagination.= '<span class="pg-first disabled">'.lang('web_page_first').'</span>';}
				if($this->pgprev){$pagination.= '<span class="pg-prev disabled">'.lang('web_page_previous').'</span>';}
			}
			// number
			for($i= 1;$i<$lpm;$i++){
			
				if($i == $page){
					if($this->current){$pagination.= '<span class="pg-number current">'.$i.'</span>';}
				}else{
				if($this->pgnumber){$pagination.= ($loadpage == 'normal')?'<a class="pg-number" href="'.$targetpage.$i.'">'.$i.'</a>':'<a  class="pg-number" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$i.'\',\''.$target.'\',\'\')">'.$i.'</a>';}
				}
			}
			// last
			if($page < $lastpage){
				if($this->pgnext){$pagination.= ($loadpage == 'normal')?'<a class="pg-next" href="'.$targetpage.$next.'">'.lang('web_page_next').'</a>':'<a  class="pg-next" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$next.'\',\''.$target.'\',\'\')">'.lang('web_page_next').'</a>';}
				if($this->pglast){$pagination.= ($loadpage == 'normal')?'<a class="pg-last" href="'.$targetpage.$lastpage.'">'.lang('web_page_last').'</a>':'<a  class="pg-last" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$lastpage.'\',\''.$target.'\',\'\')">'.lang('web_page_last').'</a>';}
			}else{
				if($this->pgnext){$pagination.= '<span class="pg-next disabled">'.lang('web_page_next').'</span>';}
				if($this->pglast){$pagination.= '<span class="pg-last disabled">'.lang('web_page_last').'</span>';}
			}
			$pagination .= '</div>';
			
			$no_start = $start+1;
			$page_to = ($limit=='all') ? $total_pages : $no_start*$limit;
			$page_to = ($page_to > $total_pages)?$total_pages:$page_to;
			
			$page_description .= '<div id="page_description">';
			if($this->pgdesc){$page_description .= '<span>'.lang('web_page_no').' '.$no_start.' '.lang('web_page_to').' '.$page_to.' '.lang('web_page_total').' '.$total_pages.' '.lang('web_page_record').'</span>';}
			
			if($this->pgsearch){$page_description .= '<span><strong>Page : </strong><input type="text" id="thispage" name="thispage" value="'.$page.'" class="inp_page"/> of '.$lastpage.'</span>';}
			
			$page_description .= '<input type="hidden" id="targetpage" name="targetpage" value="'.$this->targetpage.'">';
			$page_description .= '<script>pagination("'.$target.'");</script>';
			$page_description .= '</div>';
		}
		return array($pagination,$page_description,$result);
		
	}
	public function select_pagination(){
		
		$targetpage=DIR_ROOT.$this->targetpage."/page/";
		$page = $this->page;
		$limit = $this->limit;
		$loadpage = $this->loadpage;
		$target = $this->target;
		
		$query_all = $this->db_lib->query($this->query);
		$result_all = $query_all->result_array();
		$total_pages = count($result_all);
		$start = ($this->page)?($page - 1) * $limit:0;
		
		$query = $this->db_lib->query($this->query." limit $start, $limit ");
		$result = $query->result_array();
		if (empty($page)) $page = 1;
		$prev = $page - 1;
		$next = $page + 1;
		$lastpage = ceil($total_pages/$limit);
		$lpm = $lastpage + 1;
		$pagination = $page_description = "";
		
		if($lastpage > 1 || $this->loadDefault){
			$pagination .= '<div id="pagination">';
			
			// first
			if($page > 1){
				if($this->pgfirst){$pagination.= ($loadpage == 'normal')?'<a class="pg-first" href="'.$targetpage.'1">'.lang('web_page_first').'</a>':'<a  class="pg-first" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.'1\',\''.$target.'\',\'\')">'.lang('web_page_first').'</a>';}
				if($this->pgprev){$pagination.= ($loadpage == 'normal')?'<a class="pg-prev" href="'.$targetpage.$prev.'">'.lang('web_page_previous').'</a>':'<a  class="pg-prev" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$prev.'\',\''.$target.'\',\'\')">'.lang('web_page_previous').'</a>';}
			}else{
				if($this->pgfirst){$pagination.= '<span class="pg-first disabled">'.lang('web_page_first').'</span>';}
				if($this->pgprev){$pagination.= '<span class="pg-prev disabled">'.lang('web_page_previous').'</span>';}
			}
			// number
			$pagination.= '<select name="page" id="page" onchange="loadAjax(\''.$targetpage.'\'+$(\'#page\').val(),\''.$target.'\',\'\')">';
			for($i= 1;$i<$lpm;$i++){
				$pagination.= '<option value="'.$i.'" '; if($i == $page) $pagination.= 'selected="selected"'; $pagination.= '>'.$i.'</option>';
				/*if($i == $page){
					if($this->current){$pagination.= '<span class="pg-number current">'.$i.'</span>';}
				}else{
					if($this->pgnumber){$pagination.= ($loadpage == 'normal')?'<a class="pg-number" href="'.$targetpage.$i.'">'.$i.'</a>':'<a  class="pg-number" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$i.'\',\''.$target.'\',\'\')">'.$i.'</a>';}
				}*/
			}
			$pagination.= '</select>';
			
			// last
			if($page < $lastpage){
				if($this->pgnext){$pagination.= ($loadpage == 'normal')?'<a class="pg-next" href="'.$targetpage.$next.'">'.lang('web_page_next').'</a>':'<a  class="pg-next" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$next.'\',\''.$target.'\',\'\')">'.lang('web_page_next').'</a>';}
				if($this->pglast){$pagination.= ($loadpage == 'normal')?'<a class="pg-last" href="'.$targetpage.$lastpage.'">'.lang('web_page_last').'</a>':'<a  class="pg-last" href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$lastpage.'\',\''.$target.'\',\'\')">'.lang('web_page_last').'</a>';}
			}else{
				if($this->pgnext){$pagination.= '<span class="pg-next disabled">'.lang('web_page_next').'</span>';}
				if($this->pglast){$pagination.= '<span class="pg-last disabled">'.lang('web_page_last').'</span>';}
			}
			$pagination .= '</div>';
			
			$no_start = $start+1;
			$page_to = $no_start*$limit;
			$page_to = ($page_to > $total_pages)?$total_pages:$page_to;
			
			$page_description .= '<div id="page_description">';
			if($this->pgdesc){$page_description .= '<span>'.lang('web_page_no').' '.$no_start.' '.lang('web_page_to').' '.$page_to.' '.lang('web_page_total').' '.$total_pages.' '.lang('web_page_record').'</span>';}
			
			if($this->pgsearch){$page_description .= '<span><strong>Page : </strong><input type="text" id="thispage" name="thispage" value="'.$page.'" class="inp_page"/> of '.$lastpage.'</span>';}
			
			$page_description .= '<input type="hidden" id="targetpage" name="targetpage" value="'.$this->targetpage.'">';
			$page_description .= '<script>pagination("'.$target.'");</script>';
			$page_description .= '</div>';
		}
		return array($pagination,$page_description,$result);
		
	}
	public function do_pagination_front(){
		
		$targetpage=DIR_ROOT.$this->targetpage."/page/";
		$page = $this->page;
		$limit = $this->limit;
		$loadpage = $this->loadpage;
		$target = $this->target;
		
		$query_all = $this->db_lib->query($this->query);
		$result_all = $query_all->result_array();
		$total_pages = count($result_all);
		$start = ($this->page)?($page - 1) * $limit:0;
		
		$query = $this->db_lib->query($this->query." limit $start, $limit ");
		$result = $query->result_array();
		if (empty($page)) $page = 1;
		$prev = $page - 1;
		$next = $page + 1;
		$lastpage = ceil($total_pages/$limit);
		$lpm = $lastpage + 1;
		$pagination = $page_description = "";
		
		if($lastpage > 1 || $this->loadDefault){
			$pagination .= ' 
			<div class="pagination">
				<ul>';
					
					// first
					if($page > 1){
						if($this->pgprev){
							$pagination .=  ($loadpage == 'normal') ? '<li><a href="'.$targetpage.$prev.'">Prev</a></li>' : '<li><a href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$prev.'\',\''.$target.'\',\'\')">Prev</a></li>';
						}
					}else{
						if($this->pgprev){
							$pagination .= '<li class="disabled"><a href="#">Prev</a></li>';
						}
					}
							
					// number
					for($i= 1;$i<$lpm;$i++){
						if($i == $page){
							if($this->current){
								$pagination.= '<li class="active"><a href="#">'.$i.'</a></li>';}
						}else{
							if($this->pgnumber){
								$pagination.= ($loadpage == 'normal') ? '<li><a href="'.$targetpage.$i.'">'.$i.'</a></li>':'<li><a href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$i.'\',\''.$target.'\',\'\')">'.$i.'</a>';}
						}
					}
							
					// last
					if($page < $lastpage){
						if($this->pgnext){
							$pagination.= ($loadpage == 'normal') ? '<li><a href="'.$targetpage.$next.'">Next</a>' : '<li><a href="javascript:void(0);" onclick="loadAjax(\''.$targetpage.$next.'\',\''.$target.'\',\'\')">Next</a>';}
					}else{
						if($this->pgnext){$pagination.= '<li class="disabled"><a href="#">Next</a></li>';}
					}
					$pagination .= ' 
				</ul>
			</div>';
		}
		return array($pagination,$page_description,$result);
		
	}
}
?>  