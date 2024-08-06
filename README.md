It is assumed that there is a mysql server running with a database named shopping_cart.

The database contains two tables:

catalog with columns: product, product_code, price,

specials with columns: offer, active.

The sql statements used to seed the database can be found in db_seed.txt.

It is also assumed that the username and password to connect to the database are both 'root'. These can be changed in dbh.php.

ShoppingCart class contains an internal array to keep track of the user's cart and a connection object to the database. 

ShoppingCart's add_to_cart method can accept one or more product codes to be added to the internal array. Verifies that the product code is valid.

The total method queries prices from the database, sums them, and then utilizes internal methods calc_special_offers and calc_delivery.

Calc_special_offers uses the second table of the database (specials) to determine which offers are currently available. This allows reusabilty of specials in the future without modifying the source code. When new specials are added, new cases can be added to the switch statement with logic to match the new special. 

Calc_delivery uses predefined delivery charges.

DatabaseHandler (dbh.php) maintains the connection to the database. Uses prepared statements to stop sql injection. 