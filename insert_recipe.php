<?php
// Paramètres de connexion à la base de données
$host = "localhost";  // Hôte de la base de données (généralement localhost)
$user = "root";       // Nom d'utilisateur pour se connecter à la base de données
$password = "root";   // Mot de passe de l'utilisateur
$dbname = "cuisine";  // Nom de la base de données

// Établir la connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier si la connexion a échoué
if ($conn->connect_error) {
    // Si la connexion échoue, afficher un message d'erreur au format JSON et arrêter l'exécution
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Récupérer les valeurs envoyées via la méthode POST
$titre = $_POST['titre'];                // Le titre de la recette
$time = $_POST['time'];                  // Le temps de préparation
$instruction = $_POST['instruction'];    // Les instructions pour préparer le plat
$nombreIngredients = intval($_POST['nombreIngredients']); // Nombre d'ingrédients

// Préparer la requête pour insérer une nouvelle recette (plat)
$stmt = $conn->prepare("INSERT INTO PLAT (TITRE, TIME, INSTRUCTION, NOMBRE_INGREDIENT) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $titre, $time, $instruction, $nombreIngredients); // Lier les paramètres
$stmt->execute(); // Exécuter la requête d'insertion
$platId = $stmt->insert_id; // Récupérer l'ID du plat inséré (id généré automatiquement)

// Ajouter les ingrédients dans la table INGREDIENT
for ($i = 0; $i < $nombreIngredients; $i++) {
    // Pour chaque ingrédient, récupérer sa clé dans les données POST
    $ingredientKey = "ingredient" . $i;

    // Si l'ingrédient est présent dans les données POST
    if (isset($_POST[$ingredientKey])) {
        $ingredient = $_POST[$ingredientKey];  // Récupérer l'ingrédient

        // Préparer et exécuter la requête pour insérer l'ingrédient dans la table INGREDIENT
        $stmt = $conn->prepare("INSERT INTO INGREDIENT (INGREDIENT, ID_PLAT) VALUES (?, ?)");
        $stmt->bind_param("si", $ingredient, $platId); // Lier l'ingrédient et l'ID du plat
        $stmt->execute(); // Exécuter la requête d'insertion
    }
}

// Retourner un message de succès au format JSON
echo json_encode(["success" => true, "message" => "Recette ajoutée"]);

// Fermer la connexion à la base de données
$conn->close();
?>
