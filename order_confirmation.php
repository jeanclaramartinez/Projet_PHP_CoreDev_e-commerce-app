<?php

session_start();
require_once 'config.php';

// Récupérer l'ID de commande depuis GET
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

if ($order_id <= 0) {
    header('Location: index.php');
    exit;
}

$pdo = get_pdo();

// Vérifier que la commande existe
try {
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
    $stmt->execute([$order_id]);
    $order = $stmt->fetch();
} catch (PDOException $e) {
    error_log('Erreur récupération commande : ' . $e->getMessage());
    $order = null;
}

if (!$order) {
    header('Location: index.php');
    exit;
}

// Récupérer les articles de la commande avec JOIN
try {
    $stmt_items = $pdo->prepare(
        'SELECT oi.product_name, oi.quantity, oi.unit_price
         FROM order_items oi
         WHERE oi.order_id = ?'
    );
    $stmt_items->execute([$order_id]);
    $order_items = $stmt_items->fetchAll();
} catch (PDOException $e) {
    error_log('Erreur récupération articles commande : ' . $e->getMessage());
    $order_items = [];
}

include 'header.php';
?>


<div class="confirmation-box">
    <h1> Merci pour votre commande !</h1>
    <p class="order-number">Numéro de commande : <strong>#<?php echo (int)$order['id']; ?></strong></p>

    <table>
        <tr>
            <th>Nom</th>
            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
        </tr>
        <tr>
            <th>Adresse de livraison</th>
            <td><?php echo htmlspecialchars($order['delivery_address']); ?></td>
        </tr>
        <tr>
            <th>Total</th>
            <td><strong><?php echo number_format($order['total_price'], 2); ?> $</strong></td>
        </tr>
        <tr>
            <th>Date</th>
            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
        </tr>
    </table>

    <?php if (!empty($order_items)): ?>
        <h2 style="margin-top:25px; margin-bottom:10px; color:#2c3e50;">Articles commandés</h2>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo (int)$item['quantity']; ?></td>
                        <td><?php echo number_format($item['unit_price'], 2); ?> $</td>
                        <td><?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?> $</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div style="margin-top:25px;">
        <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</div>

</main>
<footer class="site-footer">
    <p>&copy; <?php echo date('Y'); ?> CoreDev</p>
</footer>
</body>
</html>