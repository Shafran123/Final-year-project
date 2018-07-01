<?php
require_once 'core/init.php';
include 'include/head.php';
include 'include/navigation.php';
include 'include/headerfull.php';
include 'include/leftbar.php';

   $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
   $price_sort = ((isset($_GET['price_sort']))?sanitize($_GET['price_sort']):'');
   $min_price = ((isset($_GET['min_price']))?sanitize($_GET['min_price']):'');
   $max_price = ((isset($_GET['max_price']))?sanitize($_GET['max_price']):'');
   $b = ((isset($_GET['brand']))?sanitize($_GET['brand']):'');

   // if(isset($_GET['cat'])){
   //   $cat_id = sanitize($_GET['cat']);
   // }else{
   //   $cat_id = '';
   // }

   $search = isset($_GET['search'])?$_GET['search']:"";

   $sql = "SELECT products.*, brand.brand as brand_name FROM products LEFT JOIN brand on products.brand = brand.id WHERE featured = '1'";
   if ( $cat_id )
    $sql .= " and categories = '$cat_id'";
   if ( $search )
     $sql .= " and (title like '%".$search."%' or description like '%".$search."%' or brand.brand like '%".$search."%')";

   if ( $b )
      $sql .= " and products.brand=$b";
   if ( $min_price && $max_price )
      $sql .= " and (price >= $min_price and price <= $max_price)";
   if ($price_sort == 'low')
    $sql .= " order by price ASC";
   else if ($price_sort == 'high')
    $sql .= " order by price DESC";

  // echo $sql;
   $productQ = $db->query($sql);

   $product_array = array();
   $num = 0;
   while($row = mysqli_fetch_assoc($productQ)) {
    $product_array[$num++] = $row;
   }

   $category = get_category($cat_id);

   $perpage = 6;
   if (isset($_GET['page']) & !empty($_GET['page'])) {
      $curpage = $_GET['page'];
   } else {
      $curpage = 1;
   }

   $start = ($curpage * $perpage) - $perpage;
   $end = ($curpage * $perpage);

   $totalres = $productQ->num_rows;
   $endpage = ceil($totalres / $perpage);
   $startpage = 1;
   $nextpage = $curpage + 1;
   $previouspage = $curpage - 1;
?>
<style>
.modal-dialog {
	padding-top: 26px;
}

.col-md-4{
  padding-top: 30px;
  padding-bottom: 20px;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1030;
  background-color: #333333;
  opacity:0.80; // I ADDED THIS LINE
}
.img-thumb{
  width: 370px;
  height: 500px;

}
.col-md-8{
  /*max-width: 1200px;*/
}

.i_categories img {
  width: 100%;
  height: auto;
}

.review {
      border: solid 1px;
    margin-bottom: 5px;
    padding: 5px 10px;
}
#form_review textarea{
    width: 100%;
    height: 90px;
    border: 50px;
    outline: none;
    box-shadow: inset 0 0 1000px #eee;
    border-radius: 3px;
    margin-bottom: 10px;
    margin-top: 5px;
    font-family: sans-serif, Arial;
    font-size: 16px;
}

span.checked {
    color: orange;
}

.star_rating {
  float: right;
}

.review label {
  color: #777;
  font-size: 12px;
}

.pagination {
  float: right;
}
form > .textbox {
  outline: 0;
  height: 42px;
  width: 244px;
  line-height: 42px;
  padding: 0 16px;
  background-color: rgba(255, 255, 255, 0.8);
  color: #212121;
  border: 0;
  float: left;
  -webkit-border-radius: 4px 0 0 4px;
  border-radius: 4px 0 0 4px;
}

form > .textbox:focus {
  outline: 0;
  background-color: #FFF;
}

form > .button {
  outline: 0;
  background: none;
  background-color: rgba(38, 50, 56, 0.8);
  float: left;
  height: 42px;
  width: 42px;
  text-align: center;
  line-height: 42px;
  border: 0;
  color: #FFF;
  font: normal normal normal 14px/1 FontAwesome;
  font-size: 16px;
  text-rendering: auto;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  -webkit-transition: background-color .4s ease;
  transition: background-color .4s ease;
  -webkit-border-radius: 0 4px 4px 0;
  border-radius: 0 4px 4px 0;
}

form > .button:hover {
  background-color: rgba(0, 150, 136, 0.8);
}
</style>
         <!--this is going to be main content showing products-->
         <!---main content -->
         <div class="col-md-10 i_categories" >
            <div class="row">
              <div class="col-md-8">
                <h2 class="text-center" style="padding-left:120px; font-size:30px; ">
                  <?php
                      if ($search != '') {
                        echo $search . ' collection';
                      } else {
                        echo $category['parent']. ' - ' . $category['child'];
                      }
                  ?>
                </h2>
              </div>
              <div style="padding-top: 0px; float: right;">
                <form id="search_form" method="post" style="margin-top: 0px;">
                  <input type="text" class="textbox" placeholder="Search" id="search" value="<?= $search ?>">
                  <input id="search-btn" title="Search" value="" type="button" class="button" style="margin-top: 5px;">
                </form>
              </div>
            </div>
             <br><br>
             <?php if ( $totalres != 0 ) { ?>
             <div class="row">
              <div class="pagination-container col-md-12">
              <form id='page-form' method="post" style="margin-top: 0px;" >
                <ul class="pagination">
                  <?php
                    if($curpage != $startpage) {
                  ?>
                  <li class="page-item">
                    <a class="page-link" href="#" onclick="goPage(<?php echo $startpage ?>)" tabindex="-1" aria-label="Previous">
                      <span aria-hidden="true">&Lang;</span>
                      <span class="sr-only">First</span>
                    </a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php if($curpage >= 2){ ?>
                    <li class="page-item">
                      <a class="page-link" href="#"  onclick="goPage(<?php echo $previouspage ?>)">&lang;</a>
                    </li>
                  <?php } ?>
                  <?php
                    for($i=$startpage;$i<=$endpage;$i++) {
                      echo '<li class="page-item">';
                      echo '<a class="page-link" href="#"  onclick="goPage('.$i.')">'.$i.'</a>';
                      echo '</li>';
                    }
                  ?>

                  <?php if($curpage < $endpage){ ?>
                      <li class="page-item">
                        <a class="page-link" href="#" onclick="goPage(<?php echo $nextpage ?>)">&rangle;</a>
                      </li>
                  <?php } ?>
                  <?php
                    if ($curpage != $endpage ) {
                  ?>
                    <li class="page-item">
                      <a class="page-link" href="#"  onclick="goPage(<?php echo $endpage ?>)"aria-label="Next">
                        <span aria-hidden="true">&Rang;</span>
                        <span class="sr-only">Last</span>
                      </a>
                    </li>
                  <?php
                    }
                  ?>
                </ul>
              </form>
             </div>
             </div>
             <?php } ?>
             <div class="row">
               <?php for($i=$start; $i<$end; $i++) {
                  if($i>=$totalres)
                    break;
                  $product = $product_array[$i];
               ?>
               <div class="col-md-4" >
                 <h4 id=""><?=$product['brand_name']?></h4>
                 <h4><?php echo $product['title']; ?></h4>
                 <img src="<?php echo $product['image'] ?>" alt="<?php echo $product['title']; ?>"class="img-thumb"/>
                 <p class="list-price text-danger">List Price<s><?php echo currencyConverter($currency, $product['list_price']); ?></s></p>
                 <p class="price">Our Price: <?php echo currencyConverter($currency, $product['price']); ?></p>
                 <button type="button" id="<?php echo $product['id'];?>" class="btn btn-outline-dark  btn-detail cart_details" style="padding:15px; font-size:15px;" data-toggle="modal" data-target="#details-1">Details</button>
                 <button type="button" id="wish-<?php echo $product['id'];?>" class="btn btn-outline-dark  btn-detail add_wishlist" style="padding:15px; font-size:15px; margin-left: 15px;" data-toggle="modal" data-id="<?php echo $product['id'];?>">Add to WishList</button>
                 </div>
               <?php } ?>
             </div>
             <?php
                if($curpage != $startpage) {
              ?>
             <div class="pagination-container">
              <form id='page-form' method="post" >
                <ul class="pagination">
                  <?php
                    if($curpage != $startpage) {
                  ?>
                  <li class="page-item">
                    <a class="page-link" href="#" onclick="goPage(<?php echo $startpage ?>)" tabindex="-1" aria-label="Previous">
                      <span aria-hidden="true">&Lang;</span>
                      <span class="sr-only">First</span>
                    </a>
                  </li>
                  <?php
                    }
                  ?>
                  <?php if($curpage >= 2){ ?>
                    <li class="page-item">
                      <a class="page-link" href="#"  onclick="goPage(<?php echo $previouspage ?>)">&lang;</a>
                    </li>
                  <?php } ?>
                  <?php
                    for($i=$startpage;$i<=$endpage;$i++) {
                      echo '<li class="page-item">';
                      echo '<a class="page-link" href="#"  onclick="goPage('.$i.')">'.$i.'</a>';
                      echo '</li>';
                    }
                  ?>

                  <?php if($curpage < $endpage){ ?>
                      <li class="page-item">
                        <a class="page-link" href="#" onclick="goPage(<?php echo $nextpage ?>)">&rangle;</a>
                      </li>
                  <?php } ?>
                  <?php
                    if ($curpage != $endpage ) {
                  ?>
                    <li class="page-item">
                      <a class="page-link" href="#"  onclick="goPage(<?php echo $endpage ?>)"aria-label="Next">
                        <span aria-hidden="true">&Rang;</span>
                        <span class="sr-only">Last</span>
                      </a>
                    </li>
                  <?php
                    }
                  ?>
                </ul>
              </form>
             </div>
             <?php } ?>
           </div>
           <div class="modal fade details-1" id="details-1" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
           <div class="modal-dialog modal-lg">
           <div class="modal-content">

           </div>
           </div>
          </div>

          <script>
            var cat_id = '<?php echo $cat_id; ?>';
            var cur_page = <?php echo $curpage; ?>;
          function goPage(page) {
            var price_sort = $("input[name='price_sort']:checked").val();
            var min_price = $("#min_price").val();
            var max_price = $("#max_price").val();
            var b = $("input[name='brand']:checked").val();
            var search = $("#search").val();

            cur_page = page;
            var location = "category.php?";
            if( cat_id )
              location += "cat=" + cat_id + "&";
            if ( search )
              location += "search="+ search + "&";
            if ( cur_page )
              location += "page=" + cur_page + "&";
            if ( price_sort != ''&& price_sort != undefined )
              location += "price_sort=" + price_sort + "&";
            if ( min_price != '' && max_price != '')
              location += "min_price=" + min_price + "&" + "max_price=" + max_price + "&";
            if ( b != '')
              location += "brand=" + b + "&";

            location = location.substring(0, location.length-1);
            document.location.href = location;
            //$("#page-form").attr('action', location);
            //$("#page-form").submit();
            // console.log(location);

          }
          $('.cart_details').click(function(){
              var proID=$(this).attr('id');
              $.ajax({
                url:"modaldetails.php",
                type:"POST",
                data : "id ="+proID,
                cache:false,
                success:function(result){
                  $(".modal-content").html(result);
                }
              });
          });

          $(".add_wishlist").on("click", function() {
            $id = $(this).attr('data-id');
            $.ajax({
              url: "ajax-func.php?mode=add_wishlist",
              type: "post",
              data: {
                  "product_id": $id,
              },
              success: function(data){
                console.log(data);
                location.reload();
              },
            });
          });
          $("#search-btn").on("click", function(event){
            goPage(cur_page);
          });

          $("#search_form").on("submit", function(event) {
            event.preventDefault();
          });

          $("#search").on("keyup", function(event) {
            // console.log(event.keyCode);
            // event.preventDefault();
            if(event.keyCode == 13) {
              goPage(cur_page);
            }
          });

          $("#btn-search").on("click", function(){
            console.log('click');
            goPage(cur_page);
          })

          $("#page-form").submit(function(event) {

          });
          </script>
           <?php

           //include 'include/detailsmodal.php';

           include 'include/footer.php';
           ?>
