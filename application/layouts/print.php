
<head>
	<?php $layout = 'print';?>
    <title>Print</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <!-- All CSS -->

    
    <!-- All JS -->
<script language="javascript">//window.print();</script>

<STYLE type=text/css>

#printable { display: block; }
#non-printable { display: none; }

@media print
{
#printable { display: block; }
#header {display:none;}
#footer { display:none; }
}
body{ font-family: "Times New Roman", Times, serif;font-size:12px; padding:5px;}

#content{ width:680px;}
#watermark_cancel
{
   background-image: url(<?php echo DIR_PUBLIC;?>layout/print/images/watermark_cancel.png)repeat-y;
   background-size: 100%; /* CSS3 only, but not really necessary if you make a large enough image */
   position: absolute;
   width: 100%;
   height: 100%;
   margin: 0;
   z-index: 10;
}

.logo{ width:90px; height:80px; float:left; overflow:hidden;}


.form_head{ text-align:center; font-size:20px;}

.company{ width:330px; float:left; left:110px;}
.company div.name{ width:330px; font-size:22px; font-weight:bold; border-bottom:2px solid #999;}
.company div.address{ width:100%; font-size:12px; padding-top:5px;}
.company div.detail{ width:100%; font-size:12px; }
.company div.taxpayer{ width:100%; font-size:12px; padding-top:5px; }

.form_page{ width:200px; font-size:12px; text-align:right; float:right; top:-45px; margin-right:10px;position:absolute; }


.form_type{ width:200px; font-size:16px; height:35px; text-align:center; margin-top:10px; float:right; }
.form_type .name{ width:200px; height:25px; float:right; background:#000000; color:#FFF; padding:8px; font-weight:normal;
	-moz-border-radius: 10px;
    -webkit-border-radius:10px;
    border-radius: 10px; }
/*.form_type .taxpayer{ width:250px; font-size:14px; font-weight:normal; padding:3px 0 0 5px; float:right;  position:relative; text-align:left; }*/
.form_type .page{ width:200px; font-size:14px; text-align:right; float:right; padding:15px 10px 0 0;}

.customer{ width:430px; float:left; border:1px solid #999; padding:8px; margin-top:10px; line-height:22px; font-size:14px; 
	-moz-border-radius: 10px;
    -webkit-border-radius:10px;
    border-radius: 10px; }
.customer .name{ }
.customer .ref{ margin-top:10px; }

.form_detail{ width:210px;  font-size:14px; float:right; border:1px solid #999; padding:8px; text-align:left; margin-top:10px; line-height:22px; font-weight:normal;
	-moz-border-radius: 10px;
    -webkit-border-radius:10px;
    border-radius: 10px; }
/*#content .form_detail .name{ font-size:26px; float:left; font-weight:bold; }*/
.form_detail .detail{ width:100%; padding-left:5px; height:20px; overflow:hidden; }

.sign{ width:100%; /*border:1px solid #999;*/ padding:8px; margin-top:25px; position:relative;font-size:14px; text-align:center;
	-moz-border-radius: 10px;
    -webkit-border-radius:10px;
    border-radius: 10px; }
.sign .box1{ width:33.33%; float:left;}
.sign .box1 div{ height:25px;}
.sign .boxRight{ width:50%; float:right; text-align:right;}
.sign .boxRight div{ height:25px;}



.table_nowatermark
{	
	position:relative;
	width: 100%;
	text-align: left;
	border-collapse: collapse;
}
.table_nowatermark th.head_left
{
	background: #c9c9c9 url('<?php echo DIR_PUBLIC;?>layout/print/images/left.png') left -1px no-repeat;
}
.table_nowatermark th.head_right
{
	background: #c9c9c9 url('<?php echo DIR_PUBLIC;?>layout/print/images/right.png') right -1px no-repeat;
}
.table_nowatermark th
{
	padding: 8px;
	font-weight: bold;
	background: #ddd;
	text-align:center;
	border: 1px solid #ccc;
	border-bottom: none;
	border-right: none;
}

.table_nowatermark tbody td
{
	padding:6px;
	border-right: none;
	border: 1px solid #ccc;
}
.table_nowatermark td
{	
	padding: 6px;
	line-height:40px;
	border: 1px solid #ccc;

}
.table_nowatermark td.foot_left
{
	vertical-align:bottom;
}
.table_nowatermark td.foot_center
{
}


.table_nowatermark td.foot_right
{
	line-height:40px;
}




.table_content
{	
	position:relative;
	width: 100%;
	text-align: left;
	border-collapse: collapse;
	background: url('<?php echo DIR_PUBLIC;?>layout/print/images/watermark_main.png') left repeat-y;
}
.table_content th.head_left
{
	background: #c9c9c9 url('<?php echo DIR_PUBLIC;?>layout/print/images/left.png') left -1px no-repeat;
}
.table_content th.head_right
{
	background: #c9c9c9 url('<?php echo DIR_PUBLIC;?>layout/print/images/right.png') right -1px no-repeat;
}
.table_content th
{
	padding: 8px;
	font-weight: bold;
	background: #c9c9c9;
	text-align:center;
	border: 1px solid #fff;
	border-bottom: none;
	border-right: none;
}

.table_content tbody td
{
	padding:6px;
	border-right: none;
	/*background: #f1f1f1;
	border-left: 1px solid #fff;*/
}
.table_content td
{	
	padding: 6px;
	line-height:40px;
	/*background: #f1f1f1;
	border-left: 1px solid #fff;*/

}
.table_content td.foot_left
{
	vertical-align:bottom;
	/*background: #f1f1f1 url('<?php echo DIR_PUBLIC;?>layout/print/images/botleft.png') left bottom no-repeat;
	border-top: 1px solid #fff;*/
}
.table_content td.foot_center
{
	/*border-top: 1px solid #fff;*/
}


.table_content td.foot_right
{
	/*background: #f1f1f1 url('<?php echo DIR_PUBLIC;?>layout/print/images/botright.png') right bottom no-repeat;*/
	line-height:40px;
}



.table_content_main
{	
	position:relative;
	width: 100%;
	text-align: left;
	border-collapse: collapse;
	background: url('<?php echo DIR_PUBLIC;?>layout/print/images/watermark_main.png') left repeat-y;
}
.table_content_main th.head_left
{
	background: #c9c9c9 url('<?php echo DIR_PUBLIC;?>layout/print/images/left.png') left -1px no-repeat;
}
.table_content_main th.head_right
{
	background: #c9c9c9 url('<?php echo DIR_PUBLIC;?>layout/print/images/right.png') right -1px no-repeat;
}
.table_content_main th
{
	padding: 8px;
	font-weight: bold;
	background: #c9c9c9;
	text-align:center;
	border: 1px solid #fff;
	border-bottom: none;
	border-right: none;
}

.table_content_main tbody td
{
	padding:6px;
	border-right: none;
}
.table_content_main td
{	
	padding: 6px;
	line-height:40px;

}
.table_content_main td.foot_left
{
	vertical-align:bottom;
}
.table_content_main td.foot_center
{
}


.table_content_main td.foot_right
{
	line-height:40px;
}
.table_content_copy
{	
	position:relative;
	width: 100%;
	text-align: left;
	border-collapse: collapse;
	background: url('<?php echo DIR_PUBLIC;?>layout/print/images/watermark_copy.png') left repeat-y;
}
.table_content_copy th.head_left
{
	background: #c9c9c9 url('<?php echo DIR_PUBLIC;?>layout/print/images/left.png') left -1px no-repeat;
}
.table_content_copy th.head_right
{
	background: #c9c9c9 url('<?php echo DIR_PUBLIC;?>layout/print/images/right.png') right -1px no-repeat;
}
.table_content_copy th
{
	padding: 8px;
	font-weight: bold;
	background: #c9c9c9;
	text-align:center;
	border: 1px solid #fff;
	border-bottom: none;
	border-right: none;
}

.table_content_copy tbody td
{
	padding:6px;
	border-right: none;
}
.table_content_copy td
{	
	padding: 6px;
	line-height:40px;

}
.table_content_copy td.foot_left
{
	vertical-align:bottom;
}
.table_content_copy td.foot_center
{
}


.table_content_copy td.foot_right
{
	line-height:40px;
}


<!-- print barcode -->
#boxShowGrid { list-style-type: none; margin: 0; padding: 0; width:<?php echo $boxWGrid;?>mm; left:50%; margin-left:<?php echo $boxGridML;?>mm; position:relative;}
#boxShowGrid li { margin: 0; padding: 0; float: left; width: <?php echo $boxW;?>mm; height: <?php echo $imgH;?>mm; font-size: 9px; text-align: center; overflow:hidden;}
.boxBarcodeName{position:relative; max-height:15px; overflow:hidden;}

</STYLE> 

</head>

<body>
	<?php echo $content?>
</body>

</html>