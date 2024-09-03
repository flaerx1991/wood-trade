<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- set the page title, for seo purposes too -->
    <title><?php echo isset($page_title) ? strip_tags($page_title) : ""; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

    <!-- admin custom CSS -->
    <link href="<?php echo HOME_URL . "admin/libs/css/custom.css" ?>" rel="stylesheet" />
    <link href="<?php echo HOME_URL . "admin/libs/css/style.css" ?>" rel="stylesheet" />

</head>
<body>

    <!-- include the navigation bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/navigation.php"; ?>

    <!-- container -->
    <div class="container">

        <?php
        // if given page title is 'Login', do not display the title
        if ( ($page_title!="Login") && ($page_title!="Admin") && ($page_title!="News")){
        ?>
        <div class='col-md-12' id="admin-title">
            <div class="page-header">
                <h1><?php echo isset($page_title) ? $page_title : "Simplicity"; ?></h1>
            </div>
        </div>
        <?php
        }
        ?>
