<?php
    session_start()
?>

<!DOCTYPE html>
<html>
<head>
    <title>Watch Shop</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">JR</h1>

        <ul class="flex space-x-6 text-lg">
            <li><a href="#" class="hover:text-blue-600">Home</a></li>
            <li><a href="#" class="hover:text-blue-600">Products</a></li>
            <li><a href="cart.php" class="hover:text-blue-600">Cart</a></li>
            <li><a href="#" class="hover:text-blue-600">Contact</a></li>
        </ul>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="relative w-full h-[900px] bg-gradient-to-b from-[#161616] to-[#242424]  flex items-center justify-center">
    
    <img src="media/HeroWatchImage.png" class="absolute w-[500px] h-[500px] translate-x-[-600px]" alt="Luxury Watch">
    <h1 class="absolute right-[40%] font-bold text-[128px] leading-none bg-gradient-to-r from-[#696969] to-[#FFFFFF] bg-clip-text text-transparent z-10">LUXURY<br>TIMEPIECES</h1>

    <div class="absolute translate-x-[400px]">
        <a href="#" class="bg-white/15 font-bold text-white text-[30px] px-8 py-3 rounded-[35px] hover:bg-gray-300/35 transition">Explore Collection→</a>
    </div>
</section>

<!-- PRODUCT LIST -->
<div id="products" class="max-w-7xl mx-auto py-16 px-4">

    <h2 class="text-3xl font-bold mb-10 text-center">Our Products</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

    
    <?php
        
        //server address, username, password, database name - open a connection to database
        $connection=mysqli_connect("localhost","root","root","watches");

        //Check if the connection is successful
        if($connection) {
            //echo "Connection Successful";
        }
        else {
            //Exits the script if unsuccessful
            die("Connection Failed");
        }
        
        //SQL Command to get all the products from database + execute the query
        $sql="SELECT * FROM Watches";
        $results=mysqli_query($connection,$sql);

        //Return the number of rows + Check if there are results. If so loop through those results and categorise each result as an associative array, then display results as HTML.
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
             echo '
                <div class="bg-white shadow rounded-xl p-5 text-center">

                <img 
                    src="media/' . $row['ImageUrl'] . '" 
                    alt="'.$row['Name'].'"
                    class="w-full h-40 object-cover rounded-lg mb-4"
                >

                <h5 class="text-xl font-semibold mb-1">'. $row['Name'] .'</h5>
                <p class="text-gray-500 mb-4">£'. $row['Price'] .'</p> ';

                //Check if item is in stock, if so display add to cart button else tell the user they are out of stock.
                if($row['Stock'] > 0){
                    echo '
                    
                    <a href="cart.php?id=' . $row['Id'] .'" 
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Add to Cart
                    </a>
                    ';
                } 
                else{

                    echo '
                        <p class="text-red-500 font-semibold">Out of stock</p>
                    ';
                
                }
                
                echo '</div>';
            }

        } else {
            echo "No records found.";
        }

        //Close the SQL connection
        mysqli_close($connection);
        
    ?>

    </div>
</div>

</body>
</html>