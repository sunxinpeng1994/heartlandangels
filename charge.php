<?php
    require_once("./stripe/init.php");
    
    \Stripe\Stripe::setApiKey('sk_test_MRKcfgQ1KJztFjh4fLEsIpZx00Hs3hcPTk');


    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $email = $POST['email'];
    $token = $POST['stripeToken'];
    $name = $POST['fullName'];
    
    try {
        // Use Stripe's library to make requests...
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
        //var $chargeJson = json_encode($charge);
        
        echo $charge->id.','.$charge->status;
        // header('Location: success.php?tid='.$charge->id.'&name='.$name);
      } catch(\Stripe\Exception\CardException $e) {
          echo $e->getError()->message;
        // Since it's a decline, \Stripe\Exception\CardException will be caught
        // echo 'Status is:' . $e->getHttpStatus() . '\n';
        // echo 'Type is:' . $e->getError()->type . '\n';
        // echo 'Code is:' . $e->getError()->code . '\n';
        // // param is '' in this case
        // echo 'Param is:' . $e->getError()->param . '\n';
        // echo 'Message is:' . $e->getError()->message . '\n';
      } catch (\Stripe\Exception\RateLimitException $e) {
        // Too many requests made to the API too quickly
      } catch (\Stripe\Exception\InvalidRequestException $e) {
        // Invalid parameters were supplied to Stripe's API
      } catch (\Stripe\Exception\AuthenticationException $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
      } catch (\Stripe\Exception\ApiConnectionException $e) {
        // Network communication with Stripe failed
      } catch (\Stripe\Exception\ApiErrorException $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
      } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
      }
    
   
    
    