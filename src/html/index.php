<?

if(!isset($_SESSION['Platform']))
  $_SESSION['Platform']=10000;

if(!isset($_SESSION['produk_list']))
  $_SESSION['produk_list']=1;

$st='';
$lnk='';
$mode='Testnet';
if(!strpos($_SERVER['SERVER_NAME'],'estnet.')){
  $st='checked';
  $lnk='testnet.';
  $mode='Mainnet';
}
if ( (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) && (!empty($_SERVER['HTTP_X_CSRF_TOKEN'])) && (isset($_SESSION['Platform'])) ) {
 ?>
<link rel="stylesheet" href="/assets/css/color.min.css?u=<?= strtolower($_SERVER['HTTP_X_CSRF_TOKEN']); ?>&v=<?= $_SESSION['Platform']; ?>&t=<?= $_SESSION['time']; ?>" />

<? } ?>

<style>
.lnk_icon{
border-radius: 50%;
}

.modal-body .form-floating > .form-control:not(:placeholder-shown) ~ label {
  opacity: .65;
  transform:scale(0.8) translateX(0.5rem);
}
.spek{
font-size:90%;
}
footer {
  margin-bottom:75px;
}

.nav-gdh{
padding:0px;
margin-bottom:20px;
text-align:center;
overflow-x:auto;
padding-bottom:5px;
}
.nav-gdh>ul{
display:inline-flex;
list-style:none;
padding:0px;
margin:0px;
}
.nav-gdh>ul>li{
margin-left:5px;
text-align:center;
float:left;
border:1px solid #fff;
padding:10px 5px 15px;
border-radius:5px;
background-color:var(--menu-color);
text-shadow:0px 1px 1px #ffffff, 0 -1px 1px #000000;
min-width:120px;
cursor:pointer;
user-select:none;
white-space: nowrap;
}
.nav-gdh>ul>li:first-child{
margin-left:0px;
}
.nav-gdh>ul>li .lnk{
  font-size:75%;
}
.nav-gdh>ul>li .fad{
font-size:300%;
margin:5px;
}
.nav-main{
padding:0px;
margin-bottom:20px;
}
.nav-main>ul{
display:inline-flex;
list-style:none;
padding:0px;
margin:0px;
}
.nav-main>ul>li{
margin-left:5px;
text-align:center;
float:left;
padding:5px 2px;
cursor:pointer;
user-select:none;
}
.nav-main>ul>li:first-child{
margin-left:0px;
}

.plnk{
  cursor:pointer;
  -webkit-user-select:none;
  -ms-user-select:none;
  user-select:none;
  box-shadow:-1px -2px 1px var(--menu_03-color) inset;
}
.down{
box-shadow:1px 2px 1px var(--menu_03-color) inset;
}

</style>

<section class="content-header">
  <h1 style="z-index:1;margin-top:15px;">
    <?
if($_SESSION['Platform']<10000){
    if ($_SESSION['Platform']==2) echo "GDH-PiMart";
    else if ($_SESSION['Platform']==3) echo "GDH-PiCar";
    else if ($_SESSION['Platform']==4) echo "GDH-PiFashion";
    else if ($_SESSION['Platform']==5) echo "GDH-Tour & travel";
    else if ($_SESSION['Platform']==6) echo "GDH-Property";
    else echo "GDH-{$pi}Jewellery";
}else{
echo "PT. GDH Market Pi Ecosystem";
}    
     ?>
  </h1>
</section>
<?
include( TEMPLATE_FOLDER . PHP_DS. "src". PHP_DS. "html" . PHP_DS. "order.php");


if ( ( isPiBrowser() ) || (SUB_DOMAIN.".com" == MAIN_DOMAIN) ){ ?>
<div class="row">
<div class="line"><span class="tile-caption">Golden Diamond Harisa Core Business</span></div>
</div>

<nav class="nav-gdh">
<ul>
<li class="<?= ($_SESSION['Platform']==10000)?"down":"plnk"; ?>" onclick="set_platform(10000);"><i class="fad fa-cart-shopping-fast"></i><br>GDH-<?=$pi;?>Ekosistem UMKM</li>
<li class="<?= ($_SESSION['Platform']==1)?"down":"plnk"; ?>" onclick="set_platform(1);"><i class="fad fa-gem"></i><br>GDH-<?=$pi;?>Jewellery</li>
<li class="<?= ($_SESSION['Platform']==2)?"down":"plnk"; ?>" onclick="set_platform(2);"><i class="fad fa-shopping-basket"></i><br>GDH-<?=$pi;?>Mart</li>
<li class="<?= ($_SESSION['Platform']==3)?"down":"plnk"; ?>" onclick="set_platform(3);"><i class="fad fa-car"></i><br>GDH-<?=$pi;?>Car</li>
<li class="<?= ($_SESSION['Platform']==4)?"down":"plnk"; ?>" onclick="set_platform(4);"><i class="fad fa-ski-boot"></i><br>GDH-<?=$pi;?>Fashion</li>
<li class="<?= ($_SESSION['Platform']==5)?"down":"plnk"; ?>" onclick="set_platform(5);"><i class="fad fa-person-walking-luggage"></i><br>GDH-Tour & Travel</li>
<li class="<?= ($_SESSION['Platform']==6)?"down":"plnk"; ?>" onclick="set_platform(6);"><i class="fad fa-mountain-city"></i><br>GDH-Property</li>
</ul>
</nav>
<hr>
<script>
function set_platform(id){
PostJSON("/form/set_platform.php","id="+id,function(){
load("/");
});  
};
</script>
<? }


if($_SESSION['Platform']<10000){
  if($_SESSION['Platform']==6)
    include(dirname(__FILE__). PHP_DS. 'main_property.php');
  else if($_SESSION['Platform']==5)
    include(dirname(__FILE__). PHP_DS. 'main_travel.php');
  else if($_SESSION['Platform']<5)
    include(dirname(__FILE__). PHP_DS. 'main_gdh.php');
  else
    include(dirname(__FILE__). PHP_DS. 'main_progress.php');
}else{
  include(dirname(__FILE__). PHP_DS. 'main_seller.php');
}



 } 
}
?>
