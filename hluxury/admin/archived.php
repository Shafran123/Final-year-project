<?php
  require_once '../core/init.php';
  if(!is_logged_in())
  {
    login_error_redirect();
  }



  include 'includes/head.php';
  include 'includes/navigation.php';
  $sql="SELECT * FROM Products WHERE deleted = 1 ";
  $query=mysqli_query($db,$sql);

  if(isset($_GET['delete'])){
    $deleteid=sanitize($_GET['delete']);
    $dusql="UPDATE Products SET deleted = 0 WHERE id= '$deleteid'";
    $duquery=mysqli_query($db,$dusql);
    header('Location:Archived.php');


  }

 ?>

 <h2 class="text-center" style="margin:25px;">Deleted Products</h2>


 <table class="table table-striped t" border="1" style="margin-top:20px;">
     <thead>
       <tr>
         <th>Edit</th>
         <th>Name</th>
         <th>Price</th>
         <th>Category</th>
         <th>Featured</th>
         <th>Sold</th>
       </tr>
       </thead>
       <tbody>
         <?php while($product=mysqli_fetch_assoc($query)) { ?>
           <?php
           $childID=$product['categories'];

           $catsql="SELECT * FROM categories WHERE id = '$childID' ";
           $result=mysqli_query($db,$catsql);
           $child=mysqli_fetch_assoc($result);

           $parent_ID=$child['id'];
           $psql="SELECT * FROM categories WHERE parent = '$parent_ID' ";
           $presult=mysqli_query($db,$psql);
           $parent=mysqli_fetch_assoc($presult);





           ?>
         <tr>
           <td> <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-pencil"></span> </a>
           <a href="Archived.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-remove-sign"></span> </a> </td>

           <td><?=$product['title']?></td>
           <td><?=$product['price']?></td>
           <td><?=$parent['category']?> - <?=$child['category']?></td>
           <td><a href="products.php?featured=<?=(($product['featured']==0)?'1':'0');?>&id=<?=$product['id'];?> " class="btn btn-xs btn-default"> <span class="glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus')?> "></span> </a></td>
           <td><?=$product['deleted']?></td>

         </tr>
       <?php } ?>
       </tbody>
       </table>

 <?php include 'includes/footer.php';?>
