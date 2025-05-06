<?php
// Définir les informations de connexion à la base de données
$servername = "localhost"; // Hôte de la base de données
$username = "root";        // Nom d'utilisateur pour se connecter à la base de données
$password = "root";        // Mot de passe de l'utilisateur
$dbname = "cuisine";       // Nom de la base de données

// Connexion à la base de données MySQL avec les paramètres définis ci-dessus
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion à la base de données
// Si la connexion échoue, un message d'erreur est affiché et le script est arrêté
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer l'ID du plat à supprimer à partir de l'URL (paramètre GET 'id')
$idPlat = $_GET['id'];  // 'id' doit être passé dans l'URL, par exemple: delete_plat.php?id=1

// Préparer la requête SQL de suppression pour supprimer le plat avec l'ID donné
$sql = "DELETE FROM plat WHERE ID_PLAT = ?";  // Utilisation d'un paramètre pour éviter les injections SQL
$stmt = $conn->prepare($sql); // Préparer la requête
$stmt->bind_param("i", $idPlat);  // Lier l'ID à la requête, ici "i" indique un entier (integer)

// Exécuter la requête préparée
if ($stmt->execute()) {
    // Si la suppression réussit, afficher un message de succès
    echo "Plat supprimé avec succès";
} else {
    // Si une erreur survient lors de l'exécution de la requête, afficher l'erreur
    echo "Erreur de suppression: " . $conn->error;
}

// Fermer la déclaration préparée
$stmt->close();

// Fermer la connexion à la base de données
$conn->close();
?>
