<?php
if($action=='added'){
    echo "<div class='alert alert-info'>";
        echo "¡Added successfully!";
    echo "</div>";
}
else if($action=='failed'){
    echo "<div class='alert alert-info'>";
        echo "We can not add your product!";
    echo "</div>";
}
if(isset($_GET["sum"]))
{
  echo $_GET["sum"];
}

// connect to database
    include('./config/database.php');
    $page_title=API_NAME;
    include('head.php');
    include('navigation.php');
    echo '<div class="text-center"><span class="h1 mx-5 my-5 text-uppercase text-dark font-weigth-bold">Esta es la página principal</span></div>';
    include('foot.php');
