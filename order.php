<?php
    session_start();

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
        <title>Your Order</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100">

        <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">

        <h1 class="text-3xl font-bold mb-6">Your Order</h1>

        <?php 
        
        echo "<div class='space-y-2'>";

        foreach ($_SESSION['cart'] as $itemId) {
            
            //Get product details from database
            $sql = "SELECT * FROM Watches WHERE Id = $itemId";
            $result = mysqli_query($connection, $sql);

            if($result && mysqli_num_rows($result) > 0){

                $product = mysqli_fetch_assoc($result);

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

        ?>

        <!--  Order details form, using POST for security  -->
        <form class="my-8" action="invoice.php" method="POST">
            Name: <input type="text" name="name" class="border-[1px] border-gray-600 rounded-lg" required><br>
            E-mail: <input type="text" name="email" class="border-[1px] border-gray-600 rounded-lg" required><br>
            Phone Number: <input type="tel" name="phone" class="border-[1px] border-gray-600 rounded-lg" required><br>
            1st Line Address: <input type="text" name="firstaddress" class="border-[1px] border-gray-600 rounded-lg" required><br>
            2nd Line Address: <input type="text" name="secondaddress" class="border-[1px] border-gray-600 rounded-lg" required><br>
            Town/City: <input type="text" name="towncity" class="border-[1px] border-gray-600 rounded-lg" required><br>
            Postcode: <input type="text" name="postcode" class="border-[1px] border-gray-600 rounded-lg" required><br>
            <input type="submit" value="Confirm & Pay" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:cursor-pointer hover:bg-blue-700 transition" required>
        </form>
    </body>


</html>