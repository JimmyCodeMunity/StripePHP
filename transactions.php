<?php

require 'vendor/autoload.php'; // Include the Stripe PHP library

// Set your Stripe secret key
\Stripe\Stripe::setApiKey('sk_test_51Oc4wRJE5eZbfcv0cFDOguSg9YFS8Bswru6JaXimoGk6NbBuBy2fUi8CKTjsaHPV7dlS1cTXJrd2mmPfrJg8WjEo00fuiP5l84');

try {
    // Fetch transactions using the Stripe API
    $transactions = \Stripe\BalanceTransaction::all(['limit' => 10]); // You can adjust the limit as needed

    // Process and display transactions
    foreach ($transactions as $transaction) {
        echo "Transaction ID: " . $transaction->id . "<br>";
        echo "Amount: " . $transaction->amount / 100 . " " . strtoupper($transaction->currency) . "<br>";
        echo "Description: " . $transaction->description . "<br>";
        echo "Status: " . $transaction->status . "<br>";
        echo "------------------------------<br>";
    }
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Handle API errors
    echo "Error: " . $e->getError()->message;
}
?>
