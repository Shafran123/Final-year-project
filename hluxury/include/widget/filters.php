<?php
   $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
   $price_sort = ((isset($_GET['price_sort']))?sanitize($_GET['price_sort']):'');
   $min_price = ((isset($_GET['min_price']))?sanitize($_GET['min_price']):'');
   $max_price = ((isset($_GET['max_price']))?sanitize($_GET['max_price']):'');
   $b = ((isset($_GET['brand']))?sanitize($_GET['brand']):'');

   $brandQ = $db->query("select * from brand");
   // var_dump($price_sort);
?>
<style type="text/css">
	#brand_search {
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2dpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NDkxMSwgMjAxMy8xMC8yOS0xMTo0NzoxNiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDowQzBFQ0NCODJCMjA2ODExODcxRkNDQkFGN0QxMEVFNyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBNjBCNzRERkI4QUUxMUUzQTlBREFCQjJBOEYzQTk4MSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBNjBCNzRERUI4QUUxMUUzQTlBREFCQjJBOEYzQTk4MSIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo0NzIzQTNBMjlDNzgxMUUzQTg2RkM1RTc4NEYxRUEwMSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo0NzIzQTNBMzlDNzgxMUUzQTg2RkM1RTc4NEYxRUEwMSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PhXKRHMAAAGdSURBVHjanJRrqwFRGIXXnoZIolDuIkX5/x988gv4IKQkkjspuZbLe2ZNZ8rM4Exn1W7PtOd9ei9rjxIRWHo8HjKZTLBarXA8HvF8PhEMBhGLxVAoFBAKhRQ+SFmg3W4n7XYbfE8mk4hEIlBK4XK5mODD4YBSqYRyuaw+gghpNptIp9OoVCrQdd318Ww2k16vh1wuh2q16obdbjdpNBrS6XSE0G9rvV5LvV4X7s4zbTqdmg/M5C8lEgmVSqUwHA5dZxrrZ0/elfNO2WwW+/0e1+tVbCA2MRqNwqs4BOp0Otkz4og1TfMM4iSp+/1uB9En5/PZM8goydwZZwPF43Esl0vPIH7r9/sRDoftoHw+b5ptPp+Lh2xkNBqBMcqq0QLR9nQszbbdbuUbpNVqwefzoVgsfr4i/X7fvGf0CUf8ekVYzng8pkXMHtVqNWQyGfUWRG02GxkMBmapr2JPWA4zWSwW6Ha7LpjudK6xmIVwksbfAIFAwGys1RMjmJsQxt2C6e/6YYxWOcf7qt9gG0zHP+WE/Rv0CjOsgx8BBgD/lAC7xzOpgwAAAABJRU5ErkJggg==);
	}

	#brand_search {
	    /*width: 116px;
	    height: 16px;*/
	    margin: 1px 0 5px;
	    padding: 8px 8px 8px 36px;
	    border: 1px solid #b8b8b8!important;
	    border-right: none;
	    background-position: 9px 7px;
	    background-repeat: no-repeat;
	    transition: width 0.5s ease-in-out;
	    /*float: left;*/
	    -webkit-appearance: none;
	    border-radius: 0;
	    box-shadow: none;
	}
</style>
<h3 class="text-center" style="margin-top: 60px; ">Search By:</h3>
<h4 class="text-center">Price</h4>
<?php $url = $_SERVER["PHP_SELF"] . '?'.http_build_query($_GET); ?>

<form action="<?php echo $url; ?>" method="post" style="padding-left:20px; padding-right:10px;">

<input type="hidden" name="cat" value="<?=$cat_id;?>">
<input type="hidden" name="price_sort" value="0">
	<input type="radio" name="price_sort" value="low" <?=(($price_sort == 'low')?' checked':'');?>>Low to High<br>
	<input type="radio" name="price_sort" value="high" <?=(($price_sort == 'high')?' checked':'');?>>High to Low<br>
	<input type="text" name="min_price" id="min_price" class="price-range" placeholder="Min" value="<?=$min_price;?>">To
	<input type="text" name="max_price" id="max_price" class="price-range" placeholder="Max" value="<?=$max_price;?>">
	<h4 class="text-center">Brand</h4>
	<input type="text" name="brand_search" id="brand_search" class="refineBrand watermark" placeholder="Search Brands" data-not-found="We didn't find a brand that matches your request">

	<div class="brand-wrapper" style="height: 300px; overflow-y: scroll; margin-bottom: 20px;">
		<input type="radio" name="brand" value="" <?=(($b == "")?" checked":"");?>>All<br>
		<?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
			<input type="radio" name="brand" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])?' checked':'');?>><?=$brand['brand'];?><br>
		<?php endwhile; ?>
	</div>
	<input type="button" id="btn-search" name="search" value="Search" class="btn btn-primary">
</form>

<script type="text/javascript">
	var brand = '<?=$b?>';
	$("#brand_search").on("keyup", function(){
		$.ajax({
          url: "ajax-func.php?mode=search_brand",
          type: "post",
          data: {
              "key": $(this).val(),
          },
          success: function(data){
            console.log(data);
            var res = JSON.parse(data);
          	$brand_html = '<input type="radio" name="brand" value=""' +  <?=(($b == "")?" 'checked'":"");?> + '>All<br>';
          	for(var i=0;i<res.length;i++) {
          		$brand_html += '<input type="radio" name="brand" value="' + res[i].id + '"';
          		if (brand == res[i].id)
          			$brand_html += " checked";
          		$brand_html += '>'+res[i].brand+'<br>';
          	}

          	$(".brand-wrapper").html($brand_html);
          },
        });
	})
</script>
