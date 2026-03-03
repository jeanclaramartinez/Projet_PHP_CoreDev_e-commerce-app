<?php
// Connexion avec la base donnee 

$host ='localhost';
$db = 'ecommerce_db';
$user= 'root';
$pass = '';
$charset = 'utf8mb4';

/* initialer la fonction (PDO) */
function get_pdo() {
 static $pdo = null;

// Récupérer les variables de configuration globales
global $host, $db, $user, $pass, $charset;

 if($pdo === null) {
 $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
   
 $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {

    // Affichager message d'erreur pour l'utilisateur 
            error_log('Erreur connexion BD : ' . $e->getMessage());
            die('Erreur de connexion à la base de données. Veuillez réessayer plus tard.');
        }
    }
    return $pdo;
}

// Fonctionpour récupérer tout les produits
function get_all_products() {
    $pdo = get_pdo();
    $stmt = $pdo->prepare('SELECT id, name, price, description FROM products ORDER BY id ASC');
    $stmt->execute();
    return $stmt->fetchAll();
}
// Recuperer un produit par son id
function get_product($id) {
    $pdo = get_pdo();
    $stmt = $pdo->prepare('SELECT id, name, price, description FROM products WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}