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

<div class="table-responsive">
    <table class='table table-striped table-hover table-bordered index-stocks'>
        <thead class="thead-dark">
            <tr>
                <th>Quote name</th>
                <th>Amount</th>
                <th>Price average</th>
                <th>Price current</th>
                <th>Delta</th>
            </tr>
        </thead>
        <tbody>
            <?
            if ($num > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    
                    $price_cur = 0; //$stocksAPI::getQuote($quote_name);
                    $delta = $amount * ($price_cur - $price_avg);
                    $class = 'bg-' . ($delta > 0 ? 'success' : 'danger');

                    echo "<tr class='$class' data-thisrecordid='{$id}'>";
                        echo "<td>{$quote_name}</td>";
                        echo "<td>{$amount}</td>";
                        echo "<td>{$price_avg}</td>";
                        echo "<td>{$price_cur}</td>";
                        echo "<td>{$delta}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><div class='alert alert-info'>No stock records found.</div></tr>";
            }
        echo "</tbody>";
    echo "</table>";
echo "</div>";

include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/footer.php');
