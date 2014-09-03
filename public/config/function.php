<?php 
$Array_monthTH=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$Array_short_monthTH=array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$Array_dayTH=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$Array_monthEN=array("January","February","March","April","May","June","July","August","September","October","November","December");
$Array_short_monthEN=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$Array_dayEN=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");

function generateMemberCode($member_id){
	return str_pad ( $member_id, 6, "0", STR_PAD_LEFT );	
}

function cutZeroDay($day){
	$arrDay=str_split($day,1);
	if($arrDay[0]==0){ $day=$arrDay[1]; }
	return $day;
}
function addZeroDay($day){
	$arrDay=str_split($day,1);
	if(count($arrDay)==1){ $day='0'.$arrDay[0]; }
	return $day;
}

function set_cookie($name, $value, $expire='', $path='', $domain='', $secure='') {
		
	$value = base64_encode(serialize($value));
	$expire = (empty($expire))?time()+(60*60*24*365):$expire; // 1 year
	$path = (empty($path))?'/':$path;
	$domain = (empty($domain))?(isset( $_SERVER['HTTP_HOST'] ) ? ( ( substr( $_SERVER['HTTP_HOST'], 0, 4 ) == 'www.' ) ? substr( $_SERVER['HTTP_HOST'], 3 ) : '.' . $_SERVER['HTTP_HOST'] ) : ''):$domain;
	$secure = (empty($secure))?false:$secure;
	setcookie($name, $value, $expire, $path, $domain, $secure, true);
}

function fetch_cookie($name) {
	return ( isset( $_COOKIE[$name] ) ) ? unserialize( base64_decode( $_COOKIE[$name] ) ) : NULL;
}
function timeString($datetime,$format='datetime',$type='',$showday=''){
	global $defaultLang,$Array_monthTH,$Array_short_monthTH,$Array_dayTH,$Array_monthEN,$Array_short_monthEN,$Array_dayEN;

	$newDate = '';
	if($datetime != '' && $datetime != '0000-00-00 00:00:00' && $datetime != '0000-00-00'){
		
		list($date,$time) = explode(' ',$datetime);
		list($yy,$mm,$dd) = explode("-",$date);
		
		$dd = cutZeroDay($dd);
		
		if($defaultLang==1){
			$month = ($type=='short') ? $Array_short_monthTH[$mm-1] : $Array_monthTH[$mm-1];
			$year = $yy+543;
			if($format == 'date'){
				$newDate = $dd." ".$month." ".$year;
			}else{ // datetime
				list($h,$i,$s) = explode(":",$time);
				$newDate = $dd." ".$month." ".$year." ".$h.".".$i." น.";
			}
			if($showday!=''){
				$w = date("w",strtotime($datetime));
				$newDate = "วัน".$Array_dayTH[$w]." ที่ ".$newDate;
			}
			
		}else{
			$month = ($type=='short') ? $Array_short_monthEN[$mm-1] : $Array_monthEN[$mm-1];
			if($format == 'date'){
				list($yy,$mm,$dd) = explode("-",$datetime);
				$newDate = $dd." ".$month.", ".$yy;
			}else{ // datetime
				list($date,$time) = explode(' ',$datetime);
				list($yy,$mm,$dd) = explode("-",$date);
				list($h,$i,$s) = explode(":",$time);
				$newDate = $dd." ".$month.", ".$yy." ".$h.".".$i." ".date("a", mktime($h, $i, 0, 0, 0, 0));
			}
		}
	}
	return $newDate;
}
function getSubString($str,$len){
	
	$c = strlen($str);
	$e = 0;
	$t = 0;
	$len_new = 0;
	for ($i = 0; $i < $c; ++$i){
		if(ord($str[$i])==224){
			$t = $t+1;
		}else{
			if(ord($str[$i])<=127){
				$e = $e+1;
			}
		}
		//เช็คว่าเกินจำนวนที่ต้องการหรือไม่
		$len_now = ($t*3)+$e;
		if($len_now<=$len){ //ถ้าจำนวนความยาวยังไม่มากกว่าที่กำหนด
			$len_new = $len_now; //ปรับค่าความยาวใหม่ให้เท่ากับความยาวที่คำนวนได้
		}else{ //ถ้าความยาวเกินที่กำหนด ให้ออกจากลูป
			break;
		}
	}
	$new_str = substr($str,0,$len_new);
	return $new_str;
}

function replacePathSlash($path){

	$search = array('../../../../../../../../../../../../public/','../../../../../../../../../../../public/','../../../../../../../../../../public/','../../../../../../../../../public/',
	'../../../../../../../../public/','../../../../../../../public/','../../../../../../public/','../../../../../public/','../../../../public/','../../../public/','../../public/','../public/');
	$str = str_replace($search,DIR_PUBLIC,$path);
	$new_search = array('src=\'public/','src="public/');
	return str_replace($new_search,'src="'.DIR_PUBLIC,$str);
}


function listCategoriesChild($parent_id){
	$listChild = array();
	
	$sql = "SELECT product_categories_id,product_categories_name
				FROM product_categories
				WHERE product_categories_publish='1'
				AND product_categories_parent_id='".$parent_id."' 
				ORDER BY product_categories_seq ASC";
				
	$arr = mysql_query($sql);
	if(mysql_num_rows($arr)>0){
		while($list = mysql_fetch_array($arr)){
			$listChild[] = array('product_categories_id'=>$list['product_categories_id'],'product_categories_name'=>$list['product_categories_name']);
		}
	}
	return $listChild;
}
function getMenuCategories(){	
	$txt='';
	$listCategories = listCategoriesChild(0);
	
	if(!empty($listCategories)){
		foreach($listCategories as $listCat){
			
			$listChilds = listCategoriesChild($listCat['product_categories_id']);
			
			if(empty($listChilds)){
				$txt .= '<li><a href="product.php?id='.$listCat['product_categories_id'].'" title="'.$listCat['product_categories_name'].'">'.$listCat['product_categories_name'].'</a></li>';
			}else{
				$txt .= '
				<li class="menu">
					<a href="product.php?id='.$listCat['product_categories_id'].'" title="'.$listCat['product_categories_name'].'">'.$listCat['product_categories_name'].'</a>
					<ul>';
					foreach($listChilds as $listChild){
						$txt .= '<li><a href="product.php?id='.$listChild['product_categories_id'].'" title="'.$listChild['product_categories_name'].'">'.$listChild['product_categories_name'].'</a></li>';
					}
					$txt .= '
					</ul>
				</li>';
			}
		}
	}
	return $txt;
}

function pagination_front($thisPage,$countPage,$page,$target,$not_id=''){
	if($countPage!=0){
		if($target==''){
			$pagination = '
			<nav class="pagination align-center">
				<ul>';
				
				if($thisPage==1) 	$pagination .= '<li class="prev active"><a href="javascript:void(0)">&laquo;</a></li>';
				else					$pagination .= '<li class="prev"><a href="'.$page.'page='.$thisPage.'">&laquo;</a></li>';
			
			for($i=1;$i<=$countPage;$i++){
				if($thisPage==$i)	$pagination .= '<li class="active"><a href="javascript:void(0)">'.$i.'</a></li>';
				else					$pagination .= '<li><a href="'.$page.'page='.$i.'">'.$i.'</a></li>';
			}
			
			if($thisPage==$countPage||$countPage==0)	$pagination .= '<li class="next active"><a href="javascript:void(0)">&raquo;</a></li>';
			else														$pagination .= '<li class="next"><a href="'.$page.'page='.$coutPage.'">&raquo;</a></li>';
			
				$pagination .= '
				</ul>
			</nav>';
		}else{
			$pagination = '
			<nav class="pagination align-center">
				<ul>';
				
				if($thisPage==1) 	$pagination .= '<li class="prev active"><a href="javascript:void(0)">&laquo;</a></li>';
				else					$pagination .= '<li class="prev"><a href="javascript:void(0)" onclick="loadNewPage(\''.($thisPage-1).'\',\''.$not_id.'\')">&laquo;</a></li>';
			
			for($i=1;$i<=$countPage;$i++){
				if($thisPage==$i)	$pagination .= '<li class="active"><a href="javascript:void(0)">'.$i.'</a></li>';
				else					$pagination .= '<li><a href="javascript:void(0)" 
				onclick="loadNewPage(\''.$i.'\',\''.$not_id.'\')">'.$i.'</a></li>';
			}
			
			if($thisPage==$countPage||$countPage==0)	$pagination .= '<li class="next active"><a href="javascript:void(0)">&raquo;</a></li>';
			else														$pagination .= '<li class="next"><a href="javascript:void(0)" onclick="loadNewPage(\''.($thisPage+1).'\',\''.$not_id.'\')"">&raquo;</a></li>';
			
				$pagination .= '
				</ul>
			</nav>';
		}
		return $pagination;
	}
}

function getFirstProductImage($mysqli,$product_id){

	$product_images='';
	$arr = $mysqli->query("SELECT product_images_id,product_images_path 
							FROM product_images
							WHERE product_id='".$product_id."' 
							ORDER BY product_images_seq ASC");
	if($arr->num_rows>0){
		$list = $arr->fetch_array(MYSQLI_ASSOC);
		$product_images = (empty($list)) ? '' : $list['product_images_path'];
		
	}
	return $product_images;
}
?>