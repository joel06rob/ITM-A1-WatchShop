<?php
    session_start();

    //Redirect back to cart if empty
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        header("Location: cart.php");
        exit;
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
        <title>Your Order</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>

        <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

        <h1 class="text-3xl font-bold mb-6">Your Order</h1>

        <?php 
        //Total price of order
            $ordertotal = 0;
        echo "<div class='space-y-2'>";

        foreach ($_SESSION['cart'] as $itemId) {
            
            

            //Get product details from database
            $sql = "SELECT * FROM Watches WHERE Id = $itemId";
            $result = mysqli_query($connection, $sql);

            if($result && mysqli_num_rows($result) > 0){

                $product = mysqli_fetch_assoc($result);
                $ordertotal += $product['Price'];

                $_SESSION['ordertotal'] = $ordertotal;

                //Display the product in cart
                echo "
                    <div class='flex items-center gap-4 p-2 border rounded-lg'>
                    <img src='media/{$product['ImageUrl']}' class='w-10 h-10 object-cover rounded'>
                    <div>
                        <p class='text-sm font-semibold'>{$product['Name']}</p>
                        <p class='text-gray-600 text-xs'>£{$product['Price']}</p>
                    </div>
                    
                </div>
                ";
            }
        }
        echo "</div>";

        echo "<div class='flex items-center p-2 gap-1'> 
        
            <h3 class='text-gray-600'>Order Total: </h3><p class='text-gray-600'>£{$ordertotal}</p>
            </div>
        ";

        ?>

        <!--  Order details form, using POST for security  -->
        <form class="my-8 grid grid-cols-2 grid-rows-7 gap-4" action="invoice.php" method="POST">
            <span><strong>Details</strong></span><span></span>
            Name: <input type="text" name="name" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            E-mail: <input type="text" name="email" class="border-b-[1px] border-gray-600 focus:outline-none" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required>
            Phone Number: <input type="tel" name="phone" class="border-b-[1px] border-gray-600 focus:outline-none" pattern="^[0-9+\s()-]{7,20}$" required>
            <span><strong>Address</strong></span><span></span>
            1st Line Address: <input type="text" name="firstaddress" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            2nd Line Address: <input type="text" name="secondaddress" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            Town/City: <input type="text" name="towncity" class="border-b-[1px] border-gray-600 focus:outline-none" required>
            Postcode: <input type="text" name="postcode" class="border-b-[1px] border-gray-600 focus:outline-none" pattern="^[A-Za-z0-9\s-]{4,10}$" required>
            <div class="col-span-2 flex justify-end mt-4"><input type="submit" value="Confirm & Pay" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:cursor-pointer hover:bg-blue-700 transition" required></div>
        </form>
        <a href='cart.php' class='text-blue-600 inline-block'>← Back to Cart</a>
        
    </body>


</html>