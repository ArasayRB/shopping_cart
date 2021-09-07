<!-- container -->
<div class="container">

    <div class="page-header">
        <h1><?php echo API_NAME; ?></h1>
    </div>
    <?php
    if (isset($_SESSION['name'])) {
      echo '<div class="alert alert-success">
        Welcome '.$_SESSION['name'].'</div>';
    }
    ?>
    <!-- navbar -->
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/">Shopping Cart Out</a>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php echo $page_title=="Products" ? "class='active'" : ""; ?> >
                    <a href="<?php echo BASE_URL; ?>/products">Products</a>
                </li>
                <li <?php echo $page_title=="Cart" ? "class='active'" : ""; ?> >
                   <a href="<?php echo BASE_URL; ?>/carts">
                        Cart
                    </a>
                </li>
                <li <?php echo $page_title=="LOGOUT" ? "class='active'" : ""; ?> >
                   <a href="<?php echo BASE_URL; ?>/logout">
                        LOGOUT
                    </a>
                </li>
            </ul>
        </div><!--/.nav-collapse -->

    </div>
</div>
<!-- /navbar -->
