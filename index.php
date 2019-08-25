<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/env.php';

// set page vars
$page = [
    'title' => 'Summary of portfolios',
    'header_right_button_url'=> '/add',
    'header_right_button_title' => 'Create new position' 
];

include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/header.php');

$stmt = $positions->readAll();
$num = $stmt->rowCount();
?>

<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <th>Quote name</th>
        <th>Amount</th>
        <th>Price average</th>
        <th>Price current</th>
        <th>Delta</th>
    </tr>

<?
if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        echo "<tr data-thisrecordid='{$id}'>";
            echo "<td>{$quote_name}</td>";
            echo "<td>{$amount}</td>";
            echo "<td>{$price_avg}</td>";

            $price_cur = $stocksAPI::getPrice($quote_name);
            echo "<td>{$price_cur}</td>";

            $delta = $amount * ($price_cur - $price_avg);
            echo "<td>{$delta}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<tr><div class='alert alert-info'>No stock records found.</div></tr>";
}

include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/footer.php');
