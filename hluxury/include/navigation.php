

<?php
$sql = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);
$currency = $_SESSION['currency'];
if (!$currency)
  $currency = 'POUND';
$_SESSION['currency'] = $currency;

$cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');

?>

<!-- Header -->
<div class="header1">
  <!-- Header desktop -->
  <div class="container-menu-header">
    <div class="topbar">
      <div class="topbar-social">
        <a href="https://www.facebook.com/" class="topbar-social-item fa fa-facebook"></a>
        <a href="https://www.instagram.com/?hl=en" class="topbar-social-item fa fa-instagram"></a>
        <a href="https://www.pinterest.co.uk/" class="topbar-social-item fa fa-pinterest-p"></a>
        <a href="https://www.snapchat.com/" class="topbar-social-item fa fa-snapchat-ghost"></a>
        <a href="https://www.youtube.com/" class="topbar-social-item fa fa-youtube-play"></a>
      </div>

      <span class="topbar-child1">
        Free shipping for standard order over £100
      </span>
      <div class="topbar-child2">
        <span style="font-size: 14px;"> Translate as </span>
      <div id="google_translate_element" style="margin: 3px 10px;"></div>

        <span class="topbar-email">
          hluxury@gmail.com
        </span>
        <?php $url = $_SERVER["PHP_SELF"] . '?'.http_build_query($_GET); ?>
          <div class="topbar-language rs1-select2">
            <select class="selection-1" name="currency" id="currency">
              <option <?php if (strtolower($currency)=='usd') echo ' selected' ?>>USD</option>
              <option <?php if (strtolower($currency)=='pound') echo ' selected' ?>>POUND</option>
            </select>
          </div>
      </div>
    </div>

    <div class="wrap_header">
      <!-- Logo -->
     <a href="index.php" class="logo">
        <img src="img/icons/HLUXURY LOGO.png"  alt="IMG-LOGO" style="width: 160px; ">
      </a>

      <!-- Menu -->
      <div class="wrap_menu">
        <nav class="menu">
          <ul class="main_menu">
            <?php
               while($parent = mysqli_fetch_assoc($pquery)) :
                  $parent_id = $parent['id'];
               $sql0 = "SELECT * FROM categories WHERE parent = '$parent_id'";
               $cquery = $db->query($sql0);
            ?>
            <li>
          <?php echo $parent['category']; ?>
              <ul class="sub_menu">

                <?php while($child = mysqli_fetch_assoc($cquery)) : ?>
          <li><a href="category.php?cat=<?=$child['id']; ?>"><?php echo $child['category']; ?></a></li>
              <?php endwhile; ?>
              </ul>
            </li>
              <?php endwhile; ?>

            <li>
              <a href="contactus.php">Contact Us</a>
            </li>
          </ul>
        </nav>
      </div>

      <!-- Header Icon -->
      <div class="header-icons">
        <?php
          $customer_id = isset($_COOKIE['customer_id'])?$_COOKIE['customer_id']:'';
          if($customer_id) {
            $sql = "select * from customers where id='$customer_id'";
            $c_query = $db->query($sql);
            $customer = mysqli_fetch_assoc($c_query);

        ?>
          <a href="logout.php" class="header-wrapicon1 dis-block">
            <img src="img/icons/icon-header-01.png" class="header-icon1" alt="ICON" title="Logout">
            <?php
              if ($customer) {
                echo '<p style="font-size: 12px;">'.$customer['name'].'</p>';
              }
            ?>
          </a>
        <?php
          } else {
        ?>
          <a href="login.php" class="header-wrapicon1 dis-block">
            <img src="img/login.png" class="header-icon1" alt="ICON" title="Login">
          </a>
        <?php
          }
        ?>
        <span class="linedivide1"></span>

        <a href="wishlist.php" class="header-wrapicon1 dis-block">
          <img src="img/icons/icon-header-03.png" class="header-icon1" alt="ICON">
          <?php
            $session_id = session_id();
            $sql = "select count(product_id) as count from wishlist where session_id = '$session_id'";
            $wish_num = 0;
            $res=mysqli_query($db, $sql);
            if($row = mysqli_fetch_assoc($res))
              $wish_num = $row['count'];
          ?>
          <span class="header-icons-noti"><?php echo $wish_num; ?></span>
        </a>

        <span class="linedivide1"></span>


        <div class="header-wrapicon2">
          <img src="img/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
          <?php
            $cartQ = $db->query("select * from cart where id = '{$cart_id}'");
            $result = mysqli_fetch_assoc($cartQ);
            $items = json_decode($result['items'],true);
            $i =1;
            $sub_total = 0;
            $count_items = count($items);
          ?>
          <span class="header-icons-noti"><?=$count_items?></span>

          <!-- Header cart noti -->
          <div class="header-cart header-dropdown">
            <h3>Shopping Cart</h3>
            <ul class="header-cart-wrapitem">
              <li class="header-cart-item">

                <?php if(empty($cart_id)): ?>
              		<p>Your Shopping cart is empty</p>
              	<?php  else:

                 ?>
              	 <table class="table table-condensed" id="cart_widget">
              	 	<tbody>
              	 		<?php foreach ($items as $item):
              	 		   $productQ = $db->query("select * from products where id = '{$item['id']}'");
              	 		   $product = mysqli_fetch_assoc($productQ);
              	 		?>
              	 		<tr>
                      <td><img src="<?=$product['image']?>" style="width: 45px; height: auto;"></td>
              	 			<td><h5><?=substr($product['title'],0.15); ?></h5></td>
                      <td><?=$item['quantity'];?></td>
              	 			<td><?=money($item['quantity'] * $product['price']);?></td>
              	 		</tr>
                   	 	<?php
                   	 	     $sub_total += ($item['quantity'] * $product['price']);
                    	 	     endforeach; ?>
                    	 	<tr>
                    	 		<td></td>
                    	 		<td>Sub Total</td>
                    	 		<td><?=money($sub_total);?></td>
                    	 	</tr>
              	 	</tbody>
              	 </table>
              	 <a href="cart.php"  class="btn btn-primary pull-right">View Cart</a>
              	 <div class="clearfix"></div>
              	<?php
                  $i++;
                  endif;
                ?>
              </div>



          </div>
        </div>
      </div>

    </div>
            <!-- Header Mobile -->
        <div class="wrap_header_mobile">
          <!-- Logo moblie -->
          <a href="index.php" class="logo-mobile">
            <img src="img/icons/HLUXURY LOGO.png" alt="">
          </a>

          <!-- Button show menu -->
          <div class="btn-show-menu">
            <!-- Header Icon mobile -->
            <div class="header-icons-mobile">
              <?php
                $customer_id = isset($_COOKIE['customer_id'])?$_COOKIE['customer_id']:'';
                if($customer_id) {
              ?>
                <a href="logout.php" class="header-wrapicon1 dis-block">
                  <img src="img/icons/icon-header-01.png" class="header-icon1" alt="ICON" title="Logout">
                  <?php
                    if ($customer) {
                      echo '<p style="font-size: 12px;">'.$customer['name'].'</p>';
                    }
                  ?>
                </a>
              <?php
                } else {
              ?>
                <a href="login.php" class="header-wrapicon1 dis-block">
                  <img src="img/login.png" class="header-icon1" alt="ICON" title="Login">
                </a>
              <?php
                }
              ?>
              <span class="linedivide2"></span>
              <a href="wishlist.php" class="header-wrapicon1 dis-block">
                <img src="img/icons/icon-header-03.png" class="header-icon1" alt="ICON">
                <?php
                  $session_id = session_id();
                  $sql = "select count(product_id) as count from wishlist where session_id = '$session_id'";
                  $wish_num = 0;
                  $res=mysqli_query($db, $sql);
                  if($row = mysqli_fetch_assoc($res))
                    $wish_num = $row['count'];
                ?>
                <span class="header-icons-noti"><?php echo $wish_num; ?></span>
              </a>
              <span class="linedivide2"></span>

              <div class="header-wrapicon2">
                <img src="img/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
                <span class="header-icons-noti"><?=$count_items?></span>

                <!-- Header cart noti -->
                <div class="header-cart header-dropdown">
                  <h3>Shopping Cart</h3>
                  <ul class="header-cart-wrapitem">
                    <li class="header-cart-item">

                      <?php if(empty($cart_id)): ?>
                        <p>Your Shopping cart is empty</p>
                      <?php  else:

                       ?>
                       <table class="table table-condensed" id="cart_widget">
                        <tbody>
                          <?php foreach ($items as $item):
                             $productQ = $db->query("select * from products where id = '{$item['id']}'");
                             $product = mysqli_fetch_assoc($productQ);
                          ?>
                          <tr>
                            <td><img src="<?=$product['image']?>" style="width: 45px; height: auto;"></td>
                            <td><h5><?=substr($product['title'],0.15); ?></h5></td>
                            <td><?=$item['quantity'];?></td>
                            <td><?=money($item['quantity'] * $product['price']);?></td>
                          </tr>
                            <?php
                                 $sub_total += ($item['quantity'] * $product['price']);
                                   endforeach; ?>
                              <tr>
                                <td></td>
                                <td>Sub Total</td>
                                <td><?=money($sub_total);?></td>
                              </tr>
                        </tbody>
                       </table>
                       <a href="cart.php"  class="btn btn-primary pull-right">View Cart</a>
                       <div class="clearfix"></div>
                      <?php
                        $i++;
                        endif;
                      ?>
                </div>
              </div>
            </div>

            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
            </div>
          </div>
        </div>
        <!-- Menu Mobile -->
        <div class="wrap-side-menu" style="position: absolute; z-index: 10;">
          <nav class="side-menu">
            <ul class="main-menu">
              <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
                <span class="topbar-child1">
                  Free shipping for standard order over £100
                </span>
              </li>
              <li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
                <div class="topbar-child2-mobile">
                  <span class="topbar-email">
                    hluxry@gmail.com
                  </span>
                  <div class="topbar-language rs1-select2">
                    <select class="selection-1" name="currency" id="currency" style="color: black;">
                      <option <?php if (strtolower($currency)=='usd') echo ' selected' ?>>USD</option>
                      <option <?php if (strtolower($currency)=='pound') echo ' selected' ?>>POUND</option>
                    </select>
                  </div>
                </div>
              </li>
              <li class="item-topbar-mobile p-l-10">
                <div class="topbar-social-mobile">
                  <a href="https://www.facebook.com/" class="topbar-social-item fa fa-facebook"></a>
                  <a href="#" class="topbar-social-item fa fa-instagram"></a>
                  <a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
                  <a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
                  <a href="#" class="topbar-social-item fa fa-youtube-play"></a>
                </div>
              </li>
              <?php
                 $sql = "SELECT * FROM categories WHERE parent = 0";
                 $pquery = $db->query($sql);
                 while($parent = mysqli_fetch_assoc($pquery)) :
                   $parent_id = $parent['id'];
                   $sql0 = "SELECT * FROM categories WHERE parent = '$parent_id'";
                   $cquery = $db->query($sql0);
              ?>
              <li class="item-menu-mobile">
                <a href="#"><?=$parent['category']?></a>
                <ul class="sub-menu">
                  <?php
                    while($child = mysqli_fetch_assoc($cquery)) : ?>
                      <li><a href="category.php?cat=<?=$child['id']; ?>"><?php echo $child['category']; ?></a></li>
                  <?php endwhile;
                  ?>
                </ul>
                <i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
              <?php endwhile;?>
              <li class="item-menu-mobile">
                <a href="contactus.php">Contact Us</a>
              </li>
            </ul>
          </nav>
        </div>
  </div>
</div>
<script type="text/javascript">
  $(".selection-1").on("change", function(){
    console.log($(this).val());
    $.ajax({
      url: "ajax-func.php?mode=currency",
      type: "post",
      data: {
          "currency": $(this).val(),
      },
      success: function(data){
        console.log(data);
        location.reload();
      },
    });
  })
</script>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php
   $sql = "SELECT * FROM categories WHERE parent = 0";
   $pquery = $db->query($sql);
?>
