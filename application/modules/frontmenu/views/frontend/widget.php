<?php 
$this->model = $this->load->model('project/Project_frontmodel');
$module = $this->request->getModuleName();
$action = $this->request->getActionName();
?>
<div id="logo">
    <a href="index.php">
        <img src="<?php echo DIR_PUBLIC?>layout/default/images/logo.gif" alt="flora ville คอนโด | บ้านเดี่ยว">
    </a>
</div><!--logo-->





<div id="mob-menu">
    <div id="mobtoggle"></div><!--mobtoggle-->
    <div class="closebtn"></div><!--closebtn-->
</div><!--mob-menu-->

<div class="clearfix"></div>
<div id="mobmenu-container">
<ul>
        <li><span><a href="index.php">HOME</a></span></li>
        <li><span>CONDOMINIUM</span>
          <div>
              <p>คอนโดศรีนครินทร์-พัฒนาการ</p>
              <img src="<?php echo DIR_PUBLIC?>layout/default/images/list/condo1.jpg" alt="home">
          </div>
        </li>
        <li><span>SINGLE HOUSE</span>
          <div>
              <a href="project.php">
              <p>บ้านเดี่ยวศรีนครินทร์</p>
              <img src="<?php echo DIR_PUBLIC?>layout/default/images/list/home1.jpg" alt="home">
              </a>
              
              <a href="project.php">
              <p>บ้านเดียวสุวินทวงศ์</p>
              <img src="<?php echo DIR_PUBLIC?>layout/default/images/list/home2.jpg" alt="home">
              </a>
              
              <a href="project.php">
              <p>บ้านเดี่ยวรังสิต-เปรมประชา</p>
              <img src="<?php echo DIR_PUBLIC?>layout/default/images/list/home1.jpg" alt="home">
              </a>
          </div>
        </li>
        <li><span>TOWNHOUSE</span></li>
        <li><span>HOME OFFICE</span></li>
        <li><span>SERVICE APARTMENT</span></li>
        <li><span>NEWS &amp; PROMOTION</span></li>
        <li><span>CORPORATE</span></li>
</ul>
</div><!--mobmenu-container-->

            
<div id="menu-wrapper">
   
    <div class="inner">
        <div id="menu-shadow">
            
        </div><!--menu-shadow-->
    <ul style="display:none;">
        <li id="s1">CONDOMINIUM</li>
        <li id="s2">SINGLE HOUSE</li>
        <li id="s3">TOWNHOUSE</li>
        <li id="s4">HOME OFFICE</li>
        <li id="s5">SERVICE APARTMENT</li>
        <li id="s5">NEWS &amp; PROMOTION</li>
        <li id="s6">CORPORATE</li>
    </ul>
    
   <ul id="thaimenu">
        <li id="s1"></li>
        <li id="s2"></li>
        <li id="s3"></li>
        <li id="s4"></li>
        <li id="s5"></li>
        <li id="s6"></li>
        <li id="s7"></li>
        <li id="s8"></li>
    </ul>
    </div><!--inner-->
    
    <div id="subwrapper">
        <div id="subinner">
           
              <div class="tsub" id="condowrap">
                <a href="project.php"><img src="<?php echo DIR_PUBLIC?>layout/default/images/fcondo_02.png"></a>
              </div><!--condowrap-->
              
              <div class="tsub" id="singlehousewrap">
                <a href="project.php"><img src="<?php echo DIR_PUBLIC?>layout/default/images/shouse_02.png"></a>
              </div><!--singlehousewrap-->
              
              <div class="tsub" id="townhousewrap">
                <a href="project.php"><img src="<?php echo DIR_PUBLIC?>layout/default/images/stownhouse_02.png"></a>
              </div><!--townhousewrap-->
              
              <div class="tsub" id="homeofficewrap">
                <a href="project.php"><img src="<?php echo DIR_PUBLIC?>layout/default/images/shomeoffice_02.png"></a>
              </div><!--homeofficewrap-->
              
              <div class="tsub" id="serviceaptwrap">
                <a href="serviced-apartment.php"><img src="<?php echo DIR_PUBLIC?>layout/default/images/sservice_02.png"></a>
              </div><!--serviceaptwrap-->
              
              <div class="tsub" id="promotionwrap">
                  <div class="colblock">
                      <a href="promotion-detail.php">
                          <img src="<?php echo DIR_PUBLIC?>layout/default/images/article/down.jpg">
                          <h4>จองคอนโดในช่วงสงกรานต์ รับ iPad Mini</h4></a>
                          <span>13-16 MAY 2013</span>
                          <p>Praesent sodales venenatis lectus vel varius. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis hendrerit sed posuere.</p>
                      
                  </div>
                  <div class="colblockright">
                      <a href="promotion-detail.php"><img src="<?php echo DIR_PUBLIC?>layout/default/images/article/p1.jpg">Lorem ipsum dolor sit amet, consectetur adipisicing elit
          
                      <span>13-16 MAY 2013</span></a>
                      <a href="promotion-detail.php">Lorem ipsum dolor sit amet, consectetur adipisicing elit
                      <span>13-16 MAY 2013</span></a>
                      
                      <div class="alldetail"><a class="css3button" href="promotion.php">ดูโปรโมชั่นทั้งหมด</a></div>

                  </div>
              </div><!--promotionwrap-->
              
              <div class="tsub" id="careerwrap">
                <div class="colblock">
                    <a href="career.php"><img src="<?php echo DIR_PUBLIC?>layout/default/images/employee.jpg"></a>
                </div><!--colblock-->
                <div class="colblockright">
                    <h4>ตำแหน่งงานใหม่</h4>
                    <a href="career-detail.php">ผู้รับเหมา</a>
                    <a href="career-detail.php">วิศวกรโยธา</a>
                    <a href="career-detail.php">พนักงานฝ่ายขาย</a>
                    <a href="career-detail.php">พนักงานรักษาความปลอดภัย</a>

                </div><!--colblockright-->
              </div><!--careerwrap-->
              
              <div class="tsub" id="contactwrap">
                <div class="colblock">
              <div id="contactf">
              
              <form action="/">
                  <fieldset>
                      <label for="name">ชื่อ นามสกุล</label>
                      <input type="text" id="name" class="form-text" />
                  </fieldset>
                  
                  <fieldset>
                      <label for="email">อีเมล์</label>
                      <input type="email" id="email" class="form-text" />
                  </fieldset>
                  
                  
              
                  <fieldset>
                      <label for="url">เบอร์โทร</label>
                      <input type="url" id="url" class="form-text" placeholder="" />
                  </fieldset>
              
                  <fieldset>
                      <label for="bio">รายละเอียด</label>
                      <textarea id="bio"></textarea>
                  </fieldset>
                  
                  
              
                  <fieldset class="form-actions">
                      <input type="submit" value="Submit" />
                  </fieldset>
              </form>			
  
              </div>
                </div><!--colblock-->
                <div class="colblockright">
                     <h7 style="font-size:26px;">ติดต่อฟลอร่าวิล</h7>
                            <span class="spancontact">5/32 Sukhumvit 54 Road, Bangchak<br/> 
                          Khet Prakanong, Bangkok 10260</span>
                          
                          <span class="spancontact" style="font-size:22px; margin-bottom:30px;">Tel : 087-344-2557</span>
                          
                          <a class="group3" href="<?php echo DIR_PUBLIC?>layout/default/images/map-l.jpg"><img src="<?php echo DIR_PUBLIC?>layout/default/images/map.jpg"></a>
                                                                                                          
                </div><!--colblockright-->
              </div><!--contactwrap-->
            
                                    
            
            
            
            
            
        </div><!--subinner-->
    </div><!--subwrapper-->
    
</div><!--menu-wrapper-->

<?php /*?><header>
    <div id="header-wrapper">
        <div id="top-wrapper" class="clearfix">
            <div id="logo">
                <a href="<?php echo DIR_ROOT;?>">
                    <img src="<?php echo DIR_PUBLIC?>layout/default/images/logo.png">
                </a>
            </div><!--logo-->
        

            <div id="smartphone-nav-wrapper">
                <form name="event_type_selector" method="post" action="#">
                    <select name="url_list" class="event-type-selector-dropdown" onchange="gotosite()">
                        <option value="" selected="selected" disabled="disabled">Go To...</option>
                        <option value="http://google.com">PRODUCT</option>
                        <option value="?id=2">REFERENCE</option>
                        <option value="?id=3">NEWS &#38; ACTIVITY</option>
                        <option value="?id=2">FAQ</option>
                        <option value="?id=2">ABOUT US</option>
                        <option value="?id=2">CONTACT US</option>
                    </select>
                </form><!--form-->
            </div><!--smartphone-nav-wrapper-->

            
            <nav>
                <ul>
                    <li id="home"><a href="<?php echo DIR_ROOT;?>">HOME</a></li>
                    <li id="productnav" <?php if($module=='product') echo 'class="active"'; ?>><a href="<?php echo DIR_ROOT;?>categories">PRODUCT</a>
                        <div id="subwrapper">
                        	<div id="innersub">
                    		<div class="subcatnav">
                            	<?php 
								if(!empty($menuPro)){
                               		foreach($menuPro as $menuPro){
                                    	$categories_id = $menuPro['product_categories_id'];
                                    	$categories_name = $menuPro['product_categories_name'];
										
										$menuSub = $this->model->listCategoriesFront($categories_id);
										if(!empty($menuSub)){
                                			echo '<h1><a style="text-shadow:none;" href="'.DIR_ROOT.'categories/frontend/index/cat/'.$categories_id.'">'.$categories_name.'
                                			<strong class="vall">View all</strong></a>
                                			</h1>';
											$listCategories = $this->model->listCategoriesFront($categories_id);
											if(!empty($listCategories)){
												echo '<ul>';
												foreach($listCategories as $list){
													$categories_id = $list['product_categories_id'];
													$categories_name = $list['product_categories_name'];
													
													$product_id = 0;
													$getProduct = $this->model->listProductFront($categories_id,1);
													if(!empty($getProduct)){
														$product_id = $getProduct['product_id'];
													}
													echo '<li>';
														
														
														$listSubCat = $this->model->listCategoriesFront($categories_id);
														if(empty($listSubCat)){
															echo '<a '; if($product_id!=0) echo ' href="'.DIR_ROOT.'product/frontend/index/id/'.$product_id.'"'; echo '>'.$categories_name.'</a>';
														}else{
															echo '<span>'.$categories_name.'</span><ul class="incat">';
															
															foreach($listSubCat as $listSub){
																$sub_categories_id = $listSub['product_categories_id'];
																$sub_categories_name = $listSub['product_categories_name'];
													
																$sub_product_id = 0;
																$getProduct = $this->model->listProductFront($sub_categories_id,1);
																if(!empty($getProduct)){
																	$sub_product_id = $getProduct['product_id'];
																}
																echo '<li><a '; if($sub_product_id!=0) echo ' href="'.DIR_ROOT.'product/frontend/index/id/'.$sub_product_id.'"'; echo '>'.$sub_categories_name.'</a></li>';
															}
															echo '</ul>';
														}
														echo '</li>';
												}
												echo '</ul>';
											}
										}
									}
								}
								?>
                                    
                                <div class="clearfix"></div>
                            </div><!--subcatnav-->
                            </div><!--innersub-->
                            
                        </div><!--subwrapper-->
                    </li>
                    <li id="ref" <?php if($module=='reference') echo 'class="active"'; ?>><a href="<?php echo DIR_ROOT;?>reference">REFERENCE</a></li>
                    <li id="news" <?php if($module=='news') echo 'class="active"'; ?>><a href="<?php echo DIR_ROOT;?>news">NEWS &#38; ACTIVITY</a></li>
                    <li id="faq" <?php if($module=='faq') echo 'class="active"'; ?>><a href="<?php echo DIR_ROOT;?>faq">FAQ</a></li>
                    <li id="about" <?php if($module=='aboutus') echo 'class="active"'; ?>><a href="<?php echo DIR_ROOT;?>aboutus">ABOUT US</a></li>
                    <li id="contact" <?php if($module=='contactus') echo 'class="active"'; ?>><a href="<?php echo DIR_ROOT;?>contactus">CONTACT US</a></li>
                </ul>
            </nav><!--nav-->
        </div><!--top-wrapper-->
    </div><!--header-wrapper-->
</header><!--header--><?php */?>