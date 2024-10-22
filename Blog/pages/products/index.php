<?php
require_once('../isLogged.php');
require_once("../../config/config.php");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
$limit = 15;
if (empty($page)) {
    $page = 1;
}
$offset = ($page - 1) * $limit;
$category_id = filter_input(INPUT_GET, "category_id", FILTER_VALIDATE_INT);

$parameters = ["limit" => $limit, "offset" => $offset];
$query = 'SELECT * FROM products WHERE category_id = :category_id limit :limit OFFSET :offset';
$statement = $pdo->prepare($query);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = 'SELECT count(*) as records FROM products WHERE category_id = :category_id';
$statement = $pdo->prepare($query);
$statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();
$totalItems = $statement->fetchAll(PDO::FETCH_ASSOC);

$avgprice = 'SELECT avg(price) as average, sum(price) as total FROM products WHERE category_id = :category_id';
$statement = $pdo->prepare($avgprice);
$statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();
$average_and_total = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        offWhite: '#FAF9F6',
                        offBlack: '#313639',
                        dudaCyan: '#c1d6d9'
                    },
                    fontFamily: {
                        'Roboto': ['Roboto'],
                    }
                },
            },
        }
    </script>
</head>

<body>
    <div class="bg-slate-200 h-screen space-y-6">
        <div class="max-w-7xl mx-auto flex flex-col justify-end">
            <div id="navbar" class="w-full bg-gray-200 flex justify-between items-center px-4 py-6 rounded-b-lg text-lg shadow-lg relative">
                <!-- Navbar Content -->
                <p class="w-[140px] flex items-center justify-center">Blogmerce.com</p>

                <div class="flex space-x-4">
                    <p class="font-semibold hover:scale-105 duration-200"><a href="../index.php">Home</a></p>
                    <p class="font-semibold hover:scale-105 duration-200"><a href="./categories/index.php">Categories</a></p>
                    <p class="font-semibold hover:scale-105 duration-200"><a href="../wishlists/index.php">Wishlist</a></p>
                </div>

                <div class="w-[140px] px-9 flex items-center justify-between relative">
                    <!-- Cart Icon & Button -->
                    <button id="dropdownButton" class="hover:scale-110 duration-200 hover:font-semibold">
                        <a href="../cart.php"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </a>
                    </button>
                    <p id="itemsInCart" class="font-semibold hover:scale-105 duration-200"></p>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu" class="origin-top-right absolute right-0 mt-[202px] w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                        <div class="py-1">
                            <a id="totalprice" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center mx-auto space-y-2">
            <div class="max-w-7xl flex flex-col items-center bg-white rounded-lg justify-center p-4">
                <p id="average_price" class="text-2xl font-semibold">Average price of items: $<?= number_format($average_and_total[0]['average'], 2) ?></p>
                <p id="average_price" class="text-2xl font-semibold">Total price of items: $<?= $average_and_total[0]['total'] ?></p>
            </div>
            <div class="max-w-7xl grid grid-cols-4 gap-4 bg-white rounded-lg items-center justify-center p-4">
                <?php
                foreach ($products as $product) {
                    $query = 'SELECT * FROM wishlist WHERE product_id = :product_id AND user_id = :user_id';
                    $parameters = ['product_id'=> $product['id'], 'user_id'=> $_SESSION['id']]; 
                    $statement = $pdo->prepare($query);
                    $result = $statement->execute($parameters);
                    $exists = $statement->fetch();
                    $color = 'none';
                    if ($exists != false){
                        $color = '#FF000077';
                    }
                ?>
                    <div class="bg-slate-300 px-4 py-6 rounded-lg text-center space-y-4">
                        <img id="image" src="../../images/products/<?= $product['image'] ?>" alt="CategoryImage" class="rounded-lg object-cover">
                        <p id="name" class="text-2xl font-bold"><?= $product['name'] ?></p>
                        <p id="description" class="text-xl font-semibold"><?= $product['description'] ?></p>
                        <p id="description" class="text-xl font-semibold">$<?= $product['price'] ?></p>
                        <p id="description" class="text-lg font-semibold">In Stock: <strong><?= $product['stock'] ?></strong></p>
                        <form action="destroy.php" method="post">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <?php
                            if ($_SESSION['role'] == 'administrator') {
                            ?>
                                <button type="submit" class="bg-red-600 text-white p-2 rounded-lg text-xl">Delete</button>
                                <button class="bg-blue-400 text-black p-2 rounded-lg text-xl"><a href="edit.php?id=<?= $product['id'] ?>">Edit</a></button>
                            <?php
                            }
                            ?>
                        </form>
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <button onclick="buy(<?= $product['id'] ?>)" class="bg-green-400 text-black p-2 rounded-lg text-xl">Add to cart</button>
                            <button class="text-black p-1 rounded-lg" onclick="addToWishlist(<?= $product['id']?>)">
                                    <svg id="isWishlisted_<?= $product['id'] ?>" xmlns="http://www.w3.org/2000/svg" fill="<?= $color ?>" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 hover:scale-110 duration-150">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                            </button>
                        </div>

                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        function buy(id) {
            $.ajax({
                url: '../../ajax/add_to_cart.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    product: id,
                },
                success: function(response) {
                    $("#itemsInCart").html(response.count)
                    $("#totalprice").html("Item total: $" + response.price)
                }
            })
        }
        function addToWishlist(id) {
            $.ajax({
                url: '../../ajax/add_to_wishlist.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    product: id,
                },
                success: function(response) {
                    if (response.status == true) {
                        $('#isWishlisted_' + response.itemID).attr('fill', '#FF000077')
                    } else {
                        $('#isWishlisted_' + response.itemID).attr('fill', 'none')
                    }
            }
        })
        }
        $(document).ready(function() {
            $.ajax({
                url: '../../ajax/items_in_cart.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    $("#itemsInCart").html(response.count)
                    $("#totalprice").html("Item total: $" + response.price)
                }
            })

            $('#dropdownButton').mouseenter(function() {
                $('#dropdownMenu').removeClass('hidden')
            })

            $('#dropdownButton').mouseleave(function() {
                $('#dropdownMenu').addClass('hidden')
            })
        })
    </script>
</body>

</html>