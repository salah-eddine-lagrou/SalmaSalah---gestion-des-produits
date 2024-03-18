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
            <h2 class="mr-auto">Client List</h2>
            <a href="ajouterClient.php" class="btn btn-primary ml-auto mb-2">Ajouter Client</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>E-mail</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include '../services.php';

                    $clients = clients();
                    foreach($clients as $client) {
                        echo '<tr>';
                        echo '<td>'.$client['id_client'].'</td>';
                        echo '<td>'.$client['nom'].'</td>';
                        echo '<td>'.$client['email'].'</td>';
                        echo '<td>'.$client['adresse'].'</td>';
                        echo '<td class="d-flex">
                            <form method="get" action="modifierClient.php">
                                <input type="hidden" class="form-control" id="id_client_modifie" name="id_client_modifie" value="'.$client['id_client'].'">
                                <button class="btn btn-success">Modifier</button>
                            </form>
                            <form method="get" action="clients.php" onsubmit="return confirm(\'Vous voulez supprimer ce client ?\');">
                                <input type="hidden" class="form-control" id="id_client_supprime" name="id_client_supprime" value="'.$client['id_client'].'">
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
        // Suppression d'un client
        if (isset($_GET["id_client_supprime"])) {
            $resultat = supprimerClient($_GET["id_client_supprime"]);

            if ($resultat) {
                echo '<script>alert("client est supprimé avec succès !");</script>';
                echo '<script>window.location.href = "clients.php";</script>';
                exit(); // Ensure script execution stops here
            } else {
                echo '<script>alert("ERREUR : Client n\'est pas supprimé !");</script>';
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