<?php
// require __DIR__ . "/vendor/autoload.php";
require 'vendor/autoload.php';

$stripe_secret_key = "sk_test_51Oc4wRJE5eZbfcv0cFDOguSg9YFS8Bswru6JaXimoGk6NbBuBy2fUi8CKTjsaHPV7dlS1cTXJrd2mmPfrJg8WjEo00fuiP5l84";



\Stripe\Stripe::setApiKey($stripe_secret_key);

// You can customize these values based on your requirements
$productName = "T-Shirt";
$productName2 = "Nike";
$priceInCents = 5000;
$priceInCents2 = 7000;
$quantity = 1;
$quantity2 = 3;
$currency = "usd";
$successUrl = "http://localhost/phpstripe/success.php";
$cancelUrl = "http://localhost/phpstripe/index.php";

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "success_url" => $successUrl,
        "cancel_url" => $cancelUrl,
        "payment_method_types" => ["card"],
        "line_items" => [
            [
                "quantity" => $quantity,
                "price_data" => [
                    "currency" => $currency,
                    "unit_amount" => $priceInCents,
                    "product_data" => [
                        "name" => $productName
                    ]
                ]
            ],
            [
                "quantity" => $quantity2,
                "price_data" => [
                    "currency" => $currency,
                    "unit_amount" => $priceInCents2,
                    "product_data" => [
                        "name" => $productName2
                    ]
                ]
            ]
        ]
    ]);

    // Redirect the user to the Checkout session URL
    header("Location: " . $checkout_session->url);
    exit;
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Handle Stripe API errors
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    // Handle other exceptions
    echo "Error: " . $e->getMessage();
}
?>

?>