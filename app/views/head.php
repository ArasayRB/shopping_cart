<?php
ob_start();
session_start();
$error = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo API_NAME ? $page_title : "Shopping Cart "; ?> - DEMO</title>
     <!-- Bootstrap CSS -->
    <link href="./library/css/bootstrap.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="./library/css/style-star.css">
    <script type="text/javascript" src="./library/js/jquery-3.5.0.min.js"></script>
    <script type="text/javascript" src="./library/js/jquery.rating.pack.js"></script>
</head>
<body>
