</div>
<div class="btn-back-to-top bg0-hov" id="myBtn">
  <span class="symbol-btn-back-to-top">
    <i class="fa fa-angle-double-up" aria-hidden="true"></i>
  </span>
</div>
<!-- Footer -->
<footer class="bg6 p-t-45 p-b-43 p-l-45 p-r-45">
  <div class="flex-w p-b-90">
    <div class="w-size6 p-t-30 p-l-15 p-r-15 respon3">
      <h4 class="s-text12 p-b-30">
        GET IN TOUCH
      </h4>

      <div>
        <p class="s-text7 w-size27">
          Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
        </p>

        <div class="flex-m p-t-30">
          <a href="#" class="fs-18 color1 p-r-20 fa fa-facebook"></a>
          <a href="#" class="fs-18 color1 p-r-20 fa fa-instagram"></a>
          <a href="#" class="fs-18 color1 p-r-20 fa fa-pinterest-p"></a>
          <a href="#" class="fs-18 color1 p-r-20 fa fa-snapchat-ghost"></a>
          <a href="#" class="fs-18 color1 p-r-20 fa fa-youtube-play"></a>
        </div>
      </div>
    </div>

    <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
      <h4 class="s-text12 p-b-30">
        Categories
      </h4>

      <ul>
        <li class="p-b-9">
          <a href="#" class="s-text7">
            Men
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Women
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Dresses
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Sunglasses
          </a>
        </li>
      </ul>
    </div>

    <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
      <h4 class="s-text12 p-b-30">
        Links
      </h4>

      <ul>
        <li class="p-b-9">
          <a href="#" class="s-text7">
            Search
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            About Us
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Contact Us
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Returns
          </a>
        </li>
      </ul>
    </div>

    <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
      <h4 class="s-text12 p-b-30">
        Help
      </h4>

      <ul>
        <li class="p-b-9">
          <a href="#" class="s-text7">
            Track Order
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Returns
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            Shipping
          </a>
        </li>

        <li class="p-b-9">
          <a href="#" class="s-text7">
            FAQs
          </a>
        </li>
      </ul>
    </div>

    <div class="w-size8 p-t-30 p-l-15 p-r-15 respon3">
      <h4 class="s-text12 p-b-30">
        Newsletter
      </h4>

      <form>
        <div class="effect1 w-size9">
          <input class="s-text7 bg6 w-full p-b-5" type="text" name="email" placeholder="email@example.com">
          <span class="effect1-line"></span>
        </div>

        <div class="w-size2 p-t-20">
          <!-- Button -->
          <button class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">
            Subscribe
          </button>
        </div>

      </form>
    </div>
  </div>

  <div class="t-center p-l-15 p-r-15">
    <a href="#">
      <img class="h-size2" src="img/icons/paypal.png" alt="IMG-PAYPAL">
    </a>

    <a href="#">
      <img class="h-size2" src="img/icons/visa.png" alt="IMG-VISA">
    </a>

    <a href="#">
      <img class="h-size2" src="img/icons/mastercard.png" alt="IMG-MASTERCARD">
    </a>

    <a href="#">
      <img class="h-size2" src="img/icons/express.png" alt="IMG-EXPRESS">
    </a>

    <a href="#">
      <img class="h-size2" src="img/icons/discover.png" alt="IMG-DISCOVER">
    </a>

    <div class="t-center s-text8 p-t-20">
      Copyright © 2018 All rights reserved. | Hluxury | Huzaifah Mansoor
    </div>
  </div>
</footer>

<!--Details Modal --->
<script>



$(document).ready(function(){
  $(".btn-detail").click(function(){
    var id = $(this).attr("id");
      detailsmodal(id);
  });

  function detailsmodal(id) {
      var data = {"id": id};
      $.ajax({
       url: "/hluxury/modaldetails.php",
       method: "post",
       data: data,
       success:function(data){
         data = data.replace(/&quot;/g, '"');


          json = jQuery.parseJSON(data);

          $("#product_title").text(json.title);
          $("#product_img").attr("src", json.image);
          $("#product_desc").text(json.description);
          $("#product_price").text("Price : "+json.price);
          $("#product_brand").text("Brand : "+json.brand);
          var sizes = json.sizes.split(',');
          $("#size").html("");
          for (var i = 0; i < sizes.length; i++) {
            var k = sizes[i].split(':');
            if (i == 0)
              $("#size").append("<option value='" + k[0] + "' selected>" + k[0] + " (" + k[1] + " Available)</option>");
            else
              $("#size").append("<option value='" + k[0] + "'>" + k[0] + " (" + k[1] + " Available)</option>");
          }
        //  console.log(sizes);

          // for (var i = 0; i < sizes.length; i++){
          //   $("#size").append("<option value='" + i + "'>" + sizes[i] + "</option>");
          // }
       },
       error:function()
       {
          alert("Something went wrong!");
       }
     });
  }


    // var data = {"id": id};
    // jQuery.ajax({
    //  url: "include/detailsmodal.php",
    //  method: "post",
    //  data: data,
    //  success:function(data)
    //  {
    //    //alert(data);
    //   $('body').append(data);
    //   // jquery('#dtai

    //   $('#details-modal').toggle();
    //  },
    //  error:function()
    //  {
    //   alert("Something went wrong!");
    //  }

    // });



});

function update_cart(mode,edit_id,edit_size){
  var data = {"mode":mode,"edit_id":edit_id,"edit_size":edit_size};
  jQuery.ajax({
    url: '/hluxury/admin/parsers/update_cart.php',
    method: "post",
    data : data,
    success : function(){location.reload();},
    error : function(){alert("something went wrong.");}
  });
}

function add_to_cart(){
  $('#modal_errors').html("");
  var size = $('#size').val();
  var quantity = $('#quantity').val();
  var available = $('#available').val();
  var error = '';
  var data = $('#add_product_form').serialize();
  if(size == '' || quantity == '' || quantity == 0){
    error += '<p class="text-danger text-center">You must choose a size and quantity.</p>';
    $('#modal_errors').html(error);
    return;
  }else if (quantity > available) {
            error += '<p class="text-center text-danger"> There are only '+available+' available.</p>';
            $('#modal_errors').html(error);
            return;
  }else{
    $.ajax({
      url : '/hluxury/admin/parsers/add_cart.php',
      method : 'post',
      data: data,
      success : function(){
        location.reload();
      },
      error : function(){alert("Something went wrong");}
    });
  }
}


</script>


	<script src="js/main.js"></script>


</body>

</html>
