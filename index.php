<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/env.php';

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
    <table class='table table-sm table-striped table-hover table-bordered index-stocks'>
        <thead class="thead-dark">
            <tr>
                <th>Quote name</th>
                <th>Amount</th>
                <th>average Price</th>
                <th>current Price</th>
                <th>Delta, $</th>
                <th>Delta, %</th>
            </tr>
        </thead>
        <tbody>
            <?
            if ($num > 0) {
                $total_delta = 0;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $quote_icon = $stocksAPI::getLogo($quote_name);

                    $price_cur = $stocksAPI::getQuote($quote_name);

                    $delta_money = round($amount * ($price_cur - $price_avg), 2);
                    $delta_prcnt = round($delta_money*100/($price_avg * $amount), 2);

                    $class = 'table-' . ($delta_money > 0 ? 'success' : 'danger');

                    echo "<tr class='$class' data-thisrecordid='{$id}'>";
                        echo "<td><img src='{$quote_icon}'> {$quote_name}</td>";
                        echo "<td>{$amount}</td>";
                        echo "<td>{$price_avg}</td>";
                        echo "<td>{$price_cur}</td>";
                        echo "<td>{$delta_money} $</td>";
                        echo "<td>{$delta_prcnt} %</td>";
                    echo "</tr>";

                    $total_delta_money += $delta_money;
                }

                $total_tr_class = 'bg-' . ($total_delta_money > 0 ? 'success' : 'danger');
                $current_date = date('H:i', time()) . ' on ' . date('dS M, Y ', time());

                echo "<tr class='{$total_tr_class}'>
                        <td colspan='4'>Balance at {$current_date}</td>
                        <td>{$total_delta_money}</td>
                        <td>{$total_delta_prcnt}</td>
                     </tr>";
            } else {
                echo "<div class='alert alert-info'>No stock records found.</div>";
            }
            ?>
        </tbody>
    </table>
</div>

<?
include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/footer.php');