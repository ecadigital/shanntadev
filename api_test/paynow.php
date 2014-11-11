<?php
include("nusoap/nusoap.php");
$url = "https://www.paysbuy.com/api_paynow/api_paynow.asmx?WSDL";
$client = new nusoap_client($url, true);
//print_r($_POST);
$psbID = $_POST['idaccount'];
$username = $_POST['youraccount'];
$secureCode = $_POST['securecode'];
$inv = $_POST['invoice'];
$itm = $_POST['description'];
$amt = $_POST['price'];//"Price of product";
$paypal_amt = $_POST['price'];//"Price of product (US Dolla Only)";
$curr_type = "TH";
$com = "";
$method = $_POST['method'];//"1"; //1=PAYSBUY Account, 2=Credit Card
$language = "T";

//Change to your URL
$resp_front_url = $_POST['postURL'];
$resp_back_url = $_POST['postURL'];

//Optional data
$opt_fix_redirect = "";
$opt_fix_method = "1";
$opt_name = "";
$opt_email = "";
$opt_mobile = "";
$opt_address = "";
$opt_detail = "";

$result = "";

//1. Step 1 call method api_paynow_authentication
$params = array("psbID"=>$psbID, "username"=>$username, "secureCode"=>$secureCode, "inv"=>$inv, "itm"=>$itm, "amt"=>$amt, "paypal_amt"=>$paypal_amt, "curr_type"=>$curr_type, "com"=>$com, "method"=>$method, "language"=>$language, "resp_front_url"=>$resp_front_url, "resp_back_url"=>$resp_back_url, "opt_fix_redirect"=>$opt_fix_redirect, "opt_fix_method"=>$opt_fix_method, "opt_name"=>$opt_name, "opt_email"=>$opt_email, "opt_mobile"=>$opt_mobile, "opt_address"=>$opt_address, "opt_detail"=>$opt_detail);

$result = $client->call('api_paynow_authentication_new', array('parameters' => $params), 'http://tempuri.org/', 'http://tempuri.org/api_paynow_authentication_new', false, true);

if ($client->getError()) {
	//echo "<h2>Constructor error</h2><pre>" . $client->getError() . "</pre>";
} else {
	$result = $result["api_paynow_authentication_newResult"];
}

//echo "<br>result ->".$result;

$approveCode = substr($result, 0, 2);

//echo "<br>approveCode->".$approveCode;

$intLen = strlen($result);
$strRef = substr($result, 2, $intLen-2);

//2. If authentication is successful, then the server responds 00, The process continues redirect to PAYSBUY API Page.
if($approveCode=="00") {
	echo "<meta http-equiv='refresh' content='0;url=https://www.paysbuy.com/api_payment/paynow.aspx?securecode=".$strSecureCode."&refid=".$strRef."'>";
}else{
	echo "<br>Can't login to paysbuy server";
}
?>