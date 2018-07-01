<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/hluxury/core/init.php';
if (!is_logged_in()) {
	login_error();
}
if (!has_permission('admin')) {
	permission_error('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';
if(isset($_GET['delete'])){
		$delete_id = sanitize($_GET['delete']);
		$db->query("DELETE FROM orders WHERE id = '$delete_id'");
		$_SESSION['success_flash'] = 'Order has been deleted!';
		header('Location: orders.php');
}
if(isset($_GET['add'])){
	$product_id = ((isset($_POST['product']))?sanitize($_POST['product']):'');
	$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$review = ((isset($_POST['review']))?sanitize($_POST['review']):'');
	$rating = ((isset($_POST['rating']))?sanitize($_POST['rating']):'');
	$created_at = date('Y-m-d');
	$sql = "SELECT products.*, brand.id as brand_id, brand.brand as brand_name FROM products LEFT JOIN brand on brand.id = products.brand WHERE featured = '1'";
	$result = mysqli_query($db, $sql);
	  $rowcount=mysqli_num_rows($result);
echo $rowcount;

	if($_POST){
		//Add review to the database
  		$insert_review = "INSERT INTO reviews (product_id, name, email, review, rating, created_at) VALUES ('$product_id','$name', '$email', '$review', '$rating', '$created_at')";
  		// echo $insert_review;

  		$db->query($insert_review);
		$_SESSION['success_flash'] = 'Review Has been added!';
		header('Location: reviews.php');
	}
	?>
	<style type="text/css">
		select {
			display: block;
		    width: 100%;
		    height: 34px;
		    padding: 6px 12px;
		    font-size: 14px;
		    line-height: 1.42857143;
		    color: #555;
		    background-color: #fff;
		    background-image: none;
		    border: 1px solid #ccc;
		    border-radius: 4px;
		    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		}
	</style>
	<h2 class="text-center">Add A New Review</h2><hr>
	<form action="reviews.php?add=1" method="POST" class="">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="name">Product:</label>
				<Select name="product" id="product">
					<?php
						while($row = mysqli_fetch_assoc($result)) {
							echo '<option value='.$row['id'].'>'.$row['title'].'</option>';
						}
					?>
				</Select>
			</div>
		</div>
		<div class="form-group col-md-6">
			<label for="name">Name:</label>
			<input type="name" name="name" id="name" class="form-control" value="<?=$name; ?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="email">Email:</label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email; ?>"/>
		</div>
		<div class="form-group col-md-6">
			<label for="password">Review:</label>
			<textarea id="review" name="review" class="form-control" style="height: 100px;"><?=$review?></textarea>
		</div>
		<div class="form-group col-md-6">
			<label for="permissions">Ratings</label>
			<select name="rating" id="rating" class="form-control">
				<?php
					for($i=5;$i>=1;$i--){
						echo '<option value="'.$i.'" ';
						if ($i == $rating)
							echo 'selected';
						echo '>'.$i.'</option>';
					}
				?>
			</select>
		</div><br>
		<div class="form-group col-md-6">
			<a href="reviews.php" class="btn btn-default">Cancel</a>
			<input type="submit" name="" value="Add Review" class="btn btn-primary">
		</div>
	</form><hr><br><br><br><br><br><br><br><br>
	<?php
}else{
$orderQuery = $db ->query("SELECT orders.*, customers.name as customer_name FROM orders LEFT JOIN customers on customers.id = orders.customer_id");
?>

<h2>Orders</h2>
<!-- <a href="orders.php?add=1" class="btn btn-success pull-right" id="btn-addproduct">Add New Review</a><hr> -->
<table class="table table-bordered table-striped table-condensed">
	<thead>
		<!-- <th></th> --><th>Customer</th><th>Order Date</th><th>Price</th><th>Tax</th><th>Total</th><th>Name</th>
		<th>Email</th><th>Address1</th><th>Address2</th><th>City</th><th>State</th><th>Zip</th><th>Country</th><th>Status</th>
	</thead>
	<tbody>
		<?php while($order = mysqli_fetch_assoc($orderQuery)): ?>
			<tr>
				<td>
					<a href="orders.php?delete=<?=$order['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
				</td>
				<td><?=$order['customer_name']; ?></td>
				<td><?=$order['order_date']; ?></td>
				<td><?=$order['ship_price']; ?></td>
				<td><?=$order['tax'] ?></td>
				<td><?=$order['sub_total'] ?></td>
				<td><?=$order['name']; ?></td>
				<td><?=$order['email']; ?></td>
				<td><?=$order['ship_address1']; ?></td>
				<td><?=$order['ship_address2']; ?></td>
				<td><?=$order['ship_city'] ?></td>
				<td><?=$order['ship_state'] ?></td>
				<td><?=$order['ship_zip']; ?></td>
				<td><?=$order['ship_country']; ?></td>
				<td><?=$order['status']; ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
<?php }
include 'includes/footer.php';
?>
