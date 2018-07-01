<?php
   require_once 'core/init.php';
   $id = $_POST['id_'];
   $sql = "SELECT * FROM products WHERE id = '$id'";
   $productQ = $db->query($sql);
   $row = mysqli_fetch_assoc($productQ);
   $size_array = explode(',', $row['sizes']);
   $brand = $row['brand'];
   $sql1 = "SELECT * FROM brand WHERE id = '$brand'";
   $productQ1 = $db->query($sql1);
   $row1 = mysqli_fetch_assoc($productQ1);

   function star_rating($star) {
      $star_rating = "";
      for($i=1;$i<=5;$i++) {
         $star_rating .= "<span class='fa fa-star";
         if($star>=$i)
            $star_rating .= " checked";
         $star_rating .="'></span>";
      }
      return $star_rating;
   }
?>

<div class="modal-header">
   <h3 id="product_title" class="modal-title text-center"><?=$row['title']?></h3>
   <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 15px; top: 15px;">
   <span aria-hidden="true" style="font-size: 24px;" >&times;</span>
   </button>
</div>
<div class="modal-body">
   <div class="container-fluid">
     <span id="modal_errors" class="bg-danger" style="height:10px;"></span><br><br>
      <div class="row">

         <div class="col-sm-6">
            <div class="center-block">
               <img id="product_img" src="<?=$row['image']?>" alt=""  width="2000" height="550" class="details img-responsive">
            </div>
         </div>
         <div class="col-sm-6">
            <ul class="nav nav-pills" style="margin-bottom: 10px;" role="tablist">
              <li class="nav-item active">
                <a class="nav-link" data-toggle="tab" href="#detail-tab">Details</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#review-tab">Reviews</a>
              </li>
            </ul>
            <div class="tab-content clearfix">
               <div class="tab-pane active" id="detail-tab">
                  <p id="product_desc"><?=$row['description']?></p>
                  <hr>
                  <p id="product_price">Price:<?php echo currencyConverter($currency, $row['price']); ?></p>
                  <p id="">Brand: <?=$row1['brand']?></p>
                  <form action="add_cart.php" method="post" id="add_product_form">
                    <input type="hidden" id="product_id" name="product_id" value="<?=$id;?>">
                    <input type="hidden" name="available" id="available" value="">
                     <div class="form-group">
                        <div class="col-xs-3">
                           <label for="quantity">Quantity:</label>
                           <input type="number" class="form-control" min="0" id="quantity" name="quantity">
                        </div>
                     </div><br><br><br>
                     <div class="form-group">
                        <label for="size">Size</label>
                        <select name="size" id="size" class="form-control">
                           <option value=""></option>
                           <?php foreach ($size_array as $string) {
                              $string_array = explode(':',$string);
                              $size = $string_array[0];
                              $available = $string_array[1];
                              echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.' Available)</option>';
                              } ?>
                        </select>
                     </div>
                  </form>
                  <div class="modal-footer">
                     <button class="btn btn-default" data-dismiss="modal">Close</button>
                     <button class="btn btn-warning" onclick="add_to_cart();return false;" class="glyphicon glyphicon-shopping-cart">Add To Cart</button>
                  </div>
               </div>
               <div class="tab-pane" id="review-tab">
                  <?php
                     $sql = "select * from reviews where product_id=$id order by created_at DESC limit 0,3";
                     $res=mysqli_query($db, $sql);
                     $review_list = array();
                     $num = 0;
                     while($row = mysqli_fetch_assoc($res)) {
                        echo '<div class="review">';
                        echo '<label>'.$row['name'].'&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;'.$row['created_at'].'</label>';
                        echo "<div class='right star_rating'>";
                        echo star_rating($row['rating']);
                        echo "</div>";
                        echo '<p>'.$row['review'].'</p>';
                        echo '</div>';
                     }
                  ?>
                  <form id="form_review">
                     <h3>Write your review</h3>
                     <div class="stars">
                        <input class="star star-5" id="star-5" type="radio" name="star" value="5" checked/>
                        <label class="star star-5" for="star-5"></label>
                        <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
                        <label class="star star-4" for="star-4"></label>
                        <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
                        <label class="star star-3" for="star-3"></label>
                        <input class="star star-2" id="star-2" type="radio" name="star" value="2"/>
                        <label class="star star-2" for="star-2"></label>
                        <input class="star star-1" id="star-1" type="radio" name="star" value="1"/>
                        <label class="star star-1" for="star-1"></label>
                     </div>

                     <p class="fieldset">
                       <input class="full-width has-padding has-border" id="review-username" type="text" placeholder="UserName" required>
                     </p>

                     <p class="fieldset">
                       <input class="full-width has-padding has-border" id="review-email" type="text" placeholder="E-mail" required>
                     </p>

                     <p class="fieldset">
                       <textarea class="full-width has-padding has-border" id="review-content" type="text"  placeholder="Your Review" required></textarea>
                     </p>
                     <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="add-review-btn" type="submit" class="btn btn-default">Submit</button>
                     </div>
                  </form>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<script>
$('#size').change(function(){
  var available = $('#size option:selected').data("available");
  $('#available').val(available);
});
$("#add-review-btn").on("click", function(event) {
   if($("#review-username").val()=='' || $("#review-email").val()=='' || $("#review-content").val()=='')
      return;
   $.ajax({
          url: "ajax-func.php?mode=add_review",
          type: "post",
          data: {
              "product_id": $("#product_id").val(),
              "username": $("#review-username").val(),
              "email": $("#review-email").val(),
              "review": $("#review-content").val(),
              "rating": $("input[type='radio'].star:checked").val(),
          },
          success: function(data){
            console.log(data);
            location.reload();
          },
        });
   event.preventDefault();

})
</script>
