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
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Order [ORDERID HERE]</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100">

        <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

        <h1 class="text-3xl font-bold mb-6">Order Details [ORDERID HERE]</h1>

        <?php

            if(!empty($blankfields)){
                foreach ($blankfields as $blankfield){
                    echo $blankfield;
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