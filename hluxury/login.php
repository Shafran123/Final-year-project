<?php
require_once 'core/init.php';
include 'include/head.php';
include 'include/navigation.php';
include 'include/headerfull.php';

$mode = isset($_GET['mode'])?$_GET['mode']:'signin';

if ($mode == 'signin'){
  ?>
  <div class="row" style="padding-bottom: 40px;">
    <div class="col-md-6">
      <!-- Modal content-->
      <form id="login_form" style="width: 75%; margin: 0 auto;">
          <div class="modal-header">
            <h2 class="modal-title" style="font-size: 24pt;">Login</h2>
          </div>
          <div class="modal-body">
            <p class="fieldset">
                <label class="image-replace cd-email" for="signin-email">E-mail</label>
                <input class="full-width has-padding has-border" id="signin-email" type="text" placeholder="E-mail" required>
              </p>

              <p class="fieldset">
                <label class="image-replace cd-password" for="signin-password">Password</label>
                <input class="full-width has-padding has-border" id="signin-password" type="password"  placeholder="Password" required>
              </p>
              <div class="pull-right">
                <a href="#" id="a_register">Forgotten your password?></a>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-default" id="login_btn" style="font-size: 16px; margin-top: 10px;">Login</button>
          </div>
      </form>
    </div>
    <div class="col-md-6" style="border-left: 1px solid lightgrey; text-align: center;">
        <div class="" style="width: 75%; margin: 0 auto; padding-top: 105px;">
          <h2>New to Hluxury.com?</h2>
          <p style="font-size: 18px">Creating an account is quick and simple and allows you to track, change or return your order</p>
          <Button id="go-register-btn" class="btn btn-primary" style="margin-top: 30px; font-size: 16px;">Create an account</Button>
        </div>

    </div>
  </div>

  <?php
} else if ($mode == 'register') {
  ?>
    <div class="modal-dialog">
    <form id="register_form">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" style="font-size: 24pt;">Register</h2>
        </div>
        <div class="modal-body">
            <p class="fieldset">
              <label class="image-replace cd-email" for="signup-email">UserName</label>
              <input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="UserName" required>
            </p>

            <p class="fieldset">
              <label class="image-replace cd-email" for="signup-email">E-mail</label>
              <input class="full-width has-padding has-border" id="signup-email" type="text" placeholder="E-mail" required>
            </p>

            <p class="fieldset">
              <label class="image-replace cd-password" for="signup-password">Password</label>
              <input class="full-width has-padding has-border" id="signup-password" type="password"  placeholder="Password" required>
            </p>
              Already have account? Please <a href="login.php" id="a_signin">Sign in</a>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" id="register_btn">Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>

  <?php
}
?>
<script>
  var customer_id = '<?php echo $customer_id; ?>';
    $(document).ready(function(){
      console.log(document.cookie);
      $("#login_btn").on("click", function(event){
        //event.preventDefault();
        if($("#signin-email").val()=='' || $("#signin-password").val()=='')
          return;
        console.log('click');
        $.ajax({
          url: "ajax-func.php?mode=signin",
          type: "post",
          data: {
              "email": $("#signin-email").val(),
              "password": $("#signin-password").val()
          },
          success: function(data){
            console.log(data);
            if (data == 'success') {
                location.href = "cart.php";
            } else {
                alert("Email and Password is not correct!");
                //location.href = "login.php?mode=signin";
            }
          },
        });
      });
      $("#login_form").on("submit", function(event) {
        event.preventDefault();
      })
      $("#go-register-btn").on("click", function() {
        location.href = "login.php?mode=register";
      })
      $("#register_btn").on("click", function(event){
        // event.preventDefault();
        if($("#signup-username").val()=='' || $("#signup-email").val()=='' || $("#signup-password").val()=='')
          return;
        $.ajax({
          url: "ajax-func.php?mode=signup",
          type: "post",
          data: {
              "username": $("#signup-username").val(),
              "email": $("#signup-email").val(),
              "password": $("#signup-password").val()
          },
          success: function(data){
            console.log(data);
            if (data == 'success') {
                location.href = "login.php?mode=signin";
            }
          },
        });
      });
    });
</script>

<?php include 'include/footer.php'; ?>
