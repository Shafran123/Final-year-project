
<header>
  <div class="head1">
    <div class="headtext1">
      <span class="border trans1">
        H.Luxury Admin
      </span>
    </div>

  </div>
</header>

<nav class="navbar navbar-default navbar-expand-xl navbar-light">
  <div class="navbar-header d-flex col">
    <a class="navbar-brand" href="index.php"><i class="fa fa-cube"></i>H<b>Luxury Admin</b></a>
    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
      <span class="navbar-toggler-icon"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>
  <!-- Collection of nav links, forms, and other content for toggling -->
  <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
    <ul class="nav navbar-nav">
        <li class="nav-item active"><a href="index.php" class="nav-link"></a></li>
        <li><a href="orders.php">Orders</a></li>
      <li><a href="brands.php">Brands</a></li>
      <li><a href="categories.php">Categories</a></li>
      <li><a href="products.php">Products</a></li>
      <li><a href="archived.php">Archived</a></li>
      <li><a href="reviews.php">Reviews</a></li>

      <?php if(has_permission('admin')): ?>
               <li><a href="users.php">Users</a></li>
               <?php endif; ?>


    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first'];?>!
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="change_password.php">Change Password</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    </li>




        <!--Menu products--->
      <!---  <li class="nav-item dropdown">
          <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#"> <b class="caret"></b></a>
          <ul class="dropdown-menu">-->


    </ul>
    <form class="navbar-form form-inline">

    </form>

  </div>
</nav>
