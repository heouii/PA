<!DOCTYPE html>
<html>
<head>
    <title>Panier</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }

        try {
            $pdo = new PDO('mysql:host=localhost;port=3306;dbname=projet_annuel', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (Exception $e) {
            die($e->getMessage());
        }

        if (isset($_POST['id']) && $_POST['id'] != '') {
            $stmt = $pdo->prepare('SELECT * FROM produits WHERE id = ?');
            $stmt->execute([$_POST['id']]);
            $produit = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($produit) {
                $produitId = $produit['id'];

                // If product is already in the cart, increment the quantity
                if (isset($_SESSION['panier'][$produitId])) {
                    $_SESSION['panier'][$produitId]['quantite']++;
                } else {
                    // Otherwise, add the product to the cart with a quantity of 1
                    $produit['quantite'] = 1;
                    $_SESSION['panier'][$produitId] = $produit;
                }
            }
        }

        // If delete request, remove the product from the cart
        if (isset($_POST['delete'])) {
            unset($_SESSION['panier'][$_POST['delete']]);
        }

        // If reset request, clear the entire cart
        if (isset($_POST['reset'])) {
            $_SESSION['panier'] = array();
        }
    }

    if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
        echo '<h1 class="text-center">Votre panier:</h1>';
        echo '<table class="table">';
        echo '<thead><tr><th>Nom du produit</th><th>Prix</th><th>Quantité</th><th>Total</th><th>Action</th></tr></thead>';
        echo '<tbody>';

        $total = 0;
        foreach ($_SESSION['panier'] as $produitId => $produit) {
            if (empty($produit['id']) || empty($produit['nom']) || empty($produit['prix'])) {
                unset($_SESSION['panier'][$produitId]);
                continue;
            }
            $nomProduit = htmlspecialchars($produit['nom'] ?? '');
            $prixProduit = htmlspecialchars($produit['prix'] ?? 0);
            $quantiteProduit = htmlspecialchars($produit['quantite'] ?? 0);
            $idProduit = htmlspecialchars($produit['id'] ?? '');

            $totalProduit = $prixProduit * $quantiteProduit;
            $total += $totalProduit;
            echo '<tr><td>' . $nomProduit . '</td><td>' . $prixProduit . '€</td><td>' . $quantiteProduit . '</td><td>' . $totalProduit . '€</td><td>
            <form action="panier.php" method="post">
                <input type="hidden" name="delete" value="' . $idProduit . '">
                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
            </form></td></tr>';
        }

        echo '<tr><td colspan="3" class="text-right"><strong>Total</strong></td><td>' . $total . '€</td></tr>';

        echo '</tbody>';
        echo '</table>';

        // Payment form
        echo '<h2 class="text-center">Paiement:</h2>';
        echo '<form action="charge.php" method="post">';
        echo '<input type="hidden" name="total" value="' . ($total * 100) . '">'; // corrected line

        // Add your payment fields here (e.g., credit card number, name on card, etc.)

        echo '<button type="submit" class="btn btn-primary">Payer</button>';
        echo '</form>';

    } else {
        echo '<h2 class="text-center">Votre panier est vide.</h2>';
    }
    ?>

    <!-- Reset Cart Button -->
    <form action="panier.php" method="post" style="text-align: center;">
        <input type="hidden" name="reset" value="1">
        <button type="submit" class="btn btn-warning btn-sm">Vider le panier</button>
    </form>

</div>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
