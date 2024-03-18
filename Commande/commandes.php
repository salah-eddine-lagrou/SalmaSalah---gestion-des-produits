<?php
include '../components/navbar.php';
include '../services.php';
$commandes = commandes();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Gestion Magasin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
<div class="container mt-5">
        <div class="row">
            <h2 class="mr-auto">List des Commandes</h2>
            <a href="ajouterCommande.php" class="btn btn-primary ml-auto mb-2">Créer Commande</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de client</th>
                    <th>Date de commande</th>
                    <th>nbr Produit</th>
                    <th>Prix total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>                
                <?php
                    foreach($commandes as $commande) {
                        echo '<tr>';
                        echo '<td>'.$commande['id_commande'].'</td>';
                        echo '<td>'.$commande['nom_client'].'</td>';
                        echo '<td>'.$commande['date_commande'].'</td>';
                        echo '<td>'.$commande['num_produits'].'</td>';
                        echo '<td>'.$commande['prix_total'].'</td>';
                        echo '<td class="d-flex">
                            <form method="get" action="infosCommande.php">
                                <input type="hidden" class="form-control" id="id_produit_modifie" name="id_commande_infos" value="'.$commande['id_commande'].'">
                                <button class="btn btn-info">Detail</button>
                            </form>
                            <form method="get" action="modifierCommande.php">
                                <input type="hidden" class="form-control" id="id_produit_modifie" name="id_commande_modifie" value="'.$commande['id_commande'].'">
                                <button class="btn btn-success mr-2 ml-2">Modifier</button>
                            </form>
                            <form method="get" action="commandes.php" onsubmit="return confirm(\'Vous voulez supprimer cette commande ?\');">
                                <input type="hidden" class="form-control" id="id_produit_supprime" name="id_commande_supprime" value="'.$commande['id_commande'].'">
                                <button class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>';

                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>


    <?php
        // suppression de la commande
        if(isset($_GET['id_commande_supprime'])) {
            $resultat = supprimerCommande($_GET["id_commande_supprime"]);

            if ($resultat) {
                echo '<script>alert("Commande est supprimé avec succès !");</script>';
                echo '<script>window.location.href = "commandes.php";</script>';
                exit(); // Ensure script execution stops here
            } else {
                echo '<script>alert("ERREUR : Commande n\'est pas supprimé !");</script>';
            }
        }
    ?>
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