<?php
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$productCRUD = new ProductCRUD();
$cartCRUD = new CartCRUD();
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if (isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
            $cartCRUD->addToCart($user_id, $_POST['product_id'], $quantity);
            header("Location: index.php");
            exit;
        } elseif (isset($_POST['action']) && $_POST['action'] === 'buy_now') {
            $cartCRUD->buyNow($user_id, $_POST['product_id'], $quantity);
            header("Location: confirmation.php");
            exit;
        }
    }
}

$products = $productCRUD->readProducts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Brad Midterm - Products</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #f7f1e1; 
            color: #3c3c3c; 
        }

        header {
            background-color: #8d6e63; 
        }

        .text-vintage {
            color: #6f4f37; 
        }

        .btn-vintage {
            background-color: #f0c14b; 
            color: #111;
            border-radius: 8px;
        }

        .btn-vintage:hover {
            background-color: #e1a900;
        }

        .btn-pink {
            background-color: #e9c5d2; 
            color: #6f4f37; 
            border-radius: 8px;
        }

        .btn-pink:hover {
            background-color: #f0a7c2; 
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #6f4f37; 
        }

        .product-price {
            font-size: 1.125rem;
            color: #d2a679;
            margin-bottom: 20px;
        }

        .product-actions form input {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            background-color: #f7f1e1;
            color: #6f4f37; 
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 10px;
            background-color: #7b5e3b; 
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #d2a679; 
        }

        footer {
            background-color: #8d6e63; 
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <header class="bg-yellow-900 text-white shadow-md">
        <nav class="flex justify-between items-center p-4">
            <div class="text-2xl font-semibold text-pink-200">Brad Shop</div>
            <ul class="flex space-x-6 text-lg">
                <li><a href="index.php" class="hover:text-yellow-400 transition-colors">Products</a></li>
                <li><a href="cart.php" class="hover:text-yellow-400 transition-colors">Cart</a></li>
            </ul>
            <div class="flex items-center space-x-4">
                <a href="logout.php" class="text-white hover:text-red-300 transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto py-8">
        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php foreach ($products as $product): ?>
                <div class="product-card bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="<?= htmlspecialchars($product->image_url); ?>"
                        alt="<?= htmlspecialchars($product->product_name); ?>" class="w-full h-64 object-cover">
                    <div class="product-info">
                        <h3 class="product-title"><?= htmlspecialchars($product->product_name); ?></h3>
                        <p class="product-price">$<?= number_format($product->price, 2); ?></p>
                        <div class="mt-4 flex justify-between items-center space-x-4">
                            <form action="index.php" method="POST" class="flex items-center">
                                <input type="hidden" name="product_id" value="<?= $product->product_id; ?>">
                                <input type="number" name="quantity" value="1" min="1" class="w-16 text-center border-2 border-gray-300 rounded p-1 text-gray-700">
                                <button type="submit" name="action" value="add_to_cart" class="btn-vintage">Add to Cart</button>
                            </form>
                            <form action="index.php" method="POST" class="flex items-center">
                                <input type="hidden" name="product_id" value="<?= $product->product_id; ?>">
                                <input type="number" name="quantity" value="1" min="1" class="w-16 text-center border-2 border-gray-300 rounded p-1 text-gray-700">
                                <button type="submit" name="action" value="buy_now" class="btn-pink">Buy Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <footer>
        <p class="text-sm">© 2024 Brad Shop | All rights reserved.</p>
    </footer>

</body>

</html>
