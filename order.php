<?php
    session_start()
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

        <!--  Order details form, using POST for security  -->
        <form action="invoice.php" method="POST">
            Name: <input type="text" name="name"><br>
            E-mail: <input type="text" name="email"><br>
            Phone Number: <input type="tel" name="phone"><br>
            1st Line Address: <input type="text" name="firstaddress"><br>
            2nd Line Address: <input type="text" name="secondaddress"><br>
            Town/City: <input type="text" name="towncity"><br>
            Postcode: <input type="text" name="postcode"><br>
            <input type="submit" value="Confirm & Pay">
        </form>
    </body>


</html>