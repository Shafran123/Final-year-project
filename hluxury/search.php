<?php
require_once 'core/init.php';
?>
<?php
include 'include/head.php';
include 'include/navigation.php';
include 'include/headerpartial.php';
$sql = "select * from products";
$cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');
if ($cat_id == '') {
  $sql .= ' where deleted = 0';
} else {
  $sql .= "where deleted = 0 and categories = '{$cat_id}'";
}
$price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
$min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
$max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
$brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');
if ($min_price != '') {
  $sql .= " and price >= '{$min_price}'";
}
if ($max_price != '') {
  $sql .= " and price <= '{$max_price}'";
}
if ($brand != '') {
  $sql .= " and brand = '{$brand}'";
}
if ($price_sort == 'low') {
  $sql .= " order by price";
}
if ($price_sort == 'high') {
  $sql .= " order by price desc";
}
$sql = "SELECT * FROM products WHERE categories = '$cat_id'";
$productQ = $db->query($sql);
$category = get_category($cat_id);
?>

      <div class="container-fluid">
      <?php
         include 'include/leftbar.php';
      ?>

         <!--this is going to be main content showing products-->
          <div class="col-md-8">
            <div class="row">
            <?php if($cat_id != ''): ?>
              <h2 class="text-center"><?=$category['parent'].' '. $category['child']; ?></h2>
            <?php else: ?>
              <h2 class="text-center">Wenepa Online Shop</h2>
            <?php endif; ?>
              <?php while($product = mysqli_fetch_assoc($category)) : ?>
              <div class="col-md-3 text-center">

              <h4><?= $product['title']; ?></h4>
              <?php $photos = explode(',', $product['image']) ?>
              <img src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" class="img-thumb" />
              <p class="list-price text-danger">List Price: <s>Rs <?= $product['list_price']; ?></s></p>
              <p class="price">New price: Rs <?= $product['price']; ?></p>
              <button class="btn btn-sm btn-success" data-toggle="modal" onclick="detailmodal(<?= $product['id']; ?>)" data-target="#details">Details</button>

              </div>
            <?php endwhile; ?>
            </div>
          </div>
           <?php
           include 'include/rightbar.php';
           ?>
      </div>
      <?php
          include 'include/footer.php';
      ?>
