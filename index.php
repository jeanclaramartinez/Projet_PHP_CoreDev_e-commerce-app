<?php

session_start();
require_once 'config.php';

// Afficher liste produits
$products = get_all_products();

include 'header.php';
?>

<h1 class="section-subtitle">Nos Produits</h1> 

<p>Bienvenue sur notre site. Découvrez nos articles.</p>


<?php if (empty($products)): ?>
    <div class="empty-state">
        <p>Aucun produit disponible pour le moment.</p>
    </div>
<?php else: ?>
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <div class="price"><?php echo number_format($product['price'], 2); ?> $</div>
                <div class="description"><?php echo htmlspecialchars($product['description']); ?></div>
                <div class="actions">
                    <a href="product_detail.php?id=<?php echo (int)$product['id']; ?>" class="btn btn-primary">Voir détails</a>
                    <form action="add_to_cart.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo (int)$product['id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-success">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


</main>
<footer class="site-footer">
    <p>&copy; <?php echo date('Y'); ?> CoreDev</p>
</footer>
</body>
</html>