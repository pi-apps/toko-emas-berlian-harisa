<?
$_SESSION['pi_auth'] = $_POST;
$_SESSION['pi_accessToken'] = $_POST['accessToken'];

if( (isset($_POST['user[username]'])) && (!isset($_POST['user']['username'])) ){
  $_POST['user']['uid'] = $_POST['user[uid]'];
  $_POST['user']['username'] = $_POST['user[username]'];
}

if(!empty(trim($_POST['user']['username']))){
  $_SESSION['pi_uid'] = $_POST['user']['uid'];
  $_SESSION['pi_username'] = $_POST['user']['username'];
  $testnet='1';
  
    $cek = mysql_fetch_assoc(mysql_query("SELECT * from ".APP_DATABASE.".t_user WHERE username='{$_SESSION['pi_username']}' LIMIT 1"));
    if(empty($cek['username'])){
       mysql_query("INSERT INTO ".APP_DATABASE.".t_user (username) VALUES('{$_SESSION['pi_username']}')");
    }
}

  $_POST['session_id']=my_session_id();
  $_POST['session']=$_SESSION;

header("Content-Type: application/json; charset=utf-8");
echo json_encode($_POST);
?>
