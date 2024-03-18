<?php
ob_start();
include '../components/navbar.php';
include '../services.php';

$clients = clients();
$produits = produits();

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
        <h2>Créer Commande</h2>
        <form action="ajouterCommande.php" method="post">
            <div class="mb-3">
                <label for="nom_produit" class="form-label"><strong>Client</strong></label>
                <div class="form-group border pb-2 pr-2 pt-2 pl-2">
                    <div class="input-group">
                        <span class="form-arrow"><i class="bx bx-chevron-down"></i></span>
                        <select name="client" id="client" class="form-control">
                            <option disabled selected>Select Client</option>
                            <?php
                                foreach ($clients as $client) {
                                    echo '<option value="' . $client['id_client'] . '">' . $client['nom'] . '</option>';
                                }
                            ?>
                        </select>
                        <?php if (isset($errClient) && !(empty($errClient))) echo "<div class='alert alert-danger' role='alert'>$errClient</div>" ?>
                        <div class="input-group-append">
                            <span class="input-group-text form-arrow">
                                <i class="bx bx-chevron-down"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Produits</strong></label>
                <div class="form-group border pb-2 pr-2 pt-2 pl-2">
                    <div class="form-group" id="product1">
                        <label for="product1">Select Produits :</label>
                        <div class="row">
                            <div class="col">
                                <select class="form-control product-select" name="products[]">
                                    <option value="">Select a product</option>
                                    <?php
                                        foreach ($produits as $produit) {
                                            echo '<option value="' . $produit['id_produit'] . '">' . $produit['nom_produit'] . '  - Prix: ' . $produit['prix_unitaire'] . '</option>';
                                        }
                                    ?>
                                </select>
                                <?php if (isset($errProduit) && !(empty($errProduit))) echo "<div class='alert alert-danger' role='alert'>$errProduit</div>" ?>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="quantities[]" placeholder="Quantity">
                                <?php if (isset($errQuantite) && !(empty($errQuantite))) echo "<div class='alert alert-danger' role='alert'>$errQuantite</div>" ?>
                            </div>
                        </div>
                    </div>
                    <!-- Add more selects dynamically -->
                    <div id="additionalProducts"></div>

                    <button type="button" class="btn btn-success mt-3" onclick="addProductSelect()">Add Product</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="date_commande" class="form-label">Date de commande</label>
                <input type="date" class="form-control" id="date_commande" name="date_commande">
                <?php if (isset($errDate) && !(empty($errDate))) echo "<div class='alert alert-danger' role='alert'>$errDate</div>" ?>
            </div>
            <button type="submit" class="btn btn-primary">Créer Commande</button>
        </form>
        
        <?php

            $errClient = '';
            $errProduit = '';
            $errQuantite = '';
            $errDate = '';

            if(isset($_POST['client']) && isset($_POST['products']) && isset($_POST['quantities']) && isset($_POST['date_commande'])) {
                $validatedProductIds = $_POST['products'];
                $validatedQuantities = $_POST['quantities'];
                $clientId = $_POST['client'];
                $dateCommande = $_POST['date_commande'];               
            
                $result = ajouterCommande($validatedProductIds, $validatedQuantities, $clientId, $dateCommande);

                if ($result) {
                    echo "<script>alert('Commande ajoutée avec succès!')</script>";
                    header('Location: commandes.php');
                    ob_end_flush();    
                } else {
                    echo "<script>alert('Erreur lors de l\'ajout de la commande.')</script>";
                }
              
            }
        ?>

    <script>
        var productIdCounter = 1;

        function addProductSelect() {
            var clonedProductDiv = $("#product1").clone();

            productIdCounter++;
            var newId = "product" + productIdCounter;
            clonedProductDiv.attr("id", newId);

            clonedProductDiv.find(".product-select").attr("name", "products[]");

            $(".product-select").each(function () {
                var selectedOption = $(this).find(":selected").val();
                clonedProductDiv.find(".product-select option[value='" + selectedOption + "']").remove();
            });

            var removeButton = $('<button type="button" class="btn btn-danger mt-3" onclick="removeProductSelect(this)">Remove</button>');

            $("#additionalProducts").append(clonedProductDiv).append(removeButton);
        }

        function removeProductSelect(button) {
            var container = $(button).prev();

            container.remove();
            $(button).remove();
        }
    </script>

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