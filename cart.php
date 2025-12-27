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

//Remove item from cart
if (isset($_GET['remove'])) {
    $removeIndex = intval($_GET['remove']);

    if (isset($_SESSION['cart'][$removeIndex])) {
        unset($_SESSION['cart'][$removeIndex]);
        
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
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
<html class="bg-[#161616]">
<head>
    <title>Your Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>

    

    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
    } else {
        
        $ordertotal = 0;
        echo "<div class='space-y-4'>";

        foreach ($_SESSION['cart'] as $index => $itemId) {
            
            //Get product details from database
            $sql = "SELECT * FROM Watches WHERE Id = $itemId";
            $result = mysqli_query($connection, $sql);

            if($result && mysqli_num_rows($result) > 0){

                $product = mysqli_fetch_assoc($result);
                $ordertotal += $product['Price'];

                //Display the product in cart
                echo "
                    <div class='flex items-center justify-between gap-4 p-4 border rounded-lg'>
                    <div class='flex items-center gap-4'>
                        <img src='media/{$product['ImageUrl']}' class='w-24 h-24 object-cover rounded'>
                        <div>
                            <p class='text-xl font-semibold'>{$product['Name']}</p>
                            <p class='text-gray-600'>£{$product['Price']}</p>
                        </div>
                    </div>
                    
                    <a href='cart.php?remove={$index}' class='text-red-500'>Remove</a>
                </div>
                ";
            }
        }

        echo "</div>";
        echo "<div class='flex items-center p-2 gap-1 justify-end'> 
        
            <h3>Order Total: </h3><p>£{$ordertotal}</p>
            </div>";

        echo "
            <div class='flex justify-end items-center pt-2'>
                <a href='order.php' class='inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition'>Purchase</a> 
            </div>";
            
        mysqli_close($connection);
    }
    ?>

    <a href='index.php' class='text-[#BFB578] font-semibold inline-block pt-4 hover:text-[#161616]'>← Continue Shopping</a>
    

</div>

</body>
</html>