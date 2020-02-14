<?php
// set page vars
$page = [
    'title' => 'Summary of portfolios',
    'header_right_button_url'=> '/add',
    'header_right_button_title' => 'Create new position' 
];

include_once $_SERVER['DOCUMENT_ROOT'] . '/env.php';
include_once DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/header.php';

global $positions, $stocksAPI;;

$stocks = $positions->readAll(
    $stocksAPI,
    [
        'sort_by' => 'profit'
    ]
);
?>

<div class="table-responsive">
    <table class='table table-sm table-striped table-hover table-bordered index-stocks'>
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Qnt</th>
                <th>Ave</th>
                <th>Cur</th>
                <th>+/-, $</th>
                <th>+/-, %</th>
            </tr>
        </thead>
        <tbody>
            <?
            if (count($stocks) > 0) {
                $total_delta_money = 0;

                array_walk(
                    $stocks,
                    function ($item, $key) use (&$total_delta_money) {
                        $class = 'table-' . ($item['delta_money'] > 0 ? 'success' : 'danger');

                        echo "<tr class='$class' data-thisrecordid='{$item['id']}'>";
                        echo "<td><img src='{$item['quote_icon']}'><a href='/edit?qid={$item['id']}'>{$item['quote_name']}</a></td>";
                        echo "<td>{$item['amount']}</td>";
                        echo "<td>{$item['price_avg']}</td>";
                        echo "<td>{$item['price_cur']}</td>";
                        echo "<td>{$item['delta_money']} $</td>";
                        echo "<td>{$item['delta_prcnt']} %</td>";
                        echo "</tr>";

                        $total_delta_money += $item['delta_money'];
                    }
                );

                $total_tr_class = 'bg-' . ($total_delta_money > 0 ? 'success' : 'danger');
                $current_date = date('H:i', time()) . ' on ' . date('M dS, y', time());

                echo "<tr class='{$total_tr_class}'>
                        <td colspan='4'>{$current_date}</td>
                        <td>{$total_delta_money}</td>
                        <td></td>
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