<?php
include '../components/navbar.php';
include '../services.php';

// Check if 'id_commande_infos' is set in the URL
if (isset($_GET['id_commande_infos'])) {
    $id_commande = $_GET['id_commande_infos'];
    $commande = obtenirCommande($id_commande);
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Commande Details</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <?php
        // Check if $commande is set
        if (isset($commande) && !empty($commande)) {
            echo '<h2>Commande Details</h2>';
            echo '<dl class="row">';
            echo '<dt class="col-sm-3">ID Commande:</dt><dd class="col-sm-9">' . $commande['id_commande'] . '</dd>';
            echo '<dt class="col-sm-3">Nom Client:</dt><dd class="col-sm-9">' . $commande['nom_client'] . '</dd>';
            echo '<dt class="col-sm-3">Adresse Client:</dt><dd class="col-sm-9">' . $commande['adresse'] . '</dd>';
            echo '<dt class="col-sm-3">Email Client:</dt><dd class="col-sm-9">' . $commande['email'] . '</dd>';
            echo '<dt class="col-sm-3">Date Commande:</dt><dd class="col-sm-9">' . $commande['date_commande'] . '</dd>';
            echo '</dl>';
            echo '<h3>Produits</h3>';
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Nom Produit</th>';
            echo '<th>Quantité</th>';
            echo '<th>Prix Unitaire</th>';
            echo '<th>Prix Total</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Check if 'produits' key exists and is an array
            $produitsCommande = obtenirProduitsCommande($commande['id_commande']);

            if (!empty($produitsCommande)) {
                $totalPrix = 0;
                foreach ($produitsCommande as $produit) {
                    echo '<tr>';
                    echo '<td>' . $produit['nom_produit'] . '</td>';
                    echo '<td>' . $produit['quantite_produit'] . '</td>';
                    echo '<td>' . $produit['prix_unitaire'] . '</td>';
                    echo '<td>' . ($produit['prix_unitaire'] * $produit['quantite_produit']) . '</td>';
                    echo '</tr>';
                    $totalPrix += ($produit['prix_unitaire'] * $produit['quantite_produit']);
                }                
            } else {
                echo '<div class="alert alert-warning" role="alert">No products found for this command.</div>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '<div class="alert alert-info" role="alert">Total Prix: ' . $totalPrix . '</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Commande not found.</div>';
        }
        ?>
    </div>   
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>