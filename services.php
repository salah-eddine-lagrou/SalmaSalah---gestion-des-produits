<?php

function connection() {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=gestion_magasin", "root", "");
        return $conn;
    } catch(Exception $e) {
        die('Erreur dans la connection avec la base de donnees : '.$e->getMessage());        
    }
}

function ajouterProduits($produit) {
    $bdd = connection();
    $query = "INSERT INTO produits (nom_produit, prix_unitaire, quantite_stock, description) VALUES(?, ?, ?, ?)";

    $statement = $bdd->prepare($query);
    $statement->bindParam(1, $produit['nom_produit']);
    $statement->bindParam(2, $produit['prix_unitaire']);
    $statement->bindParam(3, $produit['quantite_stock']);
    $statement->bindParam(4, $produit['description']);
    $result = $statement->execute();
    
    $statement->closeCursor();
    $bdd = null;

    return $result;
}

function modifierProduit($produit, $id_produit) {
    $bdd = connection();
    $query = "UPDATE produits 
              SET nom_produit = ?,
                  prix_unitaire = ?,
                  quantite_stock = ?,
                  description = ? 
              WHERE id_produit = ?";

    $statement = $bdd->prepare($query);
    $statement->bindParam(1, $produit['nom_produit']);
    $statement->bindParam(2, $produit['prix_unitaire']);
    $statement->bindParam(3, $produit['quantite_stock']);
    $statement->bindParam(4, $produit['description']);
    $statement->bindParam(5, $id_produit);

    $result = $statement->execute();

    $statement->closeCursor();
    $bdd = null;

    return $result;
}

function supprimerProduit($id_produit) {
    $bdd = connection();
    $query = "DELETE FROM produits WHERE id_produit = ?";

    $statement = $bdd->prepare($query);
    $statement->bindParam(1, $id_produit);
    $result = $statement->execute();
    
    $statement->closeCursor();
    $bdd = null;

    return $result;
}

function obtenirProduit($id_produit) {
    $bdd = connection();
    $query = "SELECT * FROM produits WHERE id_produit = ?";

    $statement = $bdd->prepare($query);
    $statement->bindParam(1, $id_produit);
    $result = $statement->execute();

    if ($result) {        
        $produit = $statement->fetch(PDO::FETCH_ASSOC);        
        $statement->closeCursor();
        $bdd = null;
                
        return $produit;
    } else {
        return false;
    }
}


function produits() {
    $bdd = connection();
    $sql = 'SELECT * FROM produits';
    $query = $bdd->prepare($sql);

    $query->execute();

    $produits = $query->fetchAll(PDO::FETCH_ASSOC);

    return $produits;
}


// ! client
function ajouterClients($client) {
    $bdd = connection();
    $query = "INSERT INTO clients (nom, email, adresse) VALUES(?, ?, ?)";

    $statement = $bdd->prepare($query);
    $statement->bindParam(1, $client['nom']);
    $statement->bindParam(2, $client['email']);
    $statement->bindParam(3, $client['adresse']);
    $result = $statement->execute();
    
    $statement->closeCursor();
    $bdd = null;

    return $result;
}

function modifierClient($client, $id_client) {
    $bdd = connection();
    $query = "UPDATE clients 
              SET nom = ?,
                  email = ?,
                  adresse = ?
              WHERE id_client = ?";

    $statement = $bdd->prepare($query);
    $statement->bindParam(1, $client['nom']);
    $statement->bindParam(2, $client['email']);
    $statement->bindParam(3, $client['adresse']);
    $statement->bindParam(4, $id_client);

    $result = $statement->execute();

    $statement->closeCursor();
    $bdd = null;

    return $result;
}

function supprimerClient($id_client) {
    $bdd = connection();
    $query = "DELETE FROM clients WHERE id_client = ?";

    $statement = $bdd->prepare($query);
    $statement->bindParam(1, $id_client);
    $result = $statement->execute();
    
    $statement->closeCursor();
    $bdd = null;

    return $result;
}
function obtenirClient($id_client) {
    $bdd = connection();
    $query = "SELECT * FROM clients WHERE id_client = ?";

    $statement = $bdd->prepare($query);
    $statement->bindParam(1, $id_client);
    $result = $statement->execute();

    if ($result) {        
        $client = $statement->fetch(PDO::FETCH_ASSOC);        
        $statement->closeCursor();
        $bdd = null;
                
        return $client;
    } else {
        return false;
    }
}


function clients() {
    $bdd = connection();
    $query = 'SELECT * FROM clients';
    
    $clients = $bdd->query($query);
    return $clients;
}

// ! commande

function ajouterCommande($productIds, $quantities, $clientId, $dateCommande) {    
    if (empty($productIds) || empty($quantities) || empty($clientId) || empty($dateCommande)) {
        return false;
    }

    $conn = connection();

    $queryCommande = 'INSERT INTO commandes (date_commande, id_client) VALUES (?, ?)';
    $stmtCommandes = $conn->prepare($queryCommande);
    $stmtCommandes->bindValue(1, $dateCommande);
    $stmtCommandes->bindValue(2, $clientId);
    $stmtCommandes->execute();

    $cmdId = $conn->lastInsertId();

    $query = 'INSERT INTO details_commandes (quantite_produit, id_commande, id_produit, prix) VALUES (?, ?, ?, ?)';
    foreach ($productIds as $i => $prodId) {

        $quantity = $quantities[$i];
        $produit = obtenirProduit($prodId);
        $prixUnitaire = $produit['prix_unitaire'];
        $prixTotal = $prixUnitaire * $quantity;

        $stmt = $conn->prepare($query);
        $stmt->bindValue(1, $quantity);
        $stmt->bindValue(2, $cmdId);
        $stmt->bindValue(3, $prodId);
        $stmt->bindValue(4, $prixTotal);
        $stmt->execute();
    }

    $conn = null;

    return true;
}

function commandes() {
    $bdd = connection();
    $query = 'SELECT commandes.id_commande, COUNT(details_commandes.id_produit) AS num_produits, 
            SUM(details_commandes.prix) AS prix_total, clients.nom AS nom_client, commandes.date_commande 
            FROM commandes JOIN details_commandes ON commandes.id_commande = details_commandes.id_commande 
            JOIN clients ON commandes.id_client = clients.id_client GROUP BY commandes.id_commande;';
    
    $stmt = $bdd->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function obtenirCommande($id_commande) {
    $conn = connection();
    $query = 'SELECT commandes.id_commande, clients.nom AS nom_client, clients.adresse, clients.email,
              commandes.date_commande, details_commandes.quantite_produit, produits.nom_produit, produits.description,
              produits.prix_unitaire FROM commandes JOIN clients ON commandes.id_client = clients.id_client
              JOIN details_commandes ON commandes.id_commande = details_commandes.id_commande
              JOIN produits ON details_commandes.id_produit = produits.id_produit 
              WHERE commandes.id_commande = ?';

    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id_commande, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn = null;

    return $result;
}

function obtenirProduitsCommande($id_commande) {
    $conn = connection();
    $query = 'SELECT produits.nom_produit, produits.description, produits.prix_unitaire, details_commandes.quantite_produit
              FROM details_commandes 
              JOIN produits ON details_commandes.id_produit = produits.id_produit
              WHERE details_commandes.id_commande = ?';

    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id_commande, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conn = null;

    return $result;
}

function supprimerCommande($id_commande) {    
    $conn = connection();
    $req = "DELETE FROM `commandes` WHERE `id_commande`=?";
    $stmt = $conn->prepare($req);
    $stmt->bindValue(1, $id_commande, PDO::PARAM_INT);
    if ($stmt->execute())
        return true;
    else
        return false;
}

function modifierCommande($commandId, $productIds, $quantities, $clientId, $dateCommande) {
    if (empty($commandId) || empty($productIds) || empty($quantities) || empty($clientId) || empty($dateCommande)) {
        return false;
    }

    $conn = connection();

    $queryUpdateCommande = 'UPDATE commandes SET date_commande = ?, id_client = ? WHERE id_commande = ?';
    $stmtUpdateCommande = $conn->prepare($queryUpdateCommande);
    $stmtUpdateCommande->bindValue(1, $dateCommande);
    $stmtUpdateCommande->bindValue(2, $clientId);
    $stmtUpdateCommande->bindValue(3, $commandId);
    $stmtUpdateCommande->execute();

    $queryDeleteDetails = 'DELETE FROM details_commandes WHERE id_commande = ?';
    $stmtDeleteDetails = $conn->prepare($queryDeleteDetails);
    $stmtDeleteDetails->bindValue(1, $commandId);
    $stmtDeleteDetails->execute();

    $queryInsertDetails = 'INSERT INTO details_commandes (quantite_produit, id_commande, id_produit, prix) VALUES (?, ?, ?, ?)';
 
    foreach ($productIds as $i => $prodId) {
        $quantity = $quantities[$i];
        $produit = obtenirProduit($prodId);
        $prixUnitaire = $produit['prix_unitaire'];
        $prixTotal = $prixUnitaire * $quantity;

        $stmtInsertDetails = $conn->prepare($queryInsertDetails);
        $stmtInsertDetails->bindValue(1, $quantity);
        $stmtInsertDetails->bindValue(2, $commandId);
        $stmtInsertDetails->bindValue(3, $prodId);
        $stmtInsertDetails->bindValue(4, $prixTotal);
        $stmtInsertDetails->execute();
    }

    $conn = null;

    return true;
}

function obtenirCommandeModifier($id_commande) {
    $conn = connection();

    $query = 'SELECT commandes.id_commande, clients.id_client, clients.nom AS nom_client, clients.adresse, clients.email,
    commandes.date_commande, details_commandes.quantite_produit, produits.id_produit, produits.nom_produit, produits.description, produits.prix_unitaire 
    FROM commandes JOIN clients ON commandes.id_client = clients.id_client JOIN details_commandes ON commandes.id_commande = details_commandes.id_commande JOIN produits ON details_commandes.id_produit = produits.id_produit WHERE commandes.id_commande = ?';

    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id_commande, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conn = null;

    return $result;
}


