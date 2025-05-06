<?php
// Spécifier que la sortie sera en format JSON
header('Content-Type: application/json');

// Définir les paramètres de connexion à la base de données
$servername = "localhost";  // Hôte de la base de données (généralement localhost)
$username = "root";        // Nom d'utilisateur pour se connecter à la base de données
$password = "root";        // Mot de passe de l'utilisateur
$dbname = "cuisine";       // Nom de la base de données à laquelle se connecter

// Établir la connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier si la connexion a échoué
if ($conn->connect_error) {
    // Si la connexion échoue, afficher un message d'erreur
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer les informations des plats et leurs ingrédients associés
$sql = "SELECT p.ID_PLAT, p.TITRE, p.TIME, p.INSTRUCTION, p.NOMBRE_INGREDIENT, GROUP_CONCAT(i.INGREDIENT ORDER BY i.ID_INGREDIENT) AS INGREDIENTS
        FROM plat p
        LEFT JOIN ingredient i ON p.ID_PLAT = i.ID_PLAT
        GROUP BY p.ID_PLAT";

// Exécuter la requête SQL
$result = $conn->query($sql);

// Vérifier si des résultats ont été retournés
if ($result->num_rows > 0) {
    $recipes = array();  // Initialiser un tableau pour stocker les recettes

    // Parcourir les résultats et les formater pour l'API
    while($row = $result->fetch_assoc()) {
        // Ajouter chaque recette à l'array $recipes
        $recipes[] = array(
            'id' => $row['ID_PLAT'],  // ID du plat
            'titre' => $row['TITRE'], // Titre de la recette
            'time' => $row['TIME'],   // Temps de préparation
            'instruction' => $row['INSTRUCTION'], // Instructions de préparation
            'nombreIngredients' => $row['NOMBRE_INGREDIENT'], // Nombre d'ingrédients
            'ingredients' => explode(',', $row['INGREDIENTS']) // Séparer les ingrédients par une virgule
        );
    }

    // Retourner les recettes sous forme JSON
    echo json_encode($recipes);
} else {
    // Si aucune recette n'est trouvée, retourner un message dans le format JSON
    echo json_encode(array('message' => 'Aucune recette trouvée.'));
}

// Fermer la connexion à la base de données
$conn->close();
?>
