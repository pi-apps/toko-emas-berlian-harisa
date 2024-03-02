<pre><?
include(dirname(dirname(__FILE__)). PHP_DS. 'sdk.php');

$pi = new PiNetwork(PI_API_KEY, '');
$ret = $pi->InCompletePayment($_POST);
 unset( $_SESSION['Order'] ); 
 echo "Terima kasih, Transfer anda berhasil diproses";
?></pre>
