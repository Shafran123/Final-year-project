<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/hluxury/core/init.php';
// Storing product id from the details modal form:
$product_id = sanitize($_POST['product_id']);
// Storing size of the product from details modal form:
$size = sanitize($_POST['size']);
// Storing available product from details modal form:
$available = sanitize($_POST['available']);
// Storing quantity of product from details modal form:
$quantity = sanitize($_POST['quantity']);
// Making an array which contains data of the product:
$item = array();
// Defining array item
$item[] = array(
	// First column contains the product id:
	'id' => $product_id,
	// Second contains size:
	'size' => $size,
	// Third contains quantity:
	'quantity' => $quantity,


	);

// Defining a variable to hold domain if server http host is not equal to the localhost then return the server http host else return false:
$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
// Select all from products where id match with the product_id from details modal form:
$query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
// Making an associative array:
$product = mysqli_fetch_assoc($query);
// Updating session variable to display message:
$_SESSION['success_flash'] = $product['title'].' added to your cart.';

//Check to see if the cart cookie exist:

if($cart_id != ''){
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$cart = mysqli_fetch_assoc($cartQ);
	$previous_items = json_decode($cart['items'],true);
	$item_match = 0;
	$new_items = array();
	foreach($previous_items as $pitem){
		if($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']){
			$pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
			if($pitem['quantity'] > $available){
				$pitem['quantity'] = $available;
			}
			$item_match = 1;
		}
		$new_items[] = $pitem;
	}
	if($item_match != 1){
		$new_items = array_merge($item,$previous_items);
	}
	$items_json = json_encode($new_items);
	$cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
	$db->query("UPDATE cart SET items = '{$items_json}', expire_date = '{$cart_expire}' WHERE id = '{$cart_id}'");
	setcookie(CART_COOKIE.'',1,"/",$domain,false);
	setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
}else{
	// add the cart to the database and set cookie:
	$items_json = json_encode($item);
	$cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
	$db->query("INSERT INTO cart (items,expire_date) VALUES ('{$items_json}','{$cart_expire}')");
	$cart_id = $db->insert_id;
	setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
}

 ?>
