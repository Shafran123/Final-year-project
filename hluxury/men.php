<?php
require_once 'core/init.php';
include 'include/head.php';
include 'include/navigation.php';


include 'include/leftbar.php';

$sql = "SELECT * FROM products WHERE featured = 1";
$featured = $db->query($sql);
?>


<!---main content --->
<div class="col-md-8"  >
  <h2 class="text-center">Featured products</h2>
    <br><br>
    <div class="row">
      <?php while($product = mysqli_fetch_assoc($featured)) : ?>

      <div class="col-md-3">

        <h4><?=$product['title']; ?></h4>
        <img src="<?=$product['image'] ?>" alt="<?=$product['title']; ?>"class="img-thumb"/>
        <p class="list-price text-danger">List Price<s>£<?=$product['list_price'];?></s></p>
        <p class="price">Our Price: £<?=$product['price']; ?></p>
        <button type="button" id="<?=$product['id']; ?>" class="btn btn-sm btn-success btn-detail" data-toggle="modal" data-target="#details-1">Details</button>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
  <div class="modal fade details-1" id="details-1" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">
    <h4 id="product_title" class="modal-title text-center"></h4>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <div class="modal-body">
    <div class="container-fluid">
     <div class="row">
      <div class="col-sm-6">
       <div class="center-block">
        <img id="product_img" src="" alt=""  class="details img-responsive">
       </div>
      </div>
      <div class="col-sm-6">
       <h4>Details</h4>
       <p id="product_desc"></p>
       <hr>
       <p id="product_price"></p>
       <p id="product_brand"></p>
       <form action="add_cart.php" method="post">
        <div class="form-group">
         <div class="col-xs-3">
          <label for="quantity">Quantity:</label>
          <input type="text" class="form-control" id="quantity" name="quantity">
         </div>

        </div>
        <div class="form-group">
         <label for="size">Size</label>
         <select name="size" id="size" class="form-control">
          <option value=""></option>
          <?php foreach ($size_array as $string) {
           $string_array = explode(':',$string);
           $size = $string_array[0];
           $quantity = $string_array[1];
           echo '<option value="'.$size.'">'.$size.' ('.$quantity.' Available)</option>';
          } ?>
         </select>
        </div>
       </form>
      </div>
     </div>
    </div>
   </div>
   <div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal">close</button>
    <button class="btn btn-warning" type="submit" class="glyphicon glyphicon-shopping-cart">Add To Cart</button>
   </div>
  </div>
  </div>
 </div>
 <script>
  function closeModal()
  {
    //$.("#details-1").trigger("hide");
   // jQuery('#details-modal').modal('hide');
   // setTimeout(function(){
   //  jQuery('#details-modal').remove();
   //  jQuery('.modal-backdrop').remove();},500);
  }
 </script>
  <?php
  //include 'include/detailsmodal.php';
  include 'include/rightbar.php';
  include 'include/footer.php';
  ?>




  <!-----
  <div class="col-md-3">
  <h4>Tom Ford</h4>
  <img src="img/products/tomfordperfume.jpg" alt="Versace Tshirt" class="img-thumb"/>
  <p class="list-price text-danger">List Price<s>£180.00</s></p>
  <p class="price">Our Price: £155.00</p>
  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
  Details</button>
</div>

<div class="col-md-3">
<h4>Hugo Boss</h4>
<img src="img/products/hugobossjacket.jpg" alt="Versace Tshirt"class="img-thumb"/>
<p class="list-price text-danger">List Price<s>£180.00</s></p>
<p class="price">Our Price: £155.00</p>
<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
Details</button>
</div>

<div class="col-md-3">
<h4>Dior</h4>
<img src="img/products/diormakeup.jpg" alt="Versace Tshirt"class="img-thumb"/>
<p class="list-price text-danger">List Price<s>£180.00</s></p>
<p class="price">Our Price: £155.00</p>
<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
Details</button>
</div>

<div class="col-md-3">
<h4>Balenciaga</h4>
<img src="img/products/balenciagashoes.jpg" alt="Versace Tshirt"class="img-thumb"/>
<p class="list-price text-danger">List Price<s>£180.00</s></p>
<p class="price">Our Price: £155.00</p>
<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
Details</button>
</div>

<div class="col-md-3">
<h4>Michael Kors</h4>
<img src="img/products/michaelkorsbag.jpg" alt="Versace Tshirt"class="img-thumb"/>
<p class="list-price text-danger">List Price<s>£180.00</s></p>
<p class="price">Our Price: £155.00</p>
<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
Details</button>
</div>

<div class="col-md-3">
<h4>Mulberry</h4>
<img src="img/products/mulberrybag.jpg" alt="Versace Tshirt"class="img-thumb"/>
<p class="list-price text-danger">List Price<s>£180.00</s></p>
<p class="price">Our Price: £155.00</p>
<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
Details</button>
</div>

<div class="col-md-3">
<h4>Prada</h4>
<img src="img/products/pradasunglasses.jpg" alt="Versace Tshirt"class="img-thumb"/>
<p class="list-price text-danger">List Price<s>£180.00</s></p>
<p class="price">Our Price: £155.00</p>
<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
Details</button>
</div> ---->
