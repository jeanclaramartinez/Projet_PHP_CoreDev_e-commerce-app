<?php 

session_start();
require_once 'config.php';

// Vérifier avec méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Vérifier panier non vide
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Récupérer données avec POST
$customer_name     = isset($_POST['customer_name'])     ? trim($_POST['customer_name'])     : '';
$customer_email    = isset($_POST['customer_email'])    ? trim($_POST['customer_email'])    : '';
$delivery_address  = isset($_POST['delivery_address'])  ? trim($_POST['delivery_address'])  : '';

// Validation côté serveur
$errors = [];

if (empty($customer_name)) {
    $errors[] = 'Le nom est requis.';
}

if (empty($customer_email)) {
    $errors[] = "L'email est requis.";
} elseif (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'email n'est pas valide.";
}

if (empty($delivery_address)) {
    $errors[] = "L'adresse de livraison est requise.";
}

if (!empty($errors)) {
    // Stocker erreurs en session et retourner au checkout
    $_SESSION['checkout_errors'] = $errors;
    header('Location: checkout.php');
    exit;
}

// Calcul total
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['unit_price'] * $item['quantity'];
}

// TRANSACTION BD
$pdo = get_pdo();

try {
    $pdo->beginTransaction();

    // Insertion dans orders
    $stmt = $pdo->prepare(
        'INSERT INTO orders (customer_name, customer_email, delivery_address, total_price, order_date)
         VALUES (?, ?, ?, ?, NOW())'
    );
    $stmt->execute([$customer_name, $customer_email, $delivery_address, $total_price]);

    // Récupérer l'ID de la commande insérée
    $order_id = $pdo->lastInsertId();

    // Insertion dans order_items pour chaque article du panier
    $stmt_item = $pdo->prepare(
        'INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price)
         VALUES (?, ?, ?, ?, ?)'
    );

    foreach ($_SESSION['cart'] as $item) {
        $stmt_item->execute([
            $order_id,
            (int)$item['product_id'],
            $item['product_name'],
            (int)$item['quantity'],
            $item['unit_price'],
        ]);
    }


    // Cette ligne confirme a la db qu'il peut enregistrer les commandes inserer et les articles quand tout est ok.
    $pdo->commit();

    // Vider le panier après commande réussie
    $_SESSION['cart'] = [];

    // Rediriger vers la confirmation
    header('Location: order_confirmation.php?order_id=' . (int)$order_id);
    exit;

    //Protection contre tout erreur
} catch (PDOException $e) {
    $pdo->rollBack();

    // Log l'erreur technique, ne pas l'afficher à l'utilisateur
    error_log('Erreur lors de la commande : ' . $e->getMessage());
    $_SESSION['checkout_errors'] = ['Une erreur est survenue. Veuillez réessayer.'];
    header('Location: checkout.php');
    exit;
}
?>