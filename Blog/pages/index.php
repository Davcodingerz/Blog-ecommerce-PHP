<?php
require_once('isLogged.php');

setcookie("user", "davide", time() - 86400, "/");
$isAccepted = false;
$isDenied = false;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogmerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
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
    <?php
    if (!isset($_COOKIE["cookie"])) {
    ?>
        <div id="cookiepolicy" class=" bg-orange-100 border-b border-yellow-300 px-6 py-4 fixed">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magni ratione placeat asperiores, enim iusto quisquam ad nostrum vel neque aut debitis praesentium aliquam id harum consequatur quod fugit dignissimos dicta.</p>
            <div class="flex space-x-4 mt-4">
                <div class="p-2 bg-slate-400 rounded-md"><a href="cookiepolicy.php?is_accepted=1">Accept</a></div>
                <div class="p-2 bg-slate-400 rounded-md"><a href="cookiepolicy.php?is_accepted=0">Refuse</a></div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="max-w-7xl mx-auto">
        <div id="navbar" class="w-full bg-gray-200 flex justify-between items-center px-4 py-6 rounded-b-lg text-lg shadow-lg">
            <Div>Logo/name</Div>
            <div class="flex space-x-4">
<<<<<<< Updated upstream
                <p class="font-semibold hover:scale-105 duration-200"><a href="./index.php">Home</a></p>
                <p class="font-semibold hover:scale-105 duration-200"><a href="./categories/index.php">Categories</a></p>
=======
                <p class="font-semibold hover:scale-105 duration-200"><a href="index.php">Home</a></p>
                <p class="font-semibold hover:scale-105 duration-200"><a href="products/index.php">Products</a></p>
                <p class="font-semibold hover:scale-105 duration-200"><a href="categories/index.php">Categories</a></p>
>>>>>>> Stashed changes
            </div>
            <button class="hover:scale-105 duration-200 hover:font-semibold"><a href="profiles/edit.php">Profile</a></button>
        </div>
        <div id="website" class="grid grid-cols-4 gap-4 mt-6">
            <div id="main-left" class="col-span-3 bg-gray-200 px-6 py-4 rounded-lg shadow-lg flex flex-col p-4 space-y-4">
                <p class="text-2xl font-semibold">Hello /user/, here are today's recommended products</p>
                <div id="item1" class="flex bg-gray-300 rounded-lg p-4 space-x-8 justify-between shadow-lg">
                    <div class="flex items-center">
                        <img src="../images/categories/nfs-Unbound.png" alt="Image" class="rounded-lg w-[700px] object-cover">
                    </div>
                    <div class="space-y-4">
                        <p class="text-3xl">Item Name 1</p>
                        <p class="text-xl">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <button>Check it out</button>
                </div>
                <div id="item2" class="flex bg-gray-300 rounded-lg p-4 space-x-8 justify-between shadow-lg">
                    <div class="flex items-center">
                        <img src="../images/categories/nfs-Unbound.png" alt="Image" class="rounded-lg w-[700px] object-cover">
                    </div>
                    <div class="space-y-4">
                        <p class="text-3xl">Item Name 2</p>
                        <p class="text-xl">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <button>Check it out</button>
                </div>
                <div id="item3" class="flex bg-gray-300 rounded-lg p-4 space-x-8 justify-between shadow-lg">
                    <div class="flex items-center">
                        <img src="../images/categories/nfs-Unbound.png" alt="Image" class="rounded-lg w-[700px] object-cover">
                    </div>
                    <div class="space-y-4">
                        <p class="text-3xl">Item Name 3</p>
                        <p class="text-xl">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                    <button>Check it out</button>
                </div>

            </div>
            <div id="main-right" class="col-span-1 space-y-4">
                <div class="space-y-2 bg-gray-200 px-6 py-4 rounded-lg shadow-lg flex flex-col justify-center">
                    <p class="font-semibold text-lg">Search Products:</p>
                    <form action="search.php" method="post" class="flex justify-between space-x-4">
                        <input type="text" name="search" id="searchbar" class="rounded-lg w-full p-2 shadow-lg">
                        <button class="px-4 py-2 bg-cyan-100 rounded-lg shadow-lg">Go!</button>
                    </form>
                </div>
                <div class="space-y-2 bg-gray-200 px-6 py-4 rounded-lg shadow-lg">
                    <p class="font-semibold text-lg">Trending Categories</p>
                    <div class="p-2 border-y border-gray-300">
                        <p>Category1</p>
                    </div>
                    <div class="p-2 border-y border-gray-300">
                        <p>Category2</p>
                    </div>
                    <div class="p-2 border-y border-gray-300">
                        <p>Category3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>