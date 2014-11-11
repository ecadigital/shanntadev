<?php
$IsTrue = "false";

//1. Recive data from PAYSBUY with POST Method.
$strResult = trim($_REQUEST["result"]);
$strApCode = trim($_REQUEST["apCode"]);
$strAmt = trim($_REQUEST["amt"]);
$strMethod =  trim($_REQUEST["method"]);

/*
	$strResult      =  "002009060101";       
	$strApCode ="301001";
	$strAmt = "1.00";
	$strMethod =  "00";
*/	

if(($strResult != "") && ($strApCode != "") && ($strAmt != "") && ($strMethod != "")) {

	$len = strlen($strApCode);
	$payment_status  = substr($strApCode, 0,2);
	$strInvoice =  substr($strApCode, 2,$len-2);           

	//2. Compare data between frontend process and backend process. 
    $IsTrue = checkBackEndProcess($strResult,$strApCode,$strAmt);

	if($IsTrue) {
		//Delivery the product to customer.
		echo "<br>This transaction is complete.";
	} else {
		 echo "<br>This transaction is uncomplete.";
	}
} else {
	echo "<br>Can't receive data from paysbuy";
}

//**************************************** Function checkBackEndProcess *****************************************************//

function checkBackEndProcess($strResult, $strApCode, $strAmt) {
	$isBackend = "true";
	$strResultB="";	
	$strApCodeB="";
	$strAmtB="";

	if (!$link = mysql_connect('localhost', 'root', '')) {
		echo 'Could not connect to mysql';
		exit();
	}

	if (!mysql_select_db('api_db', $link)) {
		echo 'Could not select database';
		 exit();
	}

	$sql    = 'SELECT * FROM payment WHERE PaymentResult= '.$strResult;
	$result = mysql_query($sql, $link);

	if (!$result) {
		echo "DB Error, could not query the database\n";
		echo 'MySQL Error: ' . mysql_error();
		exit();
	}

	while ($row = mysql_fetch_assoc($result)) {
		$strResultB =  trim($row['PaymentResult']);
		$strApCodeB =  trim($row['PaymentApCode']);
		$strAmtB =  trim($row['PaymentAmt']);
	}

	if($strResultB!=$strResult){
		$isBackend = "false";
	}

	if($strApCodeB!=$strApCode){
		$isBackend = "false";
	}

	if($strAmtB!=$strAmt){
		$isBackend = "false";
	}

	mysql_free_result($result);
	mysql_close($link);

	return $isBackend;
}

//**************************************** End Function checkBackEndProcess *****************************************************//
?>