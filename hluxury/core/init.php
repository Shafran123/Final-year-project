<?php
$db = mysqli_connect('localhost','root','project','accounts');

if(mysqli_connect_errno()) {
  echo 'Database connection failed with following errors: '. mysqli_connect_error();
  die();

}
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/hluxury/config.php';
require_once BASEURL.'helpers/helpers.php';

    //unset($_COOKIE['customer_id']);

$cart_id = '';
if(isset($_COOKIE[CART_COOKIE])){
  $cart_id = sanitize($_COOKIE[CART_COOKIE]);
}

if (!isset($_SESSION['currency']))
  $_SESSION['currency'] = 'POUND';

$currency = $_SESSION['currency'];

if(isset($_SESSION['SBUser'])){
  $user_id = $_SESSION['SBUser'];
  $query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
  $user_data = mysqli_fetch_assoc($query);
  $fn = explode(' ', $user_data['full_name']);
  $user_data['first'] = $fn[0];
  $user_data['last'] = $fn[1];
}

if(isset($_SESSION['success_flash'])){
  echo '<div id="mydiv" class="bg-success" style="height:40px"><p class="text-success text-center">'.$_SESSION['success_flash'].' <div>';
  unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
  echo '<div id="mydiv" class="bg-danger" style="height:20px"><p class="text-danger text-center">'.$_SESSION['error_flash'].' <div>';
  unset($_SESSION['error_flash']);

}

function currencyConverter($currency_mode, $amount) {
  if (strtolower($currency_mode) == 'usd') {
    return ' $'.intval($amount* 1.43);
  } else {
    return ' £'.$amount;
  }
}

function removeCookie($cookie_name) {
  setcookie($cookie_name, null, -1, "/");
}
