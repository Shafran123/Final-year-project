<?php
require_once 'core/init.php';
include 'include/head.php';
include 'include/navigation.php';
include 'include/headerfull.php';

if($cart_id != ''){
  $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $result = mysqli_fetch_assoc($cartQ);
  $items = json_decode($result['items'],true);
  $i = 1;
  $sub_total = 0;
  $item_count = 0;
}
?>
<h3 class="text-center">My Shopping Cart</h3>
<?php if($cart_id == ''): ?>
  <br><br>
  <div class="alert alert-danger">
    <p class="text-center">
      Your Shopping cart is empty!
    </p>
  </div>
<?php else: ?>
  <table class="table table-border table-condensed table-striped">
    <thead><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th></thead>
    <tbody>
      <?php
      foreach ($items as $item) {
        $product_id = $item['id'];
        $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
        $product = mysqli_fetch_assoc($productQ);
        $sArray = explode(',',$product['sizes']);
        foreach ($sArray as $sizeString) {
          $s = explode(':',$sizeString);
          if($s[0] == $item['size']){
            $available = $s[1];
          }
        }
        ?>
        <tr>
          <td><?=$i;?></td>
          <td><?=$product['title'];?></td>
          <td><?=money($product['price']);?></td>

          <td>
            <button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>');">-</button>
            <?=$item['quantity'];?>
            <?php if($item['quantity'] < $available): ?>
              <button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>');">+</button>
          <?php else: ?>
            <span class="text-danger">Max</span>
          <?php endif; ?>
          </td>
          <td><?=$item['size'];?></td>
          <td><?=money($item['quantity'] * $product['price']);?></td>
        </tr>
        <?php
        $i++;
        $item_count += $item['quantity'];
        $sub_total += ($product['price'] * $item['quantity']);
      }
      $tax = TAXRATE * $sub_total;
      $tax = number_format($tax,2);
      $grand_total = $tax + $sub_total;
       ?>
    </tbody>
  </table>
  <table class="table table-bordered table-condensed text-center">
    <legend>Totals</legend>
    <thead class="totals-table-header"><th>Total Items</th><th>Sub Total</th><th>VAT</th><th>Grand Total</th></thead>
    <tbody>
      <tr>
        <td><?=$item_count;?></td>
        <td><?=money($sub_total);?></td>
        <td><?=money($tax);?></td>
        <td class="alert alert-success"><?=money($grand_total);?></td>
      </tr>
    </tbody>
  </table>
  <!-- Checkout button -->
<!-- <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#checkoutModal"> -->
<button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#signin_modal">

  <span class="glyphicon glyphicon-shopping-cart"></span>Checkout >>
</button>

<!-- Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkoutModalLabel">Shipping Address</h4>
      </div>
        <div class="modal-body">
          <div class="row">
          <form action="thankYou.php" method="post" id="payment-form">
            <span class="bg-danger" id="payment-errors"></span>
            <div id="step1" style="display:block;">
              <div class="form-group col-md-6">
                <label for="full_name">Full Name:</label>
                <input class="form-control" id="full_name" name="full_name" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="email">Email:</label>
                <input class="form-control" id="email" name="email" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="street">Address Line 1:</label>
                <input class="form-control" id="street" name="street" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="street2">Address Line 2:</label>
                <input class="form-control" id="street2" name="street2" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="city">City:</label>
                <input class="form-control" id="city" name="city" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="state">State/Province/Region:</label>
                <input class="form-control" id="state" name="state" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="zip_code">ZIP/Postal Code:</label>
                <input class="form-control" id="zip_code" name="zipcode" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="country">Country:</label>
                <input class="form-control" id="country" name="country" type="text">
              </div>
            </div>
            <div id="step2" style="display:none;">
              <div class="form-group col-md-3">
                <label for="name">Name on Card:</label>
                <input type="text" id="name" class="form-control">
              </div>
              <div class="form-group col-md-3">
                <label for="number">Card Number:</label>
                <input type="text" id="number" class="form-control">
              </div>
              <div class="form-group col-md-2">
                <label for="cvc">CVC:</label>
                <input type="text" id="cvc" class="form-control">
              </div>
              <div class="form-group col-md-2">
                <label for="exp-month">Expiry Month:</label>
                <select if="exp-month" class="form-control">
                  <option value=""></option>
                  <?php for($i=1;$i < 13; $i++): ?>
                    <option value="<?=$i;?>"><?=$i;?></option>
                  <?php endfor; ?>

                </select>
              </div>
              <div class="form-group col-md-2">
                <label for="exp-year">Expire Year:</label>
              <select id="exp-year" class="form-control">
                <option value=""></option>
                <?php $yr = date("Y");?>
                <?php for($i=0;$i < 11; $i++):?>
                  <option value="<?=$yr+$i;?>"><?=$yr+$i;?></option>
                <?php endfor; ?>
              </select>
              </div>
            </div>

        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary"onclick="check_address();" id="next_button">Next >></button>
                  <button type="button" class="btn btn-primary"onclick="back_address();" id="back_button" style="display:none;"><< Back</button>
                <button type="submit" class="btn btn-primary" id="checkout_button" style="display:none;" >Check out >></button>
                </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="signin_modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="login_form">
      <div class="modal-content">
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
              <input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="Password" required>
            </p>
            <div class="pull-right">
              Don't have account? Please <a href="#" id="a_register" data-toggle="modal" data-target="#signup_modal">Register</a>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" id="login_btn">Login</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="signup_modal" role="dialog">
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
              <input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="Password" required>
            </p>
              Already have account? Please <a href="#" id="a_signin" data-toggle="modal" data-target="#signin_modal">Sign in</a>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" id="register_btn">Register</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php endif; ?>
<script>
    $(document).ready(function(){
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
                $("#signin_modal").removeClass("in show");
                // $("#signin_modal").removeClass("show");
                $("#checkoutModal").addClass("in show");
            }
          },
        });
      });
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
                $("#signup_modal").removeClass("in show");
                // $("#signin_modal").removeClass("show");
                $("#checkoutModal").addClass("in show");
            }
          },
        });
      });
      $("#a_register").on("click", function(event) {
          $("#signin_modal").removeClass("in");
          $("#signin_modal").removeClass("show");
      });
    });
    function back_address() {
        jQuery('#payment-errors').html("");
        jQuery('#step1').css("display" , "block");
        jQuery('#step2').css("display" , "none");
        jQuery('#next_button').css("display" , "inline-block");
        jQuery('#back_button').css("display" , "none");
        jQuery('#checkout_button').css("display" , "none");
        jQuery('#checkoutModalLabel').html("Shipping Address");
    }
    function check_address() {
        var data = {
          'full_name' : jQuery('#full_name').val(),
          'email' : jQuery('#email').val(),
          'street' : jQuery('#street').val(),
          'street2' : jQuery('#street2').val(),
          'city' : jQuery('#city').val(),
          'state' : jQuery('#state').val(),
          'zip_code' : jQuery('#zip_code').val(),
          'country' : jQuery('#country').val(),
                   };
                   jQuery.ajax({
                     url : '/hluxury/admin/parsers/check_address.php',
                     method : 'POST',
                     data : data,
                     success : function(resp){
                       if(resp != 1){
                         jQuery('#payment-errors').html(data);
                       }
                       if(resp == 1){
                         jQuery('#payment-errors').html("");
                         jQuery('#step1').css("display","none");
                         jQuery('#step2').css("display","block");
                         jQuery('#next_button').css("display","none");
                         jQuery('#back_button').css("display","inline-block");
                         jQuery('#checkout_button').css("display","inline-block");
                         jQuery('#checkoutModalLabel').html("Enter Your Card Details");
                       }
                     },
                     error : function(){alert("Something Went Wrong");},
                   });
                 }

</script>

<?php include 'include/footer.php'; ?>
