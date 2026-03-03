<?php

session_start();
require_once 'config.php';

// Rediriger si panier vide
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Calcul total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['unit_price'] * $item['quantity'];
}

include 'header.php';
?>

<div class="checkout-section">
    <h1>Finaliser la commande</h1>

    <h2>Récapitulatif du panier</h2>
    <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
        <thead>
            <tr style="background:#f0f0f0;">
                <th style="padding:10px; text-align:left; border-bottom:1px solid #ddd;">Produit</th>
                <th style="padding:10px; text-align:left; border-bottom:1px solid #ddd;">Qté</th>
                <th style="padding:10px; text-align:left; border-bottom:1px solid #ddd;">Prix unitaire</th>
                <th style="padding:10px; text-align:left; border-bottom:1px solid #ddd;">Sous-total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td style="padding:10px; border-bottom:1px solid #eee;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td style="padding:10px; border-bottom:1px solid #eee;"><?php echo (int)$item['quantity']; ?></td>
                    <td style="padding:10px; border-bottom:1px solid #eee;"><?php echo number_format($item['unit_price'], 2); ?> $</td>
                    <td style="padding:10px; border-bottom:1px solid #eee;"><?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?> $</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="text-align:right; font-size:1.2rem; font-weight:bold; margin-bottom:25px; color:#2c3e50;">
        Total : <?php echo number_format($total, 2); ?> $
    </div>

    <h2>Vos informations</h2>
    <form action="process_order.php" method="POST">
        <div class="form-group">
            <label for="customer_name">Nom complet :</label>
            <input type="text" id="customer_name" name="customer_name" required placeholder="Jean Dupont">
        </div>
        <div class="form-group">
            <label for="customer_email">Email :</label>
            <input type="email" id="customer_email" name="customer_email" required placeholder="jean@example.com">
        </div>
        <div class="form-group">
            <label for="delivery_address">Adresse de livraison :</label>
            <textarea id="delivery_address" name="delivery_address" required rows="3" placeholder="123 rue Principale, Ville, Pays"></textarea>
        </div>
        <div style="display:flex; gap:12px; margin-top:10px;">
            <button type="submit" name="action" value="validate" class="btn btn-success">Valider la commande</button>
            <a href="cart.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

</main>
<footer class="site-footer">
    <p>&copy; <?php echo date('Y'); ?>CoreDev</p>
</footer>
</body>
</html>