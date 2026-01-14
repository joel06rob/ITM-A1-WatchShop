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

<body class="bg-[#161616]">

<!-- NAVBAR -->
<nav class="absolute top-0 left-0 w-full bg-none z-10">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl text-white font-semibold">JR Timepieces</h1>

        <ul class="flex space-x-6 text-lg text-white">
            <li><a href="#products" class="hover:text-[#BFB578]">Products</a></li>
            <li><a href="cart.php" class="hover:text-[#BFB578]">Cart</a></li>
        </ul>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="relative w-full h-[900px] bg-gradient-to-b from-[#161616] to-[#242424]  flex items-center justify-center">
    
    <img src="media/HeroWatchImage.png" class="absolute w-[500px] h-[500px] translate-x-[-600px]" alt="Luxury Watch">
    <h1 class="absolute right-[40%] font-bold text-[128px] leading-none bg-gradient-to-r from-[#696969] to-[#FFFFFF] bg-clip-text text-transparent z-10">LUXURY<br>TIMEPIECES</h1>

    <div class="absolute translate-x-[400px]">
        <a href="#products" class="bg-white/15 font-bold text-white text-[30px] px-8 py-3 rounded-[35px] hover:bg-gray-300/35 transition">Explore Collection→</a>
    </div>
</section>

<!-- PRODUCT LIST -->
<div id="products" class="max-w-7xl mx-auto py-20 pb-28 px-4">

    <h2 class="text-3xl font-bold mb-5 text-center text-white">Our Collection</h2>
    <h3 class="text-2xl font-regular mb-20 text-center text-[#BFB578]">Explore our finest timepieces</h2>
    
    <h4 class="text-3xl font-semibold mb-5 text-white">Tailor Your Pick</h4>
    
<!--Form for dropdown to handle sorting-->
    <form method="GET" class="flex items-center mb-16 gap-4">
    <p class="text-2xl font-regular text-[#BFB578]">Sort by:</p>

    <select name="sort" onchange="this.form.submit()" class="p-1 rounded-lg">
        <option value="">Default</option>
        <option value="price_asc" <?= ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Lowest Price</option>
        <option value="price_desc" <?= ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Highest Price</option>
        <option value="popular" <?= ($_GET['sort'] ?? '') === 'popular' ? 'selected' : '' ?>>Most Popular</option>
    </select>
    </form>
    <!--
    <select name="sort" id="sort">
        <option value="least">Lowest Price</option>
        <option value="highest">Highest Price</option>
        <option value="popular">Most Popular</option>
    
        </select>
    </div> -->

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

    
    <?php
        
        //filezilla college server credentials: localhost, ddm371981, toasters!371981, watches
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
        
        //SQL Command to get all the products from database (sorted) + execute the query
        $sort = $_GET['sort'] ?? '';

        switch ($sort) {
            case 'price_asc':
                $orderBy = 'ORDER BY Price ASC';
                break;
            case 'price_desc':
                $orderBy = 'ORDER BY Price DESC';
                break;
            case 'popular':
                $orderBy = 'ORDER BY Stock ASC';
                break;
            default:
                $orderBy = '';
        }

        $sql = "SELECT * FROM Watches $orderBy";
        $results=mysqli_query($connection,$sql);

        //Return the number of rows + Check if there are results. If so loop through those results and categorise each result as an associative array, then display results as HTML.
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
             echo '
                <div class="relative group bg-white shadow rounded-xl p-5 text-center">
                <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 hidden group-hover:block w-max bg-black text-white text-xs rounded px-2 py-1">
                '. $row['Description'] .'
                </div>
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
                        class="inline-block bg-none text-[#BFB578] font-semibold px-4 py-2 rounded-lg hover:text-[#161616] transition">
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
<section class="bg-white">
<div class="max-w-4xl mx-auto py-16 px-10 grid grid-cols-2 gap-20">
<p class="py-10">JR Timepieces has been established since the 1800's. We have been carefully assembling timepieces in a professional, expert manner for as long as we can remember. Not one bezel or hand hasn't been carefully crafted by our expert watchmakers. Our watches are like no other, we only craft for the best.</p>
<img src="media/images.jpeg">
</div>
</section>

<footer class="flex text-white font-medium py-8 px-8 gap-6">
    <a href="#">Contact Us</a>
    <a href="#">Make a Purchase</a>
    <a href="cart.php">Your Cart</a>
</footer>

</body>
</html>