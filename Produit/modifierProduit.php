<?php
include '../components/navbar.php';
include '../services.php';
$prodAffiche = [
    "id_produit" => 0, 
    "nom_produit" => "",
    "prix_unitaire" => 0,
    "quantite_stock" => "",
    "description" => ""
];

if(isset($_GET['id_produit_modifie'])) {
    $prodAffiche = obtenirProduit($_GET['id_produit_modifie']);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <div class="container mt-5">
        <h2>Modifier Produit</h2>
        <form action="modifierProduit.php" method="post">
            <div class="mb-3">
                <label for="nom_produit" class="form-label">Nom de produit</label>
                <input type="text" class="form-control" id="nom_produit" name="nom_produit" value="<?php echo isset($prodAffiche['nom_produit']) ? htmlspecialchars($prodAffiche['nom_produit']) : ''; ?>" required>
                <?php if (isset($errNomProduit) && !(empty($errNomProduit))) echo "<div class='alert alert-danger' role='alert'>$errNomProduit</div>" ?>
            </div>
            <div class="mb-3">
                <label for="prix_unitaire" class="form-label">Prix</label>
                <input type="number" class="form-control" id="prix_unitaire" name="prix_unitaire" step="0.01" value="<?php echo isset($prodAffiche['prix_unitaire']) ? $prodAffiche['prix_unitaire'] : ''; ?>" required>
                <?php if (isset($errPrix) && !(empty($errPrix))) echo "<div class='alert alert-danger' role='alert'>$errPrix</div>" ?>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Quantite de Stock</label>
                <input type="number" class="form-control" id="stock" name="quantite_stock" value="<?php echo isset($prodAffiche['quantite_stock']) ? $prodAffiche['quantite_stock'] : ''; ?>" required>
                <?php if(isset($errQuantite) && !(empty($errQuantite))) echo "<div class='alert alert-danger' role='alert'>$errQuantite</div>" ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" required><?php echo isset($prodAffiche['description']) ? htmlspecialchars($prodAffiche['description']) : ''; ?></textarea>
                <?php if(isset($errDescription) && !(empty($errDescription))) echo "<div class='alert alert-danger' role='alert'>$errDescription</div>" ?>
            </div>
            <input type="hidden" id="id_produit" name="id_produit" value="<?php echo isset($prodAffiche['id_produit']) ? $prodAffiche['id_produit'] : ''; ?>">
            <button type="submit" class="btn btn-primary">Modifier Product</button>
        </form>

    </div>


    <?php        

        $errNomProduit = "";
        $errPrix = "";
        $errQuantite = "";
        $errDescription = "";
        $valid = true;

        if(isset($_POST['nom_produit']) && isset($_POST['prix_unitaire']) && isset($_POST['quantite_stock']) && isset($_POST['description'])) {
            if(empty($_POST['nom_produit']) || empty($_POST['prix_unitaire']) || empty($_POST['quantite_stock']) || empty($_POST['description'])) {
                if(empty($_POST['nom_produit'])) {
                    $errNomProduit = "Veuillez remplir ce chanmp de nom";
                    $valid = false;
                }
                if(empty($_POST['prix_unitaire'])) {
                    $errPrix = "Veuillez remplir ce chanmp de prix";
                    $valid = false;
                }
                if(empty($_POST['quantite_stock'])) {
                    $errQuantite = "Veuillez remplir ce chanmp de quantite";
                    $valid = false;
                }
                if(empty($_POST['description'])) {
                    $errDescription = "Veuillez remplir ce chanmp de description";
                    $valid = false;
                }
            }
            // TODO validation sur les champs envoyes est ce qu'ils contient des caracteres speciaux etc ...

            if($valid) {

                $produit = [
                    "nom_produit" => "",
                    "prix_unitaire" => 0,
                    "quantite_stock" => "",
                    "description" => ""
                ];
                
                $id_produit = $_POST['id_produit'];
                $produit["nom_produit"] = htmlspecialchars($_POST['nom_produit']);
                $produit["prix_unitaire"] = floatval($_POST['prix_unitaire']);
                $produit["quantite_stock"] = intval($_POST['quantite_stock']);
                $produit["description"] = htmlspecialchars($_POST['description']);
                                
                $result = modifierProduit($produit, $id_produit);
                if ($result) {
                    echo '<script>alert("Produit est modifie avec succes !");</script>';
                    header('Location: produits.php');
                    exit();
                } else {
                    echo '<script>alert("ERREUR : Produit non modifie !");</script>';
                }
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