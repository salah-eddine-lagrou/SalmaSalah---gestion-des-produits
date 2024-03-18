<?php
ob_start();
include '../components/navbar.php';
include '../services.php';

$clients = clients();
$produits = produits();

if (isset($_GET['id_commande_modifie'])) {
    $id_commande = $_GET['id_commande_modifie'];
    $commande = obtenirCommandeModifier($id_commande);
}

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
        <h2>Modifier Commande</h2>
        <form action="modifierCommande.php" method="post">
            <div class="mb-3">
                <label for="client" class="form-label"><strong>Client</strong></label>
                <div class="form-group border pb-2 pr-2 pt-2 pl-2">
                    <div class="input-group">
                        <span class="form-arrow"><i class="bx bx-chevron-down"></i></span>
                        <select name="client" id="client" class="form-control">
                            <option disabled>Select Client</option>
                            <?php
                            foreach ($clients as $client) {
                                $selected = ($client['id_client'] == $commande[0]['id_client']) ? 'selected' : '';
                                echo '<option value="' . $client['id_client'] . '" ' . $selected . '>' . $client['nom'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Produits</strong></label>
                <div class="form-group border pb-2 pr-2 pt-2 pl-2">
                    <?php
                    if(isset($commande)){
                        foreach ($commande as $i => $produit) {
                            ?>
                            <div class="form-group" id="product<?php echo $i + 1; ?>">
                                <label for="product<?php echo $i + 1; ?>">Select Produits :</label>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control product-select" name="products[<?php echo $i; ?>]">
                                            <option value="">Select a product</option>
                                            <?php
                                            
                                            foreach ($produits as $p) {
                                                $selected = ($p['id_produit'] == $produit['id_produit']) ? 'selected' : '';
                                                echo '<option value="' . $p['id_produit'] . '" ' . $selected . '>' . $p['nom_produit'] . '  - Prix: ' . $p['prix_unitaire'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" name="quantities[]"
                                            placeholder="Quantity" value="<?php echo $produit['quantite_produit']; ?>">
                                    </div>
                                </div>                            
                            </div>
                            <?php                        
                        }
                    }
                    
                    ?>
                    <!-- Add more selects dynamically -->
                    <div id="additionalProducts"></div>
                    <button type="button" class="btn btn-success mt-3" onclick="addProductSelect()">Add Product</button>
                </div>
            </div>



            <div class="mb-3">
                <label for="date_commande" class="form-label">Date de commande</label>
                <input type="date" class="form-control" id="date_commande" name="date_commande"
                    value="<?php echo $commande[0]['date_commande']; ?>">
                <input type="hidden" name="id_commande" value="<?php echo $commande[0]['id_commande'] ?>">
            </div>

            <button type="submit" class="btn btn-primary">Modifier Commande</button>
        </form>

        <?php

        $errClient = '';
        $errProduit = '';
        $errQuantite = '';
        $errDate = '';

        if (isset($_POST['client']) && isset($_POST['products']) && isset($_POST['quantities']) && isset($_POST['date_commande']) && isset($_POST['id_commande'])) {
            $validatedProductIds = $_POST['products'];
            $validatedQuantities = $_POST['quantities'];
            $clientId = $_POST['client'];
            $dateCommande = $_POST['date_commande'];
            $id_commande = $_POST['id_commande'];

            $result = modifierCommande($id_commande, $validatedProductIds, $validatedQuantities, $clientId, $dateCommande);

            if ($result) {
                echo "<script>alert('Commande est modifie avec succès!')</script>";
                header('Location: commandes.php');
                ob_end_flush();               
            } else {
                echo "<script>alert('Erreur lors de laa modification de la commande.')</script>";
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