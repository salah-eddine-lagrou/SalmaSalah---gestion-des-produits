<?php
include '../components/navbar.php';
include '../services.php';
$prodAffiche = [
    "id_client" => 0, 
    "nom" => "",
    "email" => "",
    "adresse" => ""
];

if(isset($_GET['id_client_modifie'])) {
    $prodAffiche = obtenirClient($_GET['id_client_modifie']);
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
    <h2>Modifier Client</h2>
    <form action="modifierClient.php" method="post">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de client</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo isset($prodAffiche['nom']) ? htmlspecialchars($prodAffiche['nom']) : ''; ?>" required>
            <?php if (isset($errNomClient) && !(empty($errNomClient))) echo "<div class='alert alert-danger' role='alert'>$errNomClient</div>" ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($prodAffiche['email']) ? htmlspecialchars($prodAffiche['email']) : ''; ?>" required>
            <?php if (isset($errEmail) && !(empty($errEmail))) echo "<div class='alert alert-danger' role='alert'>$errEmail</div>" ?>
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo isset($prodAffiche['adresse']) ? htmlspecialchars($prodAffiche['adresse']) : ''; ?>" required>
            <?php if(isset($errAdresse) && !(empty($errAdresse))) echo "<div class='alert alert-danger' role='alert'>$errAdresse</div>" ?>
        </div>
        <input type="hidden" id="id_client" name="id_client" value="<?php echo isset($prodAffiche['id_client']) ? $prodAffiche['id_client'] : ''; ?>">
        <button type="submit" class="btn btn-primary">Modifier Client</button>
    </form>
</div>

<?php
$errNomClient = "";
$errEmail = "";
$errAdresse = "";
$valid = true;

if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['adresse'])) {
    if(empty($_POST['nom']) || empty($_POST['email']) || empty($_POST['adresse'])) {
        if(empty($_POST['nom'])) {
            $errNomClient = "Veuillez remplir ce champ de nom";
            $valid = false;
        }
        if(empty($_POST['email'])) {
            $errEmail = "Veuillez remplir ce champ de l'email";
            $valid = false;
        }
        if(empty($_POST['adresse'])) {
            $errAdresse = "Veuillez remplir ce champ de l'adresse";
            $valid = false;
        }
    }

    if($valid) {
        $id_client = $_POST['id_client'];
        $prodAffiche["nom"] = htmlspecialchars($_POST['nom']);
        $prodAffiche["email"] = htmlspecialchars($_POST['email']);
        $prodAffiche["adresse"] = htmlspecialchars($_POST['adresse']);

        $result = modifierClient($prodAffiche, $id_client);
        if ($result) {
            echo '<script>alert("Client est modifié avec succès !");</script>';
            header('Location: clients.php');
            exit();
        } else {
            echo '<script>alert("ERREUR : client non modifié !");</script>';
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
