<?php
    if(!empty($_GET['tid'])) {
        $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);
        $tid = $GET['tid'];
        $name = $GET['name'];
    } else {
        header('Location: payment.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="./img/logo-small.jpg">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <title>Thank You</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Hello <?php echo $name ?></h2>
        <h2>Thanks for joining heartland angels</h2>
        <p>Your transaction ID is <?php echo $tid ?></p>
        <p>Check your email for more info</p>
        <p>
            <a href="index.html" class="btn btn-light mt-2">Go Back</a>
        </p>
    </div>
</body>
</html>