<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/hluxury/core/init.php';
include 'includes/head.php';
$email=((isset($_POST['email']))?sanitize($_POST['email']):'');
$email=trim($email);
$password=((isset($_POST['password']))?sanitize($_POST['password']):'');
$password=trim($password);
$hashed=password_hash($password,PASSWORD_DEFAULT);
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
    if(empty($_POST['email']) ||empty($_POST['password']))
    {
      $errors[]="You Must Provide Email and Password";
    }


    //validate Email
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors[] = 'You must enter a valid email';
    }

    //password is more than 6 characters
    if(strlen($password) <6){
      $errors[] = 'Password must be at least 6 characters.';
    }

    //check if email exists in the database
    $query = $db->query("SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);
    $userCount = mysqli_num_rows($query);
    if($userCount < 1){
      $errors[] = 'That email does not exist in our database.';
    }

    if(!password_verify($password, $user['password'])){
      $errors[] = 'The password does not match our records. Please try again.';
    }


    //check for errors
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //log user in
      $user_id = $user['id'];
      login($user_id);
    }

  }

  ?>
</div>
<h2 class="text-center">Login </h2>
<form  action="login.php" method="post">

  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?=$email?>"  class="form-control">
  </div>
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" name="password" value="<?=$password?>" class="form-control ">
  </div>
  <!-- <center><a href="change_password.php">Forget Password</a></center> -->
  <div class="form-group">
    <input type="submit" value="Login" class="btn-btn-primary">
  </div>
</form>
<p class="text-right"><a href="/hluxury/hluxury.php" alt="home">Vist Site</a></p>

</div>

<?php include 'includes/footer.php';?>
