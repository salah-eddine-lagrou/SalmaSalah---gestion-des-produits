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
        <h2>Ajouter Client</h2>
        <form action="ajouterClient.php" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de client</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
                <?php if(isset($errNomClient) && !(empty($errNomClient))) echo "<div class='alert alert-danger' role='alert'>$errNomClient</div>" ?>
                
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"  required>
                <?php if(isset($errEmail) && !(empty($errEmail))) echo "<div class='alert alert-danger' role='alert'>$errEmail</div>" ?>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="stock" name="adresse" required>
                <?php if(isset($errAdresse) && !(empty($errAdresse))) echo "<div class='alert alert-danger' role='alert'>$errAdresse</div>" ?>
            </div>
        
            <button type="submit" class="btn btn-primary">Ajouter Client</button>
        </form>
    </div>


    <?php
    // Code d'ajout validation et redirection au page clients
        $errNomClient = "";
        $errEmail = "";
        $errAdresse = "";
        $valid = true;

        if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['adresse']) ) {
            if(empty($_POST['nom']) || empty($_POST['email']) || empty($_POST['adresse']) ) {
                if(empty($_POST['nom'])) {
                    $errNomClient = "Veuillez remplir ce chanmp de nom";
                    $valid = false;
                }
                if(empty($_POST['email'])) {
                    $errEmail = "Veuillez remplir ce chanmp de l email";
                    $valid = false;
                }
                if(empty($_POST['adresse'])) {
                    $errAdresse = "Veuillez remplir ce chanmp de l adresse";
                    $valid = false;
                }
                
            }
            // TODO validation sur les champs envoyes est ce qu'ils contient des caracteres speciaux etc ...

            if($valid) {
                include '../services.php';

                $client = [
                    "nom" => "",
                    "email" => "",
                    "adresse" => ""
                ];
            
                $client["nom"] = htmlspecialchars($_POST['nom']); 
                $client["email"] = htmlspecialchars($_POST['email']);
                $client["adresse"] = htmlspecialchars($_POST['adresse']);
                
                $result = ajouterClients($client);
                if ($result) {
                    echo '<script>alert("client est ajoute avec succes !");</script>';
                    header('Location: clients.php');
                    exit();
                } else {
                    echo '<script>alert("ERREUR : client non ajouter !");</script>';
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