<?php
@include('config.php');
// require __DIR__ . "/vendor/autoload.php";
require 'vendor/autoload.php';

error_reporting( E_ALL );
    ini_set( "display_errors", 1 );


$stripe_secret_key = "sk_test_51Oc4wRJE5eZbfcv0cFDOguSg9YFS8Bswru6JaXimoGk6NbBuBy2fUi8CKTjsaHPV7dlS1cTXJrd2mmPfrJg8WjEo00fuiP5l84";



\Stripe\Stripe::setApiKey($stripe_secret_key);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Initialize line items array
$lineItems = [];

if ($result->num_rows > 0) {
    // Loop through the products and add them to line items
    while ($row = $result->fetch_assoc()) {
        $pname = $row["productname"];
        $price = $row["price"];
        $lineItems[] = [
            "quantity" => 1, // Adjust quantity as needed
            "price_data" => [
                "currency" => "usd", // Adjust currency as needed
                "unit_amount" => $price * 100, // Convert price to cents
                "product_data" => [
                    "name" => $pname,
                ],
            ],
        ];
    }
} else {
    echo "No products found";
}

// Close the database connection
// $conn->close();

// Create a Checkout session with the dynamic line items
try {
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "success_url" => "http://localhost/phpstripe/success.php",
        "cancel_url" => "http://localhost/phpstripe/index.php",
        "payment_method_types" => ["card"],
        "line_items" => $lineItems,
    ]);



    // try{
    //     $paysql = "INSERT INTO transactions(productname,price)VALUES('$pname','$price')";
    // $paysuccess = mysqli_query($conn,$paysql);

    // if($paysuccess){
    //     echo "Transaction saved successfully";
    // }

    // }catch (Exception $e){
    //     echo "Transaction not saved";
    // }

    // Redirect the user to the Checkout session URL
    // header("Location: " . $checkout_session->url);
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