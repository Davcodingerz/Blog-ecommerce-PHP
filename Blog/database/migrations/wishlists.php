<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
<<<<<<< Updated upstream
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$createWishlistsTable = "CREATE TABLE wishlists (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
product_id INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";

$pdo->exec($createWishlistsTable);
echo 'Table created successfully';
=======

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$createWishlistTable = "CREATE TABLE wishlist (
id INT AUTO_INCREMENT PRIMARY KEY,
product_id INT NOT NULL,
user_id int NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
$pdo->exec($createWishlistTable);
echo 'Table created successfully';

>>>>>>> Stashed changes
