<?php


require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$friends = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire d'ajout d'ami
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["firstname"], $_POST["lastname"])) {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);

    if (!empty($firstname) && strlen($firstname) <= 45 && !empty($lastname) && strlen($lastname) <= 45) {
        // Requête préparée pour l'ajout d'un ami
        $insertQuery = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
        $insertStatement = $pdo->prepare($insertQuery);
        $insertStatement->bindParam(":firstname", $firstname, PDO::PARAM_STR);
        $insertStatement->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $insertStatement->execute();
        
        // Redirection après l'ajout
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste d'amis</title>
</head>
<body>
    <h1>Liste d'amis</h1>

    <h2>Amis existants :</h2>
    <ul>
        <?php foreach ($friends as $friend) : ?>
            <li><?= $friend["firstname"] . " " . $friend["lastname"] ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Ajouter un ami :</h2>
    <form method="post">
        <label for="firstname">Firstname:</label>
        <input type="text" name="firstname" required><br>

        <label for="lastname">Lastname:</label>
        <input type="text" name="lastname" required><br>

        <input type="submit" value="Ajouter un ami">
    </form>
</body>
</html>
