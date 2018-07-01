<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/hluxury/core/init.php';
   $name = sanitize($_POST['full_name']);
   $email = sanitize($_POST['email']);
   $street1 = sanitize($_POST['street']);
   $street2 = sanitize($_POST['street2']);
   $city = sanitize($_POST['city']);
   $state = sanitize($_POST['state']);
   $zip_code = sanitize($_POST['zip_code']);
   $errors = array();
   $required = array(
   	'full_name' => 'Full Name',
   	'email'     => 'Email',
   	'street'    => 'Street Address',
   	'city'      => 'City',
    'state'     => 'State',
    'zip_code'   => 'Zip code',
    'country'   => 'Country',
   );
   //check if all required fields are filled validation and
   foreach ($required as $f => $d) {
   	if (empty($_POST[$f]) || $_POST[$f] == '' ) {
   		$errors[] = $d.' is required.';
         echo $d.' is required';
         exit;
   	}
   }
   ///email varification
   if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
   	$errors[] = 'Enter valid email address';
   }
   if (!empty($errors)) {
   	// echo displayerrors($errors);
      //echo $errors;
   } else {
   	echo true;
   }
?>
