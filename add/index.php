<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/env.php';

// set page vars
$page = [
    'title' => 'Create new position',
    'header_right_button_url'=> '/',
    'header_right_button_title' => 'Back to summary page' 
];

include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/header.php');
?>

<?
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

    // create the product
    if ($positions->create()) {
        echo "<div class='alert alert-success'>Position was created.</div>";
    } else {
        echo "<div class='alert alert-danger'>Unable to create position.</div>";
    }
}
?>

<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Quote name (short)</td>
            <td><input type='text' name='quote_name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Average price in portfolio</td>
            <td><input type='text' name='price_avg' class='form-control' /></td>
        </tr>
        <tr>
            <td>Amount of shares in portfolio</td>
            <td><input type='text' name='amount' class='form-control' /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Add position</button>
            </td>
        </tr>
    </table>
</form>

<?
include_once(DOCUMENT_ROOT . '/' . SITE_TEMPLATE_PATH . '/footer.php');
