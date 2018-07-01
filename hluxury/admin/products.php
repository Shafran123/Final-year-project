<?php
ob_start();
  require_once $_SERVER['DOCUMENT_ROOT'].'/hluxury/core/init.php';
  if(!is_logged_in())
  {
    login_error_redirect();
  }

  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerfull.php';

  //Delete product_title
  if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    $db->query("UPDATE Products SET deleted = 1 WHERE id= '$id'");
    header('Location:products.php');
  }
  $dbpath = '';
  if (isset($_GET['add']) || isset($_GET['edit'])){
    $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
    $parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
    $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
    $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
    $category = ((isset($_POST['child'])) && !empty($_POST['child'])?sanitize($_POST['child']):'');
    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
    $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
    $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
    $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
    $sizes = rtrim($sizes,',');
    $saved_image = '';

    if(isset($_GET['edit'])){
      $edit_id = (int)$_GET['edit'];
      $productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
      //print_r($productResults);
      $product = mysqli_fetch_assoc($productResults);
      if(isset($_GET['delete_image'])){
        echo "asdf";
        print_r($_GET['delete_image']);
        $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image']; echo $image_url;
        // echo "qqq";
        // print_r($product['image']);
        // echo "qqq";
        //unlink($image_url);

        $db->query("UPDATE products SET image = '' WHERE id = '$edit_id'");
        header('Location: products.php?edit='.$edit_id);
      }
      $category = ((isset($_POST['child']) && $_POST['child'] !== '')?sanitize($_POST['child']):$product['categories']);
      $title  = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
      $brand  = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):$product['brand']);
      $parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
      $parentResult = mysqli_fetch_assoc($parentQ);
      $parent  = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
      $price  = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
      $list_price  = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):$product['list_price']);
      $description  = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):$product['description']);
      $sizes  = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):$product['sizes']);
      $sizes = rtrim($sizes,',');
      $saved_image = (($product['image'] != '')?$product['image']:'');
      $dbpath = $saved_image;
    }
    if(!empty($sizes)){
        $sizeString = sanitize($sizes);
        $sizeString = rtrim($sizeString,',');
        $sizesArray = explode(',',$sizeString);
        $sArray = array();
        $qArray = array ();
        foreach($sizesArray as $ss){
          $s = explode(':', $ss);
          $sArray[] = $s[0];
          $qArray[] = $s[1];
        }
    }else{
      $sizesArray = array();
    }

    if($_POST){
      $errors= array();
      $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
      foreach ($required as $field){
        if($_POST[$field] == ''){
          $errors[] = 'All fields with an astrisk are required.';
          break;
        }
      }
      if(!empty($_FILES) )
      {
        $file_name = $_FILES['photo']['name'];
        $file_size =$_FILES['photo']['size'];
        $file_tmp =$_FILES['photo']['tmp_name'];
        $file_type=$_FILES['photo']['type'];
        $file_ext=strtolower(end(explode(".",$_FILES['photo']['name'])));
        if(empty($file_size))
        {
          $errors[]='You Must Choose a Product Photo !';
        }
        else
         {
           // $Type=explode('/',$photo['type']);
           // if($Type[0]!='image')
           //   $errors[]='The Upload Must Be an Image.';


           // $tmploc=$photo['photo']['tmp_name'];
           // $uploadName=md5(microtime()).'.'.$Type[1];

           $uploadPath=BASEURL .'/img/products/'.$file_name;
           $dbpath='/hluxury/img/products/'.$file_name;
         }
      }
      if(!empty($errors)){
        echo display_errors($errors);
      }else{
        //upload file and insert into database
        move_uploaded_file($file_tmp,$uploadPath);
      if(isset($_GET['edit'])){

        $updateSql = "UPDATE products SET title = '" . $title . "', price = '" . $price . "', list_price = '" . $list_price . "', brand = '" . $brand . "', categories = '" . $category . "', sizes = '" . $sizes . "', image = '" . $dbpath . "', description = '" . $description . "' WHERE id = '" . $edit_id . "'";
        $db ->query($updateSql);
      } else {
        $insertSql = $db->query("INSERT INTO `products` (`title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES ('$title', '$price', '$list_price', '$brand', '$category', '$dbpath', '$description', '0', '$sizes', '0')");
      }
      header("Location: products.php");
    }
    }
?>
<style>
.container-fluid{
  padding-top: 10px;
}

</style>
<!--Adding new product form--->
  <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Product</h2><hr>
  <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" style="padding:5px;" method="POST" enctype="multipart/form-data">
  <div class="form-group col-md-3" style="padding-top:10px;">
    <label for="title">Title*:</label>
    <input type="text" class="form-control" name="title" id="title" value="<?=$title;?>">
  </div>

  <div class="form-group col-md-3">
    <label for="brand">Brand*:</label>
    <select class="form-control" id="brand" name="brand">
      <option value=""<?=(($brand == '')?' selected':'');?>></option>
          <?php while ($b = mysqli_fetch_assoc($brandQuery)): ?>
      <option value="<?=$b['id'];?>"<?=(($brand == $b['id'])?' selected':'');?>><?=$b['brand'];?></option>
  <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group col-md-3">
    <label for="parent">Parent Category</label>
    <select class="form-control" id="parent" name="parent">
      <option value=""<?=(($parent == '')?' selected':'');?>></option>
      <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
      <option value="<?=$p['id'];?>"<?=(($parent == $p['id'])?' selected':'');?>><?=$p['category'];?> </option>
    <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group col-md-3">
    <label for="child">Child Category</label>
    <select class="form-control" name="child" id="child">
    </select>
  </div>

  <div class="form-group col-md-3">
    <label for="price">Price*:</label>
    <input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
  </div>
    <div class="form-group col-md-3">
    <label for="price">List Price:</label>
    <input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price;?>">
  </div>

  <div class = "form-group col-md-3">
    <label> Quantity & Sizes*: </label>
    <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle'); return false;">Quantity & sizes</button>
  </div>

  <div class="form-group col-md-3">
    <label for="sizes">Sizes & Qty Preview</label>
    <input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
  </div>
  <?php if($saved_image != ''): ?>
    <div class="saved-image"><img src="<?=$saved_image;?>" height="250px" width="250px;" alt="saved_image"/><br>
      <a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
    </div>
  <?php else: ?>
<div class="form-group col-md-6">
  <label for="photo">Product Photo: </label>
  <input type="file" name="photo" id="photo" class="form-control" height="auto" width="250px;">
<?php endif; ?>
</div>

<div class="form-group col-md-6">
  <label for="description">Description:</label>
  <textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>
</div>

<div class="form-group col-md-3 pull-right" "width: 80px;" >
  <a href="products.php" class="btn btn-default">Cancel</a>
  <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Product" class=" btn btn-success">
</div><div class="clearfix"></div>
</form>

<!-- Modal -->
<div id="sizesModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="sizesModalLabel">Size & Quanity</h4>
      </div>

      <div class="modal-body">
        <div class="container-fluid">
        <?php for($i=1;$i<=12;$i++): ?>
          <div class="form-group col-md-4">
            <label for="size<?=$i;?>">Size:</label>
            <input type="text" class="form-control" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>">
          </div>
          <div class="form-group col-md-2">
            <label for="qty<?=$i;?>">Quantity:</label>
            <input type="number" class="form-control" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0">
          </div>
        <?php endfor; ?>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save Changes</button>

      </div>
    </div>

  </div>
</div>







<?php
}else{
$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $db->query($sql);
if (isset($_GET['featured'])) {
  $id=(int)$_GET['id'];
  $featured = (int)$_GET['featured'];
  $featuredSql = "UPDATE products SET featured='$featured' WHERE id = '$id' ";
  $db->query($featuredSql);
  header('Location: products.php');
}

if (isset($_GET['popular'])) {
  $id=(int)$_GET['id'];
  $popular = (int)$_GET['popular'];
  $featuredSql = "UPDATE products SET popular='$popular' WHERE id = '$id' ";
  $db->query($featuredSql);
  header('Location: products.php');
}

?>


<div class="container-fluid">
  <h2 class="text-center" style="margin:13px;">Products</h2>
  <a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-button">Add Products</a>
  <div class="clearfix">

  </div>
<hr>
<!--table -->

<table class="table table-striped t" border="1" style="margin-top:20px;">
    <thead>
      <tr>
        <th>Edit</th>
        <th>Product</th>
        <th>Price</th>
        <th>Category</th>
        <th>Featured</th>
        <th>Popular</th>
        <th>Sold</th>
      </tr>
      </thead>
      <tbody>
 <?php while($product = mysqli_fetch_assoc($presults)):
   $childID = $product['categories'];
   $catSql = "SELECT * FROM categories WHERE id = '$childID'";
   $result = $db->query($catSql);
   $child = mysqli_fetch_assoc($result);
   $parentID = $child['parent'];
   $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
   $presult = $db->query($pSql);
   $parent = mysqli_fetch_assoc($presult);
   $category = $parent['category'].'~'.$child['category'];
    ?>
        <tr>
          <td>
          <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-pencil"></span> </a>
          <a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-remove-sign"></span> </a> </td>

          <td><?=$product['title'];?></td>
          <td><?=money($product['price']);?></td>
          <td><?=$category;?></td>
          <td><a href="products.php?featured=<?=(($product['featured']==0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default">
            <span class="glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span>
          </a>&nbsp <?=(($product['featured'] ==1 )?'Featured Product':'');?></td>
          <td><a href="products.php?popular=<?=(($product['popular']==0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default">
            <span class="glyphicon glyphicon-<?=(($product['popular']==1)?'minus':'plus');?>"></span>
          </a>&nbsp <?=(($product['popular'] ==1 )?'Popular Product':'');?></td>
          <td>0</td>

        </tr>
      <?php endwhile; ?>
      </tbody>
      </table>
</div>



<?php } include 'includes/footer.php'; ?>
 <script>
 jQuery('document').ready(function(){
   get_child_options('<?=$category;?>');
 });
 </script>
