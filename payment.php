<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    var stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx');
    var elements = stripe.elements();
    var style = {
        base: {
            color: "#32325d",
        }
    };

    var card = elements.create("card", { style: style });
    card.mount("#card-element");




    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });




    var submitButton = document.getElementById('submit');

    submitButton.addEventListener('click', function(ev) {
        stripe.confirmCardPayment(clientSecret, {
            payment_method: {card: card}
        }).then(function(result) {
            if (result.error) {
            // Show error to your customer (e.g., insufficient funds)
            console.log(result.error.message);
            } else {
            // The payment has been processed!
            if (result.paymentIntent.status === 'succeeded') {
                console.log("works");
                // Show a success message to your customer
                // There's a risk of the customer closing the window before callback
                // execution. Set up a webhook or plugin to listen for the
                // payment_intent.succeeded event that handles any business critical
                // post-payment actions.
            }
            }
        });
    });
  </script>
</head>

<body>

<?php
require_once('./stripe/init.php');

\Stripe\Stripe::setApiKey('sk_test_MRKcfgQ1KJztFjh4fLEsIpZx00Hs3hcPTk');

$intent = \Stripe\PaymentIntent::create([
    'amount' => 1099,
    'currency' => 'usd',
]);



?>

<div id="card-element">
  <!-- Elements will create input elements here -->
</div>

<!-- We'll put the error messages in this element -->
<div id="card-errors" role="alert"></div>

<button id="submit">Pay</button>

</body>
</html>