<?php

// Définir les informations de connexion à la base de données
$host = "localhost";  // Hôte de la base de données (généralement localhost)
$user = "root";       // Nom d'utilisateur pour se connecter à la base de données
$password = "root";   // Mot de passe de l'utilisateur
$dbname = "cuisine";  // Nom de la base de données à laquelle se connecter

// Établir la connexion à la base de données en utilisant les informations définies ci-dessus
$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier si la connexion a échoué
if ($conn->connect_error) {
    // Si la connexion échoue, envoyer une réponse JSON avec l'état "success" à false et un message d'erreur
    die(json_encode([
        "success" => false, // Indiquer que la connexion a échoué
        "message" => "Connection failed: " . $conn->connect_error // Message d'erreur détaillant le problème
    ]));
} else {
    // Si la connexion est réussie, envoyer une réponse JSON avec l'état "success" à true et un message de succès
    echo json_encode([
        "success" => true, // Indiquer que la connexion a réussi
        "message" => "Connected successfully!" // Message confirmant la connexion réussie
    ]);
}

// Fermer la connexion à la base de données après avoir vérifié l'état de la connexion
$conn->close();
?>
