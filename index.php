<!DOCTYPE html>
<html>
    <head>
        <title>Shopping Cart Assessment</title>
    </head>
    <body>
        <?php
        
           require_once "dbh.php";
           require_once "shoppingcart.php";

           $db = new DatabaseHandler();
           $cart = new ShoppingCart($db);
           $cart->add_to_cart("BF1", "RF1", "RF1", "RF1");
           echo "Total: " . $cart->total() . "\n";
        ?>
    </body>
</html>