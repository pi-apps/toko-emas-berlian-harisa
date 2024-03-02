<?
include(dirname(dirname(__FILE__)). PHP_DS. 'sdk.php');

$pi = new PiNetwork(PI_API_KEY, '');
$ret = $pi->CancelPayment($_POST);
 unset( $_SESSION['Order'] ); 
 
header("Content-Type: application/json; charset=utf-8");
  $result=array();
  $result["Kode"]=1;
  $result["Style"]="info";
  $result["Title"]="Informasi";
  $result["Message"]="Pembayaran Pi Network anda telah dibatalkan.";
echo json_encode($result); 
