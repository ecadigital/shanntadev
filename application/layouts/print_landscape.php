
<head>
	<?php $layout = 'print_landscape';?>
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

#content{ width:1080px;}

.form_page{ width:200px; font-size:12px; text-align:right; float:right; top:-15px; margin-right:10px;position:absolute; }

.form_head{ text-align:center; font-size:20px;}

.table_content
{	
	position:relative;
	width: 100%;
	text-align: left;
	border-collapse: collapse;
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
	border: 1px solid #999;
	border-bottom: none;
	border-right: none;
}

.table_content tbody td
{
	padding:6px;
	border: 1px solid #999;
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



</STYLE> 

</head>

<body>
	<?php echo $content?>
</body>

</html>