<?php
    $blankfields = [];
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $firstaddress = $_POST['firstaddress'] ?? '';
    $secondaddress = $_POST['secondaddress'] ?? '';
    $towncity = $_POST['towncity'] ?? '';
    $postcode = $_POST['postcode'] ?? '';

    if(empty($name)){
        $blankfields[] = "Name not entered.";
    }
    if(empty($email)){
        $blankfields[] = "Email not entered.";
    }
    if(empty($phone)){
        $blankfields[] = "Phone not entered.";
    }
    if(!empty($blankfields)){
        foreach ($blankfields as $blankfield){
            echo $blankfield;
        }
    }
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
            //Display the order details (Using htmlspecialchars to escape any malicious inputs)
            echo "
                <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
                <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                <p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>
            "
        ?>

    </body>

</html>