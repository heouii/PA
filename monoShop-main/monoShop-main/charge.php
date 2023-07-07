<?php
require_once('include/stripe-php/init.php');

\Stripe\Stripe::setApiKey('sk_test_51NRK2oAOXQtmdB1JidZQS67HYPrlJGTtSgxIiYVxdTwSAcMnlOo2b0m28KqpAEcpq9Yr0U3ujuDoZE1yqu1WHnOD006zLg6ICT');

$token = $_POST['stripeToken'];
$total = filter_input(INPUT_POST, 'total', FILTER_SANITIZE_NUMBER_INT);

// Check if $total is set and is a number
if (!isset($total) || !is_numeric($total)) {
    die("Invalid payment amount.");
}

try {
    $charge = \Stripe\Charge::create([
        'amount' => $total,
        'currency' => 'eur',
        'description' => 'Paiement pour un produit',
        'source' => $token,
    ]);

    // handle successful payment
    // redirect to success page
    header('Location: payment_success.php');
    exit();

} catch (\Stripe\Error\Card $e) {
    // handle failed payment
    echo '<div class="alert alert-danger" role="alert">
            Le paiement a échoué: ' . $e->getMessage() . '
          </div>';
}
