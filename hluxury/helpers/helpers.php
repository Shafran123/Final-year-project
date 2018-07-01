<?php
function display_errors($errors)
  {
    $display='<ul class="alert alert-danger">';
    foreach($errors as $error){
      $display.='<li class="text-danger">'.$error.'</li>';
    }
    $display.='</ul>';

    return $display;
  }

  function sanitize ($dirty){
    return htmlentities($dirty,ENT_QUOTES,"UTF-8");
  }

  function money($number){
    global $currency;
    return currencyConverter($currency, $number);
  }

  function login($user_id){
    $_SESSION['SBUser'] = $user_id;
    global $db;
    $date = date("Y-m-d H:i:s");
    $db -> query ("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
    $_SESSION['success_flash']= 'You Are Sucessfully Logged in !';
    header('Location:index.php');
  }

  function is_logged_in(){
    if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0){
      return true;
    }
      return false;
  }

  function login_error_redirect($url = 'login.php'){
    $_SESSION['error_flash'] = "You must be logged in to access page";
    header('Location: '.$url);
  }

  function permission_error_redirect($url='login.php'){
    $_SESSION['error_flash'] = "You do not have permission To access page";
    header('Location: '.$url);

  }

  function has_permission($permission = 'admin') {
  	global $user_data;
  	$permissions = explode(',', $user_data['permissions']);
  	if(in_array($permission, $permissions, true)) {
  		return true;
  	}
  	return false;
  }



  function pretty_date($date){
    return date("M d, Y h:i A",strtotime($date));
  }

  function get_category($child_id){
    global $db;
    $id = sanitize($child_id);
    $sql = "SELECT P.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
            FROM categories c
            INNER JOIN categories p
            ON c.parent = p.id
            WHERE c.id = '$id'";
    $query = $db ->query($sql);
    $category = mysqli_fetch_assoc($query);
    return $category;

  }
