<?php

session_start();
require_once 'config.php';

// Traitement des actions avec POST 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action     = isset($_POST['action'])     ? $_POST['action']          : '';
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

    // Augmenter produits 
    if ($action === 'increase' && $product_id > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } 
        
        // Diminuer produits 
    } elseif ($action === 'decrease' && $product_id > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']--;

            // Supprimer si quantité tombe à 0 ou moins
            if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        } 
    } elseif ($action === 'remove' && $product_id > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
    }

    header('Location: cart.php');
    exit;
}

// Calculer total général
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['unit_price'] * $item['quantity'];
    }
}

include 'header.php';
?>

<h1 class="page-title"> 🛒 Mon Panier</h1>

<?php if (empty($_SESSION['cart'])): ?>
    <div class="empty-state">
        <p>Votre panier est vide.</p>
        <a href="index.php" class="btn btn-primary">Continuer les achats</a>
    </div>
<?php else: ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo number_format($item['unit_price'], 2); ?> $</td>
                    <td>
                        <div class="qty-controls">
                            <!-- Diminuer -->
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="action" value="decrease">
                                <input type="hidden" name="product_id" value="<?php echo (int)$item['product_id']; ?>">
                                <button type="submit" class="btn btn-secondary" style="padding:4px 10px;">-</button>
                            </form>
                            <span class="qty-value"><?php echo (int)$item['quantity']; ?></span>
                            <!-- Augmenter -->
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="action" value="increase">
                                <input type="hidden" name="product_id" value="<?php echo (int)$item['product_id']; ?>">
                                <button type="submit" class="btn btn-secondary" style="padding:4px 10px;">+</button>
                            </form>
                        </div>
                    </td>
                    <td><?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?> $</td>
                    <td>
                        <!-- Supprimer article -->
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="product_id" value="<?php echo (int)$item['product_id']; ?>">
                            <button type="submit" class="btn btn-danger" style="padding:6px 12px;">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="cart-total">
        Total général : <?php echo number_format($total, 2); ?> $
    </div>

    <div class="cart-actions">
        <div>
            <a href="index.php" class="btn btn-secondary">Continuer les achats</a>
            <!-- Vider le panier -->
            <form action="cart.php" method="POST" style="display:inline; margin-left:10px;">
                <input type="hidden" name="action" value="clear">
                <button type="submit" class="btn btn-warning" onclick="return confirm('Vider le panier ?');">Vider le panier</button>
            </form>
        </div>
        <a href="checkout.php" class="btn btn-success">Procéder au checkout &rarr;</a>
    </div>
<?php endif; ?>

</main>
<footer class="site-footer">
    <p>&copy; <?php echo date('Y'); ?> CoreDev</p>
</footer>
</body>
</html>