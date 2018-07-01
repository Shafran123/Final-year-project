<?php
require_once 'core/init.php';
include 'include/head.php';
include 'include/navigation.php';
include 'include/headerfull.php';
include 'include/leftbar.php';

$session_id = session_id();

   $sql = "SELECT wishlist.id as id, products.id as product_id, products.title as title, products.list_price as price, products.image as image FROM wishlist LEFT JOIN products on products.id = product_id WHERE session_id = '$session_id'";
   $res=mysqli_query($db, $sql);
?>
<style>
  .data-table {
      background: #fff none repeat scroll 0 0;
      border: 1px solid #f2f2f2;
      width: 100%;
  }
  th {
    padding: 15px;
    /*min-width: 60px;*/

  }
  .data-table th, .data-table td {
    border-bottom: 1px solid #dddddd;
    border-right: 1px solid #dddddd;
  }

  .data-table th {
      background: #f7f7f7 none repeat scroll 0 0;
      border-right: 1px solid #f2f2f2;
      color: #4d4d4d;
      font-family: Lato;
      font-size: 16px;
      font-weight: normal;
      /*min-width: 100px;*/
      padding: 6px 10px;
      text-align: center;
      text-transform: capitalize;
      vertical-align: middle;
      white-space: nowrap;
  }
  .sop-icon1 {
    text-align: center;
  }
  .sop-icon1 a {
      border: 0 none;
      border-radius: 100%;
      color: red !important;
      display: inline-block;
      font-size: 1.5em;
      font-weight: 700;
      height: 25px;
      line-height: 25px;
      text-decoration: none;
      width: 25px;
      padding-left: 3px;
  }

  .sop-icon1 a:hover {
      background: red none repeat scroll 0 0;
      color: #fff !important;
  }
  .data-table img {
    width: 100px;
  }

  .data-table td {
    text-align: center;
    font-size: 1.5em;
  }

  span.checked {
      color: orange;
  }
</style>
         <!--this is going to be main content showing products-->
         <!---main content -->
         <div class="col-md-8 i_categories" >
           <h2 class="text-center" style="padding-right:-220px; font-size:30px; "> My Wishlist </h2>
             <br><br>

             <div class="row" style="padding-top: 100px; padding-left:50px;padding-right: -50px; ">
                <table class="data-table">
                  <thead>
                    <tr>
                      <th>&nbsp;</th>
                      <th>image</th>
                      <th>Product Name</th>
                      <th>Product Price</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      while($row = mysqli_fetch_assoc($res)) {
                        echo '<tr>';
                          echo '<td class="sop-icon1"><a href="#" data-id="'.$row['id'].'" class="remove-wish"><i class="fa fa-times"></i></a></td>';
                          echo '<td style="padding:7px;"><img src="'.$row['image'].'"></td>';
                          echo '<td>'.$row['title'].'</td>';
                          echo '<td>'.currencyConverter($currency, $row['price']).'</td>';
                          echo '<td><button type="button" id="'.$row['product_id'].'" class="btn btn-outline-dark  btn-detail cart_details" style="padding:15px; width: 80px; font-size:15px;" data-toggle="modal" data-target="#details-1">Details</button></td>';
                        echo '</tr>';
                      }

                    ?>
                  </tbody>
                </table>
             </div>
           </div>
           <div class="modal fade details-1" id="details-1" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
           <div class="modal-dialog modal-lg">
           <div class="modal-content">

           </div>
           </div>
          </div>

          <script>
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

          $('.remove-wish').on("click", function(){
              $wishlist_id = $(this).attr('data-id');
              console.log($wishlist_id);
              $.ajax({
                url: "ajax-func.php?mode=remove_wish",
                type: "post",
                data: {
                    "product_id": $wishlist_id,
                },
                success: function(data){
                  console.log(data);
                  location.reload();
                },
              });
          })
          </script>
           <?php

           //include 'include/detailsmodal.php';

           include 'include/footer.php';
           ?>
