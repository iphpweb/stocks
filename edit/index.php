<?php
// set page vars
$page = [
    'title' => 'Edit existing position',
    'header_right_button_url'=> '/',
    'header_right_button_title' => 'Back to summary page' 
];

include_once $_SERVER['DOCUMENT_ROOT'] . '/env.php';
include_once DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/header.php';

global $positions;

$qid = isset($_GET['qid']) ? intval($_GET['qid']) : null;
if ($qid > 0) {
    $position = $positions->setId($qid)->getByID();
    extract($position);
}

if (
    $_POST
    && $_POST['price_avg'] != ''
    && $_POST['amount'] != ''
    ) {
    $positions->setPriceAvg($_POST['price_avg'])
        ->setAmount($_POST['amount'])
        ->setId($_POST['qid'])
        ->setUpdatedAt(time());

    if ($positions->updatePosition() == 1) { // returns affected row count
        echo "<div class='alert alert-success'>Position was updated.</div>";
    } else {
        echo "<div class='alert alert-danger'>Unable to update position.</div>";
    }
}
?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?qid=' . $_GET['qid']; ?>" method="post">
    <input type="hidden" name="qid" value="<?= $qid ?>">

    <div class="form-group">
        <label for="quote_name">Ticker</label>
        <input type="text"
               class="form-control"
               id="quote_name"
               name="quote_name"
               aria-describedby="quote_name"
               placeholder="Enter ticker"
               value="<?= isset($quote_name) ? strtoupper($quote_name) : ''?>"
               disabled>
        <small id="quote_name" class="form-text text-muted">Enter quote name, known as market ticker, short and in lower case.</small>
    </div>

    <div class="form-group">
        <label for="amount">Amount of shares</label>
        <input type="text"
               class="form-control"
               id="amount"
               name="amount"
               aria-describedby="amount"
               placeholder="Enter total amount"
               value="<?= isset($amount) ? $amount : ''?>">
        <small id="amount" class="form-text text-muted">Total amount of shares.</small>
    </div>

    <div class="form-group">
        <label for="price_avg">Average price</label>
        <input type="text"
               class="form-control"
               id="price_avg"
               name="price_avg"
               aria-describedby="price_avg"
               placeholder="Enter average price"
               value="<?= isset($price_avg) ? $price_avg : ''?>">
        <small id="price_avg" class="form-text text-muted">Average price in portfolo. Use (.)'dot' NOT (,)comma!</small>
    </div>

    <button type="submit" class="btn btn-primary">Update this position</button>
    <button type="submit" class="btn btn-primary">Delete this position</button>
</form>

<?
include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/footer.php');
