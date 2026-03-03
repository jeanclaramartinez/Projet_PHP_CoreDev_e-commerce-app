<?php

session_start();
require_once 'config.php';

// Récupération et validation de l'ID produit
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Recupere les données du produis depuis la base de données
$product = get_product($id);

if (!$product) {
    header('Location: index.php');
    exit;
}

// Inclure la bar de navigation
include 'header.php';
?>

<a href="index.php" class="btn btn-secondary" style="margin-bottom:20px;display:inline-block;">&larr; Retour aux produits</a>

<div class="product-detail">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <div class="price"><?php echo number_format($product['price'], 2); ?> $</div>
    <div class="description"><?php echo htmlspecialchars($product['description']); ?></div>

    <hr style="margin: 20px 0; border: none; border-top: 1px solid #eee;">

    <h2 style="margin-bottom:15px; color:#2c3e50;">Ajouter au panier</h2>
    <form action="add_to_cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo (int)$product['id']; ?>">
        <div class="form-group">
            <label for="quantity">Quantité :</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="100" style="width:100px;">
        </div>
        <button type="submit" class="btn btn-success">Ajouter au panier</button>
    </form>
</div>

</main>
<footer class="site-footer">
    <p>&copy; <?php echo date('Y'); ?> CoreDev</p>
</footer>
</body>
</html>