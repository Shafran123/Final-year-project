<?php
require_once '../core/init.php';
if(!is_logged_in())
{
  login_error_redirect();
}

include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';

//get brands from database
$sql = "SELECT * FROM brand ORDER BY brand";
$results = $db->query($sql);
$errors = array();

//Edit brand
if(isset($_GET['edit']) && !empty($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $edit_id = sanitize($edit_id);
  $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
  $edit_result = $db->query($sql2);
  $eBrand = mysqli_fetch_assoc($edit_result);
}

//Delete Brand
if(isset($_GET['delete']) && !empty($_GET['delete'])){
  $delete_id = (int)$_GET ['delete'];
  $delete_id = sanitize($delete_id);
  $sql =  "DELETE FROM brand WHERE id = '$delete_id'";
  $db->query($sql);
  header('Location: brands.php');
}

//If add form is submitted
if(isset($_POST['add_submit'])){
    $brand = sanitize($_POST['brand']);
    //check if brand is blank
    if($_POST['brand'] == ''){
      $errors[] .='You must enter a brand';
    }
    // check if brand exists in database
    $sql ="SELECT * FROM brand WHERE brand = '$brand'";
    if(isset($_GET['edit'])){
      $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
    }
    $result = $db->query($sql);
    $count = mysqli_num_rows($result);
    if($count > 0){
      $errors[] .= $brand. ' already exists. Please choose another brand name..';
    }

    //display errors
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //Add brand to database
      $sql = "INSERT INTO brand(brand) VALUES('$brand')";
      if(isset($_GET['edit'])){
        $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
      }
      $db->query($sql);
      header('Location: brands.php');
    }

}


?>

<h2 class="text-center" style="margin:35px;15px">Brands</h2>

<hr>
<hr>
<div class="text-center">
  <center>
  <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post" style="margin-top:50px;">
    <div class="form-group" style="margin: 0 auto;">
      <?php
      $brand_value = '';
      if(isset($_GET['edit'])){
          $brand_value = $eBrand['brand'];
      }else{
        if(isset($_POST['brand'])){
          $brand_value = sanitize($_POST['brand']);
        }
      } ?>
      <label for="brand"><?=((isset($_GET['edit']))?'&nbsp;&nbsp;Edit':'Add a ');?> Brand: </label>
      <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value; ?>" >
      <?php if(isset($_GET['edit'])): ?>
        <a href="brands.php" class="btn btn-default">Cancel</a>

        <?php endif; ?>
      <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?>Brand" class="btn btn-success" style="width:150px; background: #13b15b;">
    </div>
   </form>
   </center>
</div>
<hr>
<hr>
<hr>
<table class="table table-bordered table-striped table-condensed"  border="1" style="width:65%;margin-left:280px;border-color:green; ">
  <thead>
    <th></th><th>Brands</th><th></th>
  </thead>
  <tbody>
    <?php while($brand = mysqli_fetch_assoc($results)): ?>
      <tr>
        <td> <a href="brands.php?edit=<?= $brand['id'] ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-pencil"></span> Edit</a> </td>
        <td><?= $brand['brand'] ?></td>
        <td> <a href="brands.php?delete=<?= $brand['id'] ?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-remove-sign"></span>Remove </a> </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>



<?php include 'includes/footer.php'; ?>
