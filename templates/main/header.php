<?php
// vendor auto-load
include_once DOCUMENT_ROOT . '/vendor/autoload.php';

 // include database and object files
include_once DOCUMENT_ROOT . '/config/db.php';

// TODO autoload classes
include_once DOCUMENT_ROOT . '/services/positions.php';
include_once DOCUMENT_ROOT . '/services/portfolio.php';
include_once DOCUMENT_ROOT . '/services/stocksAPI.php';

//use \Services;
// get database connection
$db = Database::getInstance();

global $positions;
$positions = new Positions($db);

global $stocksAPI;
$stocksAPI = new StocksAPI($db);

//TODO separate portfolios
//global $portfolio;
//$portfolio = new Portfolio($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $page['title'] ?></title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/bootstrap.min.css" />
    <!-- our custom CSS -->
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/custom.css" />
</head>

<body>
    <div class="container mt-5 mb-5">
        <h1><?= $page['title'] ?></h1>

        <a href='<?= $page['header_right_button_url'] ?>' 
           class='btn btn-outline-primary float-right mb-3' 
           role="button" 
           aria-pressed="true"><?= $page['header_right_button_title']?></a>

        <div class="clearfix"></div>