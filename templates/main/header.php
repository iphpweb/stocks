<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Moscow');

// get database connection
$db = Database::getInstance();

global $positions;
$positions = new \Positions($db);

global $stocksAPI;
$stocksAPI = new \StocksAPI($db);

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
    <div class="container">
        <div class="row d-flex">
            <div class="col d-flex">
                <h1><?= $page['title'] ?></h1>
            </div>

            <div class="col align-self-center d-flex">
                <button href='<?= $page['header_right_button_url'] ?>'
                   class='btn btn-outline-primary ml-auto'
                   role="button"
                   aria-pressed="true"><?= $page['header_right_button_title']?></button>
            </div>
        </div>

        <div class="w-100"></div>