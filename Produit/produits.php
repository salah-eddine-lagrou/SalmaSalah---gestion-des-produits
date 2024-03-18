<?php
include '../components/navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
    <title>Gestion Magasin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <div class="container mt-5">
        <div class="row">
            <h2 class="mr-auto">Product List</h2>
            <a href="ajouterProduit.php" class="btn btn-primary ml-auto mb-2">Ajouter Product</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include '../services.php';

                    $produits = produits();
                    foreach($produits as $produit) {
                        echo '<tr>';
                        echo '<td>'.$produit['id_produit'].'</td>';
                        echo '<td>'.$produit['nom_produit'].'</td>';
                        echo '<td>'.$produit['prix_unitaire'].'</td>';
                        echo '<td>'.$produit['quantite_stock'].'</td>';
                        echo '<td>'.$produit['description'].'</td>';
                        echo '<td class="d-flex">
                            <form method="get" action="modifierProduit.php">
                                <input type="hidden" class="form-control" id="id_produit_modifie" name="id_produit_modifie" value="'.$produit['id_produit'].'">
                                <button class="btn btn-success">Modifier</button>
                            </form>
                            <form method="get" action="produits.php" onsubmit="return confirm(\'Vous voulez supprimer ce produit ?\');">
                                <input type="hidden" class="form-control" id="id_produit_supprime" name="id_produit_supprime" value="'.$produit['id_produit'].'">
                                <button class="btn btn-danger ml-2">Supprimer</button>
                            </form>
                        </td>';

                        echo '</tr>';
                    }
                    
                ?>
                
            </tbody>
        </table>
    </div>
    <?php
        // Suppression d'un produit
        if (isset($_GET["id_produit_supprime"])) {
            $resultat = supprimerProduit($_GET["id_produit_supprime"]);

            if ($resultat) {
                echo '<script>alert("Produit est supprimé avec succès !");</script>';
                echo '<script>window.location.href = "produits.php";</script>';
                exit(); // Ensure script execution stops here
            } else {
                echo '<script>alert("ERREUR : Produit n\'est pas supprimé !");</script>';
            }
        }
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>