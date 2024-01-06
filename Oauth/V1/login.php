<?php
// login_process.php

// Fonction pour se connecter à la base de données
function connectToDatabase() {
    $host = 'localhost';
    $utilisateur_db = 'soundvibe';
    $motdepasse_db = 'admin';
    $nom_db = 'soundvibe_users';

    // Créer une connexion
    $conn = new mysqli($host, $utilisateur_db, $motdepasse_db, $nom_db);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    return $conn;
}

// Fonction pour vérifier les identifiants
function authenticateUser($utilisateur, $motdepasse, $conn) {
    $utilisateur = $conn->real_escape_string($utilisateur);
    $motdepasse = $conn->real_escape_string($motdepasse);

    $sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur = '$utilisateur' AND mot_de_passe = '$motdepasse'";
    $result = $conn->query($sql);

    return $result->num_rows > 0;
}

// Fonction pour gérer l'authentification
function handleAuthentication($utilisateur, $motdepasse) {
    $conn = connectToDatabase();

    if (authenticateUser($utilisateur, $motdepasse, $conn)) {
        // Authentification réussie
        // Ajoutez ici des actions spécifiques à effectuer après une authentification réussie
        // par exemple, redirection vers une autre page, enregistrement de la session, etc.
        header("Location: index.html?user");
        exit();
    } else {
        // Authentification échouée, rediriger avec un paramètre d'erreur
        header("Location: login.html?error=auth");
        exit();
    }

    $conn->close();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur = $_POST['utilisateur'];
    $motdepasse = $_POST['motdepasse'];

    handleAuthentication($utilisateur, $motdepasse);
}
?>
