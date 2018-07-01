<?php
	require_once 'core/init.php';


	$mode = $_GET['mode'];
	$product_id = isset($_POST['product_id'])?$_POST['product_id']:"";
	$username = isset($_POST['username'])?$_POST['username']:"";
	$email    = isset($_POST['email'])?$_POST['email']:"";
	$password = isset($_POST['password'])?$_POST['password']:"";
	$review   = isset($_POST['review'])?$_POST['review']:"";
	$rating   = isset($_POST['rating'])?$_POST['rating']:"5";
	$currency   = isset($_POST['currency'])?$_POST['currency']:"pound";

	$session_id = session_id();

	switch ($mode) {
	 	case "signin":
	 		$sql = "select * from customers where email='$email' and password='$password'";
	 		$res=mysqli_query($db, $sql);
	 		if($row = mysqli_fetch_assoc($res)){
	 			setcookie('customer_id', $row['id'], time() + (86400*60), "/");
	 			echo 'success';
	 		}
	 		else
	 			echo 'fail';
	 		break;
	 	case "signup":
	 		$sql = "insert into customers(session_id, name, email, password) VALUES('$session_id', '$username', '$email', '$password')";
	 		$res_u=mysqli_query($db, $sql);
	 		echo 'success';
			break; 
		case "add_review":
			$created_at = date("Y-m-d");
			$sql = "insert into reviews(product_id, name, email, review, rating, created_at) VALUES($product_id, '$username', '$email', '$review', '$rating', '$created_at')";
	 		$res_u=mysqli_query($db, $sql);
	 		echo 'success';
			break;
		case "add_wishlist":
			$sql = "select * from wishlist where product_id=$product_id and session_id='$session_id'";
			$res=mysqli_query($db, $sql);
	 		if($row = mysqli_fetch_assoc($res)){
	 			echo 'exist';
	 			exit;
	 		}
			$sql = "insert into wishlist(product_id, session_id) VALUES($product_id, '$session_id')";
	 		$res_u=mysqli_query($db, $sql);
	 		echo 'success';
			break;
		case "remove_wish":
			$sql = "delete from wishlist where id=$product_id";
			$res_u=mysqli_query($db, $sql);
	 		echo 'success';
			break;
		case "currency":
			$_SESSION['currency'] = $currency;
			break;
		case "checkout":
			$popular_list = isset($_POST['customer_id'])?$_POST['customer_id']:"/";
			$token =  explode("/",$popular_list);
			for($i=0;$i<count($token);$i++) {
				$sql = "update products set popular = '1' where id='".$token[$i]."'";
				// echo $sql;
				$res_u=mysqli_query($db, $sql);
			}

			$customer_id    = isset($_POST['customer_id'])?$_POST['customer_id']:"";
			$order_date    = date("Y-m-d");
			$ship_price    = isset($_POST['ship_price'])?$_POST['ship_price']:"";
			$tax    = isset($_POST['tax'])?$_POST['tax']:"";
			$sub_total    = isset($_POST['sub_total'])?$_POST['sub_total']:"";
			$name    = isset($_POST['name'])?$_POST['name']:"";
			$email    = isset($_POST['email'])?$_POST['email']:"";
			$ship_address1    = isset($_POST['ship_address1'])?$_POST['ship_address1']:"";
			$ship_address2    = isset($_POST['ship_address2'])?$_POST['ship_address2']:"";
			$ship_city    = isset($_POST['ship_city'])?$_POST['ship_city']:"";
			$ship_state    = isset($_POST['ship_state'])?$_POST['ship_state']:"";
			$ship_zip    = isset($_POST['ship_zip'])?$_POST['ship_zip']:"";
			$ship_country    = isset($_POST['ship_country'])?$_POST['ship_country']:"";
			
			$sql = "insert into orders(customer_id, order_date, ship_price, tax, sub_total, name, email, ship_address1, ship_address2, ship_city, ship_state, ship_zip, ship_country, status) VALUES('$customer_id', '$order_date', '$ship_price', '$tax', '$sub_total', '$name', '$email', '$ship_address1', '$ship_address2', '$ship_city', '$ship_state', '$ship_zip', '$ship_country', 'pending')";
			// echo $sql;
	 		$res_u=mysqli_query($db, $sql);
	 		echo 'success';
			break;
		case "search_brand":
			$key = isset($_POST['key'])?$_POST['key']:"";
			$sql = "select * from brand";
			if ($key != '')
			$sql .= " where brand like '%".$key."%'";
			// echo $sql;
			$res=mysqli_query($db, $sql);
			$arr = array();
			$num = 0;
	 		while($row = mysqli_fetch_assoc($res)){
	 			$arr[$num++] = $row;
	 		}
	 		echo json_encode($arr);
			break;
	 }
?>