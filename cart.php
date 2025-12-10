<?php
session_start();

// If cart doesnt exist, create it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If a product ID is passed (like cart.php?id=3)
if (isset($_GET['id'])) {

    //Convert the passed ID into variable and append it to cart.
    $productId = intval($_GET['id']);
    $_SESSION['cart'][] = $productId;
}

//server address, username, password, database name
$connection=mysqli_connect("localhost","root","root","watches");

if($connection) {
//echo "Connection Successful";
}
else {
//Exits the script
die("Connection Failed");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>

    

    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
    } else {
        
        echo "<div class='space-y-4'>";

        foreach ($_SESSION['cart'] as $itemId) {
            
            //Get product details from database
            $sql = "SELECT * FROM Watches WHERE Id = $itemId";
            $result = mysqli_query($connection, $sql);

            if($result && mysqli_num_rows($result) > 0){

                $product = mysqli_fetch_assoc($result);

                //Display the product in cart
                echo "
                    <div class='flex items-center gap-4 p-4 border rounded-lg'>
                    <img src='media/{$product['ImageUrl']}' class='w-24 h-24 object-cover rounded'>
                    <div>
                        <p class='text-xl font-semibold'>{$product['Name']}</p>
                        <p class='text-gray-600'>£{$product['Price']}</p>
                    </div>
                    
                </div>
                ";
            }
        }

        echo "</div>";

        echo "
            <div class='flex justify-between items-center pt-4'>
                <a href='index.php' class='text-blue-600 inline-block'>← Continue Shopping</a>
                <a href='order.php' class='inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition'>Purchase</a> 
            </div>";
            
        mysqli_close($connection);
    }
    ?>

    

</div>

</body>
</html>