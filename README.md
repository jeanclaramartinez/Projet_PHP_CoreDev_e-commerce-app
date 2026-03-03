E-COMMERCE APP-WebDev PHP MySQL
Module 8

Type   : Projet Capstone Simplifie - Application E-Commerce Minimaliste
Format : Projet en equipe ( 3 etudiants en parallele + git merge final )
Groupe : CoreDev
Limite : 02 Mars 2026
_________________________________________________________________________________________________________________________________________________________

INSTALLATION ET DEMARRAGE 

1- XAMPP( Activer Apache + MySQL +Php )
2- Avoir un Navigateur Web

ETAPE 1- CLONER LE PROJET
  
  git clone < URl_Du_Repository -> https://github.com/jeanclaramartinez/Projet_PHP_CoreDev_e-commerce-app.git>
  cd Projet_PHP_CoreDev_e-commerce-app

  Placer le fichier le plus proche du disque 
  C:\xampp\htdocs\Projet_PHP_CoreDev_e-commerce-app>

  ETAPE 2- CREER LA BASE DE DONNEES

 1- Dans le navigateur taper http://localhost/phpMyAdmin
 2- Cliquer sur Importer
 3- selectionner le fichier ecommerce_db.sql
 4- Cliquer sur Executer
  
  Cela creera automatiquement:
  - La base de donnees ecommerce
  - Les tables Products , Orders, Order_items
  - Les 12 Produits pre-definis
     
  ETAPE 3- CONFIGURER LA CONNEXION 
  
  Ouvrir le fichier Config.php et Modifier si necessaire :

   $host ='localhost';
   $db = 'ecommerce_db';
   $user= 'root';
   $pass = '';

   SHEMA DE LA BASE DE DONNEES
-------------------------------------------------------------------------------
  TABLE Produits:


 - id      : Identifiant (INTEGER PRIMARY KEY AUTO_INCREMENT)
 - name    : Nom du produit(VARCHAR 255)
 - price   : Prix (DECIMAL 10.2)
 - description : Description courte (TEXT)
------------------------------------------------------------------------------

 TABLE Commandes:


 - id  : Identifiant (INTEGER PRIMARY KEY AUTO_INCREMENT)
 - customer_name: Nom du client(VARCHAR 255)
 - customer_email: Email du client(VARCHAR 255)
 - delivery_address: Adresse de livraison(TEXT)
 - total_price : Total de la commande (DECIMAL 10.2) 
 - order_date: Date/heure(TIMESTAMP)
------------------------------------------------------------------------------

 TABLE items (details des produits dans chaque commande):
--------------------------------------------------------


 - id  : Identifiant (INTEGER PRIMARY KEY AUTO_INCREMENT)
 -order_id : Lien vers la commande (INTEGER FOREIGN  KEY)
 - Product_id : Lien vers le produit (INTEGER FOREIGN KEY)
 - Product_name : Nom du produits au moment de la commande (VARCHAR 255)
 - quantity : quantite commandee (INTEGER) 
 - unit_price : Prix unitaire au moment de la commande (DECIMAL 10.2)

----------------------------------------------------------
INSERTION DES 12 PRODUITS PRES-ENREGISTRES DANS LA TABLE PRODUCTS

INSERT INTO products (id, name, price, description)
 VALUES
(1, 'Robe', 99.99, 'Robe de soirée ou événementielle'),
(2, 'Jean', 30.00, 'confortable et moderne'),
(3, 'Hood', 20.50, 'haut d\'hiver pour homme'),
(4, 'Escarpins', 60.00, 'Chaussures de bureau ou soirée'),
(5, 'Luxure watch', 75.00, 'elegant et pratique'),
(6, 'Veste', 120.00, 'Veste en cuir unisex'),
(7, 'Purse', 75.00, 'Sac a main esthetique'),
(8, 'Legging', 29.99, 'légère et confortable'),
(9, 'T-shirt ', 19.99, 'T-shirt casual pour un style streetwear'),
(10, 'Sneakers', 55.00, 'Chaussures confortables et stylées'),
(11, 'Ceinturon', 10.00, 'ceinturon en cuir'),
(12, 'Mini skirt', 38.00, 'Throwback 1990');

------------------------------------------------------------

ETAPE 4 - REPARTITION DU TRAVAIL 

ETUDIANT 1- PRODUITS ET INTERFACE
Branche Git: features/Products
Fichiers a creer: config.php, header.php, style.php, product_detail.php
- Connexion PDO à la base de données
- Affichage de la liste des produits
- Page de détail d'un produit
- Navigation et CSS communs

ÉTUDIANT 2 —  GESTION Du PANIER (SESSION)
Branche Git : feature/cart
Fichiers a creer : add_to_cart.php, cart.php
- Gestion du panier en $_SESSION
- Ajout, modification de quantité, suppression d'articles
- Calcul du total

Étudiant 3 — Commande & Base de Données
Branche Git : feature/checkout
Fichiers a creer : checkout.php, process_order.php, order_confirmation.php
- Formulaire de commande avec validation
- Enregistrement en BD (transaction)
- Page de confirmation avec numéro de commande

Chaque étudiant crée sa branche
git checkout -b feature/products   : Étudiant 1
git checkout -b feature/cart       : Étudiant 2
git checkout -b feature/checkout   : Étudiant 3

Travailler et commiter régulièrement:
git add .
git commit -m  'Affichage de la liste des produits'

Pousser sa branche:
git push origin feature/products

CREER UNE PULL REQUEST SUR GITHUB POUR LE MERGE FINAL

Toutes les exigences de sécurité obligatoires sont respectées :
    Prepared statements sur toutes les requêtes SQL (protection injection SQL)
    htmlspecialchars() sur toutes les sorties HTML (protection XSS)
    filter_var() pour la validation d'email
    Validation côté serveur de tous les champs requis
    Aucune erreur SQL affichée à l'utilisateur
    error_log() pour les erreurs techniques (log interne uniquement)
    Transaction BD dans process_order.php pour garantir l'intégrité des données
    Checklist Finale (Avant Soumission)

TEST LOCAL
    Étudiant 1 : tous les produits s'affichent correctement
    Étudiant 1 : liens product_detail.php?id=X fonctionnent

    Étudiant 2 : ajouter au panier crée une session et ajoute l'article
    Étudiant 2 : modifier quantité et supprimer articles fonctionne
    
    Étudiant 3 : validation email + champs requis rejette données invalides
    Étudiant 3 : commande s'enregistre en BD (tables orders + order_items)

 
    Flux complet : produit → panier → checkout → confirmation
    Les informations du panier sont correctes à chaque étape
    La confirmation affiche les articles commandés
    Sécurité
    Aucun message d'erreur SQL visible
    Données utilisateur échappées en HTML
    Prepared statements utilisés partout
    Validation email + champs requis

GIT & CODE

 Merge sans conflits
 Code commenté et lisible
 Noms de variables clairs
 Historique Git propre (commits significatifs)
 Accès GitHub pour l'Instructeur
Ajout du compte  lpognon.edu@gmail.com comme collaborateur du repositor


"" PROJET Realiser seule par Clara Martinez Jean en raison de manque de reponse et Avis des autres Membres du Groupe""

Auteur du Cours : 
Louis Kerson Pognon
Institution : UEH — Faculté des Sciences (FRST)
Annee Academique : 2025-2026

