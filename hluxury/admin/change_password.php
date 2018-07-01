<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/hluxury/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
$hashed=$user_data['password'];
$old_password=((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password=trim($old_password);
$password=((isset($_POST['password']))?sanitize($_POST['password']):'');
$password=trim($password);
$confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm=trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors=array();


?>
<style media="screen">
body{
  background-image: url('/hluxury/img/logonew.jpg');
  background-attachment: fixed;
  background-size: 100vw 100vh;
  height: auto;
}
</style>
<div id="login-form"
style="
width: 50%;
height: 50% auto;
margin: 8% auto;
border-shadow: 7px 7px 15px rgba(0,0,0,0.6);
border: 2px solid #000;
border-radius: 15px;
background-color: #fff;
padding: 15px;">

<div>
  <?php
  if($_POST){
    //form validation
      if(empty($_POST['old_password']) ||empty($_POST['password']) ||empty($_POST['confirm'])){
        $errors[]="You Must Provide All fields";
      }

      //password is more than 6 characters
      if(strlen($password) <6){
        $errors[] = 'Password must be at least 6 characters.';
      }

      //If new password matches the confirm_password
      if($password != $confirm){
        $errors[] = 'The new password and confirm new password does not match';
      }

      if(!password_verify($old_password, $hashed)){
        $errors[] = 'Your old password does not match our record.';
      }

      //check for $errors
      if(!empty($errors)){
        echo display_errors($errors);
      }else{

        //change password
          $db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
          $_SESSION['success_flash']="Your password has been Updated!";
          header('Location:index.php');
        }
      }
   ?>
</div>
<h2 class="text-center">Change Password </h2>
<form  action="change_password.php" method="post">

  <div class="form-group">
    <label for="old_password">Old Password:</label>
    <input type="password" name="old_password" value="<?=$old_password?>"  class="form-control">
  </div>

  <div class="form-group">
    <label for="password">New Password:</label>
    <input type="password" name="password" value="<?=$password?>" class="form-control ">
  </div>

  <div class="form-group">
    <label for="confirm">Confirm New Password:</label>
    <input type="password" name="confirm" value="<?=$confirm?>" class="form-control ">
  </div>
  <!-- <center><a href="change_password.php">Forget Password</a></center> -->
  <div class="form-group">
    <a href="index.php" class="btn btn-default">Cancel</a>
    <input type="submit" value="Login" class="btn-btn-primary">
  </div>
</form>
<p class="text-right"><a href="/hluxury/hluxury.php" alt="home">Vist Site</a></p>

</div>

<?php include 'includes/footer.php';?>
