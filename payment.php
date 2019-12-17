<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="./img/logo-small.jpg">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
   
<style>
/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;

  height: 40px;

  padding: 10px 12px;

  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>
</head>

<body>

<div class="container">
    <table style="margin-top:2em;margin-bottom:2em;width:100%;font-weight: bold;font-size:1.2em">
        <tr >
            <td style="box-shadow: 0 5px 5px -5px #222;">HEARTLAND ANGELS, INC</td>
            <td rowspan="2" style="width:90px">
                <img src="./img/logo-large.jpg" alt="" width="90px" height="90px">
            </td>
        </tr>
        <tr>
            <td>INDIVIDUAL MEMBERSHIP APPLICATION</td>
        </tr>
    </table>
    <h2 class="my-4 text-center">Membership Fee $1500</h2>
    <form action="./charge.php" method="post" id="payment-form">
        <div class="form-row">
            <input id="memberName" type="text" placeholder="Full Name" name="fullName" class="form-control mb-3 StripeElement StripeELement--empty">
            <input type="text" placeholder="Email" name="email" class="form-control mb-3 StripeElement StripeELement--empty">
            
            <div id="card-element" class="form-control">
            <!-- A Stripe Element will be inserted here. -->
            </div>

            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert" style="margin-top:10px;"></div>
            <div id="loaderDiv" style="display:none;margin-top:10px;">
                <img src="./img/loading.gif" alt="">
            </div>
        </div>

        <button class="btn btn-primary btn-block mt-4">Submit Payment</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    // Create a Stripe client.
    var stripe = Stripe('pk_test_d3N4EXBcqefgMpFXoLELBfbK00xC8vwDVB');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                console.log("stripe token: " + result.token.id);
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        console.log("tokenhandler function called");
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        // Submit the form
        //form.submit();
        // this is the id of the form
        
        console.log("form submit function called");
        

        
        var url = $("#payment-form").attr('action');
        var dataToSend = $("#payment-form").serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: dataToSend, // serializes the form's elements.
            beforeSend: function() {
                $("#loaderDiv").show();
            },
            success: function(data)
            {   
                $("#loaderDiv").hide();
                //$resp = JSON.parse(data);
                console.log(data);
                var resp = data.split(",");
                if(resp[1] == "succeeded") {
                    console.log("application fee received, redirect to success page");
                    window.location = 'success.php?tid='+resp[0]+'&name='+$("#memberName").val();
                } else {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = data;
                }
                
            }
        });


        
    }
  </script>
</body>
</html>