<!--Details Modal --->
<footer> H.Luxury | Huzaifah Mansoor &copy | 2018 </footer>



<script>
function updateSizes(){
  var sizeString = '';
  for(var i=1;i<=12;i++){
    if(jQuery('#size'+i).val() != ''){
      sizeString += jQuery('#size' +i).val()+':'+jQuery('#qty'+i).val()+',';
    }
  }
  jQuery('#sizes').val(sizeString);
}

     function get_child_options(selected){
       if(typeof selected == 'undefined'){
         var selected = ''
       }


      var parentID = jQuery('#parent').val();
      jQuery.ajax({
        url: '/hluxury/admin/parsers/child_categories.php',
        type : 'POST',
        data : {parentID : parentID, selected: selected},
        success : function(data){
           jQuery('#child').html(data);
        },
        error: function(){
         alert("something is wrong with the child option")},
      });
     }
  jQuery('select[name="parent"]').change(function(){
    get_child_options();
  });
 </script>﻿




<script>

$(document).ready(function(){
  $(".btn-detail").click(function(){
    var id = $(this).attr("id");
      detailsmodal(id);
  });

  function detailsmodal(id) {
      var data = {"id": id};
      $.ajax({
       url: "/hluxury/include/getProduct.php",
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



</script>
