<?
include(dirname(dirname(__FILE__)). PHP_DS. 'sdk.php');

$pi = new PiNetwork(PI_API_KEY, '');
$ret = $pi->ApprovalPayment($_POST);

header("Content-Type: application/json; charset=utf-8");
  $result=array();
  $result["Kode"]=0;
  $result["Style"]="success";
  $result["Title"]="Sukses";
  $result["Message"]="Pembayaran Pi Sukses.";
  $result["PARAM"]=$_POST;

$jsret=json_decode($ret, true);

echo json_encode($result);
    
