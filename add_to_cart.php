
<?php

session_start();
require_once 'config.php';

// Traitement ajout au panier (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity   = isset($_POST['quantity'])   ? (int)$_POST['quantity']   : 0;

// Validation
if ($product_id <= 0 || $quantity <= 0) {
    header('Location: index.php');
    exit;
}

// Récupérer nom et prix depuis la base de donnée
$product = get_product($product_id);

  // Produit inexistant
if (!$product) {
    header('Location: index.php');
    exit;
}

// Initialiser le panier en session si besoin
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ajouter quantité
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = [
        'product_id'   => $product['id'],
        'product_name' => $product['name'],
        'unit_price'   => $product['price'],
        'quantity'     => $quantity,
    ];
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>