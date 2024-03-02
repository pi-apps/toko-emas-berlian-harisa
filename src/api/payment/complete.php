<?
include(dirname(dirname(__FILE__)). PHP_DS. 'sdk.php');

$pi = new PiNetwork(PI_API_KEY, '');
$ret = $pi->CompletePayment($_POST);
if($ret){

  $ref=$ret;
  $ret= json_decode($ret, true);
  $status=$ret['status'];  
  
  header("Content-Type: application/json; charset=utf-8");
    $result=array();
    $result["Kode"]=1;
    $result["Style"]="success";
  $result["ret"]=$ret;
  $meta=$ret['metadata'];
  $result["meta"]=$meta;
  
  if( ($status['transaction_verified']) && ($status['developer_completed']) ){  
    $jml= $ret['amount'];
    $wallet=$ret['from_address'];
    $_SESSION['Pi_Wallet']=$wallet;
    $mode=1;
    $retok=true;
    $id_trx=-1;
$test=true;
    if($retok){
        $result["Title"]="Sukses";
        $result["Message"]="Proses Pembayaran Pi Network Sukses. Terima Kasih...";
if($meta['Src']=='GDH'){
      $platform=$meta['Platform'];
      if( (isset($_SESSION['Order'][$platform])) && (count($_SESSION['Order'][$platform])>0) ){
        $order=$_SESSION['Order'][$platform];

        $tbl='t_trx';
        $tbl_detail='t_trx_detail';
        if(strpos($_SERVER['SERVER_NAME'],'estnet.')){
          $tbl='t_trx_testnet';
          $tbl_detail='t_trx_testnet_detail';
        }

  if($platform==1){
    $table="t_product_jewellery";
    $seller="jewellery";
  }else if($platform==2){
    $table="t_product_mart";
    $seller="mart";
  }else if($platform==3){
    $table="t_product_car";
    $seller="car";
  }else if($platform==4){
    $table="t_product_fashion";
    $seller="fashion";
  }
  $seller=$meta['Seller'];
        mysql_query("INSERT INTO ".APP_DATABASE.".$tbl (User,Platform,Seller,Detail) VALUES('{$_SESSION['pi_username']}','{$platform}','{$seller}','".json_encode($order)."')");
        $q= mysql_fetch_assoc(mysql_query("select * from ".APP_DATABASE.".$tbl WHERE user='{$_SESSION['pi_username']}' ORDER By ID Desc LIMIT 1"));
        $id_trx = $q['ID'];
        $ttl=0;
        $ttl_pi=0;
        
        foreach($order as $x => $val) {
        
          $qry= mysql_fetch_assoc(mysql_query("select * from ".DB_ADMIN.".`{$table}` WHERE ID='{$val['id']}' LIMIT 1"));
          $harga = $qry['Harga']; 
          $harga_pi = Rp2Pi( $qry['Harga'] ); 
          
          $jml = floatval( $val['jml'] );
          $ttl +=  $jml * floatval( $harga );
          $ttl_pi +=  $jml * floatval( $harga_pi );
          
          $harga= send_satoshi($harga);          
          $harga_pi= send_satoshi($harga_pi);          
          
          mysql_query("INSERT INTO ".APP_DATABASE.".$tbl_detail (TrxID,ProductID, Jml,  Harga, Total_pi) VALUES('{$id_trx}','{$val['id']}','{$jml}','{$harga}','{$harga_pi}')");

        }

        $ttl= send_satoshi($ttl);          
        $ttl_pi= send_satoshi($ttl_pi);          

        mysql_query("UPDATE ".APP_DATABASE.".$tbl SET Total='{$ttl}', Total_pi='{$ttl_pi}' WHERE ID='{$id_trx}' LIMIT 1");
      }
}else if($meta['Src']=='Seller'){
      $platform=$meta['Platform'];
      if( (isset($_SESSION['Order'][$platform])) && (count($_SESSION['Order'][$platform])>0) ){
        $order=$_SESSION['Order'][$platform];

        $tbl='t_trx';
        $tbl_detail='t_trx_detail';
        if(strpos($_SERVER['SERVER_NAME'],'estnet.')){
          $tbl='t_trx_testnet';
          $tbl_detail='t_trx_testnet_detail';
        }

        $table="t_seller_product";
        $seller=$meta['Seller'];
  
        mysql_query("INSERT INTO ".APP_DATABASE.".$tbl (User,Platform,Seller,Detail) VALUES('{$_SESSION['pi_username']}','{$platform}','{$seller}','".json_encode($order)."')");
        $q= mysql_fetch_assoc(mysql_query("select * from ".APP_DATABASE.".$tbl WHERE user='{$_SESSION['pi_username']}' ORDER By ID Desc LIMIT 1"));
        $id_trx = $q['ID'];
        $ttl=0;
        $ttl_pi=0;
        
        foreach($order as $x => $val) {
        
          $qry= mysql_fetch_assoc(mysql_query("select a.*,b.NoSeri AS Seri, (a.Harga / 15000 / b.NilaiPi)  AS Harga_Pi from ".APP_DATABASE.".t_seller_product a, ".APP_DATABASE.".t_seller b  WHERE b.UserName=a.UserName AND a.ID='{$val['id']}' LIMIT 1"));

          mysql_query("UPDATE ".APP_DATABASE.".t_seller_product SET Tgl_Buy=CURRENT_TIMESTAMP WHERE ID='{$val['id']}' LIMIT 1");

          
          $harga_pi =  $qry['Harga_Pi'] ; 
        
          $jml = floatval( $val['jml'] );
          $ttl +=  $jml * floatval( $harga_pi );
          $ttl_pi +=  $jml * floatval( $harga_pi );
          
         
          mysql_query("INSERT INTO ".APP_DATABASE.".$tbl_detail (TrxID,ProductID,Seller, Jml,  Harga, Total_pi) VALUES('{$id_trx}','{$val['id']}','{$qry['Seri']}','{$jml}','{$harga_pi}','{$harga_pi}')");

        }
        $ttl= send_satoshi($ttl);          
        $ttl_pi= send_satoshi($ttl_pi);          

        mysql_query("UPDATE ".APP_DATABASE.".$tbl SET Total='{$ttl}', Total_pi='{$ttl_pi}' WHERE ID='{$id_trx}' LIMIT 1");
      }
}

      unset( $_SESSION['Order'] ); 

    }
  }  
  echo json_encode($result);

}
