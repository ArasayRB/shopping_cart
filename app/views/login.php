<?php
if(isset($action))
{
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
}
if(isset($_GET["sum"]))
{
  echo $_GET["sum"];
}
// connect to database
    include('./config/database.php');
    $page_title="Products List";
    include('head-login.php');
    include('./app/views/User/index.php');
