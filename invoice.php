<?php
    session_start();

    //Prevent URL Hacking - Redirect
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: cart.php");
        exit;
    }

    //Redirect if cart or total is blank
    if(empty($_SESSION['cart'])){
        header("Location: cart.php");
        exit;
    }
    if($_SESSION['ordertotal'] <= 0){
        header("Location: cart.php");
        exit;
    }


    $blankfields = [];
    $ordertotal = $_SESSION['ordertotal'] ?? 0;
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $firstaddress = $_POST['firstaddress'] ?? '';
    $secondaddress = $_POST['secondaddress'] ?? '';
    $towncity = $_POST['towncity'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $cardnumber = $_POST['numbercard'] ?? '';


    //Trap invalid input errors - redirect back to cart
    $errors = [];

    // Phone number validation
    if (!preg_match('/^[0-9+\s()-]{7,20}$/', $phone)) {
        header("Location: order.php?error=invalid_phone");
        exit;
    }

    // Postcode validation
    if (!preg_match('/^[A-Za-z0-9\s-]{4,10}$/', $postcode)) {
        header("Location: order.php?error=invalid_postcode");
        exit;
    }



    //Get last 4 digits of card number
    $hiddencardnumber = substr($cardnumber, -4);

    

    //Generate new order ID
    if(!isset($_SESSION['orderid'])){
        $_SESSION['orderid'] = 'JR-' . date('Ymd') . '-' . rand(1000,9999);
    }
    $orderid = $_SESSION['orderid'];
?>

<!DOCTYPE html>
<html class="bg-[#161616]">
    <head>
        <title>Order [<?php echo htmlspecialchars($orderid);?>]</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>

        <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

        <h1 class="text-3xl font-bold mb-6">Order Details: <?php echo htmlspecialchars($orderid);?></h1>

        <?php

            if(!empty($errors)){
                foreach ($errors as $error){
                    echo "<p class='text-red-600'> $error</p>";
                }
            }
            else{

            
            //Display the order details (Using htmlspecialchars to escape any malicious inputs)
            echo "
                <div class='px-2'>
                    <p><strong>" . htmlspecialchars($name) . ", welcome to the JR Timepiece's Owners Club.</strong></p>
                    <br>
                    <p><i><b>The details of your order are listed below:</b></i></p>
                    <p>Email:" . htmlspecialchars($email) . "</p>
                    <p>Phone:" . htmlspecialchars($phone) . "</p>

                    <br>
                    <p><i><b>Delivery Information:</b></i></p>
                    <p>" . htmlspecialchars($firstaddress) . "</p>
                    <p>" . htmlspecialchars($secondaddress) . "</p>
                    <p>" . htmlspecialchars($towncity) . "</p>
                    <p>" . htmlspecialchars($postcode) . "</p>

                    <br>
                    <p><i>Total Paid:</i></p>
                    <p>£" . $ordertotal . "</p>
                    <p>Paid With:</p>
                    <p>•••• •••• •••• ". $hiddencardnumber ."</p>
                </div>

                <a href='index.php' class='inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition'>Continue</a>
            ";
            
            //Clear cart and total variables:
            $_SESSION['cart'] = [];
            $_SESSION['ordertotal'] = 0;

            
            }
        ?>

    </body>

</html>