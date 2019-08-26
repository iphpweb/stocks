<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/env.php';

// set page vars
$page = [
    'title' => 'Create new position',
    'header_right_button_url'=> '/',
    'header_right_button_title' => 'Back to summary page' 
];

include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/header.php');

if (
    $_POST
    && $_POST['quote_name'] != ''
    && $_POST['price_avg'] != ''
    && $_POST['amount'] != ''
    ) {
    $positions->quote_name = strtolower($_POST['quote_name']);
    $positions->price_avg = $_POST['price_avg'];
    $positions->amount = intval($_POST['amount']);
    //$positions->portfolio_id = $_POST['portfolio_id'];

    if ($positions->isExists()) {
        echo "<div class='alert alert-danger'>This stock already exists in a portfolio!</div>";
    } else {
        // create the product
        if ($positions->create()) {
            echo "<div class='alert alert-success'>Position was created.</div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to add position.</div>";
        }
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">
        <label for="quote_name">Ticker</label>
        <input type="text" class="form-control" id="quote_name" name="quote_name" aria-describedby="quote_name" placeholder="Enter ticker">
        <small id="quote_name" class="form-text text-muted">Enter quote name, known as market ticker, short and in lower case.</small>
    </div>

    <div class="form-group">
        <label for="amount">Average price</label>
        <input type="text" class="form-control" id="amount" name="amount" aria-describedby="amount" placeholder="Enter total amount">
        <small id="amount" class="form-text text-muted">Total amount of shares.</small>
    </div>

    <div class="form-group">
        <label for="price_avg">Average price</label>
        <input type="text" class="form-control" id="price_avg" name="price_avg" aria-describedby="price_avg" placeholder="Enter average price">
        <small id="price_avg" class="form-text text-muted">Average price in portfolo.</small>
    </div>

    <button type="submit" class="btn btn-primary">Add this position</button>
</form>

<?
include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/footer.php');
