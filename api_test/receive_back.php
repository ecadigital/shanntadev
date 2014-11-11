<?php
//1. Recive data from PAYSBUY with POST Method.
$strResult = trim($_REQUEST["result"]);
$strApCode = trim($_REQUEST["apCode"]);
$strAmt = trim($_REQUEST["amt"]);
$strMethod =  trim($_REQUEST["method"]);

/*
$strResult = "002009060101";       
$strApCode ="301001";
$strAmt = "1.00";
$strMethod =  "00";
*/	

if(($strResult != "") && ($strApCode != "") && ($strAmt != "") && ($strMethod != "")){
	$len = strlen($strResult);
	$payment_status  = substr($strResult, 0,2);
	$strInvoice =  substr($strResult, 2,$len-2);

	//2 Insert data from PAYSBUY into the database.
	if (!$link = mysql_connect('localhost', 'root', '')) {
		echo 'Could not connect to mysql';
		exit();
	}

	if (!mysql_select_db('api_db', $link)) {
		echo 'Could not select database';
		exit();
	}
	
	$sql =  "INSERT INTO payment(PaymentResult, PaymentApCode,  PaymentAmt, PaymentMethod, PaymentDate,PaymentInvoice, PaymentStatus )VALUES ('$strResult', '$strApCode', '$strAmt', '$strMethod', NOW(),'$strInvoice','$payment_status' )";

	$result = mysql_query($sql, $link);

	if (!$result) {
		echo "DB Error, could not query the database\n";
		echo 'MySQL Error: ' . mysql_error();
		exit();
	}

	mysql_close($link);

} else {
	//insert error log into table
}
?> 