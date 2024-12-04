<?php
require_once('../isLogged.php');
require_once("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = 'SELECT 
products.id as id, 
products.name as name, 
products.description as description, 
products.price as price,
products.image as image
FROM wishlists INNER JOIN products ON wishlists.product_id = products.id WHERE wishlists.user_id = :user_id';
$statement = $pdo->prepare($query);
$statement->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$statement->execute();
$productInWishlist = $statement->fetchAll(PDO::FETCH_ASSOC);

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

<body class="bg-offBlack font-Roboto">
    <div class="max-w-7xl mx-auto">
        <div id="navbar" class="w-full bg-gray-200 flex justify-between items-center px-4 py-6 rounded-b-lg text-lg shadow-lg">
            <Div>Blogmerce.com</Div>
            <div class="flex space-x-4">
                <p class="font-semibold hover:scale-105 duration-200"><a href="../index.php">Home</a></p>
                <p class="font-semibold hover:scale-105 duration-200"><a href="../categories/index.php">Categories</a></p>
            </div>
            <button class="hover:scale-105 duration-200 hover:font-semibold"><a href="../profiles/edit.php">Profile</a></button>
        </div>
        <div id="website" class="grid grid-cols-4 gap-4 mt-6">
            <div id="main-left" class="col-span-3 bg-gray-200 px-6 py-4 rounded-lg shadow-lg flex flex-col p-4 space-y-4">
                <?php
                if (count($productInWishlist) == 0) {
                ?>
                    <p class="text-2xl font-semibold">Hello /user/, there are no items in your wishlist.</p>
                    <p>You can wishlist items by clicking the hearth icon below the add to cart button</p>
                <?php
                } else {
                ?>
                    <p class="text-2xl font-semibold">Hello /user/, here's your wishlist, fancy buying something?:</p>
                <?php
                }
                foreach ($productInWishlist as $wishlisted_item) {
                ?>
                    <div id="item_in_cart_<?= $wishlisted_item['id'] ?>" class="flex bg-gray-300 rounded-lg px-6 py-4 space-x-8 justify-between shadow-lg">
                        <div class="flex space-x-8">
                            <div class="flex items-center h-[250px] w-[250px] object-cover">
                                <img src="../../images/categories/<?= $wishlisted_item['image'] ?>" alt="Image" class="rounded-lg w-[700px] object-cover">
                            </div>
                            <div class="space-y-4 mt-4">
                                <p class="text-3xl"><?= $wishlisted_item['name'] ?></p>
                                <p class="text-xl"><?= $wishlisted_item['description'] ?></p>
                                <p class="text-xl">$<?= $wishlisted_item['price'] ?></p>
                            </div>
                        </div>
                        <div id="buttons" class="flex flex-col justify-center items-center space-y-4">
                            <div class="flex items-center justify-center w-fit h-fit">
                                <button class="px-4 py-2 bg-red-400 text-black rounded-lg shadow-lg hover:scale-105 hover:shadow-xl duration-300 my-auto h-fit w-fit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                            <p id="quantity_<?= $product['id'] ?>">Quantity: <?= $wishlisted_item['quantity'] ?></p>
                            <div class="flex items-center justify-center w-fit h-fit space-x-4">
                                <button id="removePiece" onclick="removePiece(<?= $product['id'] ?>)" class="px-4 py-2 bg-red-400 text-black rounded-lg shadow-lg hover:scale-105 hover:shadow-xl duration-300 my-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                                <button id="addPiece" onclick="addPiece(<?= $product['id'] ?>)" class="px-4 py-2 bg-blue-400 text-black rounded-lg shadow-lg hover:scale-105 hover:shadow-xl duration-300 my-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div id="main-right" class="col-span-1 space-y-4">
                <div class="space-y-2 bg-gray-200 px-6 py-4 rounded-lg shadow-lg flex flex-col justify-center">
                    <div>
                        <p class="font-semibold text-lg">Happy with your selection?</p>
                        <p class="text-md">Proceed with your purchase below.</p>
                    </div>
                    <form action="#" method="post" class="flex justify-between space-x-4">
                        <button class="px-4 py-2 bg-cyan-100 rounded-lg shadow-lg hover:scale-105 hover:shadow-xl duration-300">Buy now!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addPiece(id) {
            $.ajax({
                url: '../ajax/add_to_cart.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    product: id,
                },
                success: function(response) {
                    $("#quantity_" + id).html('Quantity: ' + response.itemQuantity)

                }
            })
        }

        function removePiece(id) {
            $.ajax({
                url: '../ajax/remove_from_cart.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    product: id,
                },
                success: function(response) {
                    $("#quantity_" + id).html('Quantity: ' + response.itemQuantity)
                    if (response.itemQuantity == 0) {
                        $("#item_in_cart_" + id).remove()
                    }
                }
            })
        }
    </script>
</body>

</html>