<?php
    require_once("./stripe/init.php");
    echo "submitted";
    \Stripe\Stripe::setApiKey('sk_test_MRKcfgQ1KJztFjh4fLEsIpZx00Hs3hcPTk');


    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $email = $POST['email'];
    $token = $POST['stripeToken'];

    echo $token;


    //create customer in stripe
    $customer = \Stripe\Customer::create(array(
        "email" => $email,
        "source" => $token
    ));
    //charge the customer
    $charge = \Stripe\Charge::create(array(
        "amount" => 1500,
        "currency" => "usd",
        "description" => "membership fee",
        "customer" => $customer->id
    ));
    print_r($customer);
    print_r($charge);
    // $intent = \Stripe\PaymentIntent::create([
    //     'amount' => 1099,
    //     'currency' => 'usd',
    // ]);