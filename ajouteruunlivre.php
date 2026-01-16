<?php
session_start();
require_once 'connexion.php';

// Vérifier que l'utilisateur est connecté ET qu'il est admin
if (!isset($_SESSION['user']) || $_SESSION['user']['profil'] != 'admin') {
    // Si pas admin, rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}

// Récupérer la liste des auteurs disponibles dans la base de données
$stmt = $connexion->prepare("SELECT noauteur, nom, prenom FROM auteur ORDER BY nom, prenom");
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Ajouter un livre</title>
</head>
<body>
    <?php require_once 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Ajouter un nouveau livre</h2>
        <!-- Formulaire d'ajout de livre -->
        <form method="post">
            <div class="mb-3">
                <label for="noauteur" class="form-label">Auteur:</label>
                <!-- Liste déroulante des auteurs -->
                <select name="noauteur" class="form-control" id="noauteur" required>
                    <?php while ($auteur = $stmt->fetch(PDO::FETCH_OBJ)): ?> <!-- Boucle pour chaque auteur -->
                        <option value="<?= $auteur->noauteur ?>"><?= $auteur->prenom . ' ' . $auteur->nom ?></option> <!-- Afficher prénom et nom de l'auteur -->
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="titre" class="form-label">Titre:</label>
                <input type="text" name="titre" class="form-control" id="titre" required>
            </div>
            <div class="mb-3">
                <label for="isbn13" class="form-label">ISBN13:</label>
                <input type="text" name="isbn13" class="form-control" id="isbn13" required>
            </div>
            <div class="mb-3">
                <label for="anneeparution" class="form-label">Année de parution:</label>
                <input type="number" name="anneeparution" class="form-control" id="anneeparution" required>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Résumé:</label>
                <textarea name="detail" class="form-control" id="detail" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Image:</label>
                <input type="text" name="photo" class="form-control" id="photo" required>
            </div>
            <!-- Boutons d'action -->
            <button type="submit" class="btn btn-primary">Ajouter livre</button>
            <a href="admin.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

    <?php
    // Vérifier si le formulaire a été soumis
        if (!empty($_POST)) {
        // Préparer la requête d'insertion dans la table livre
        $insertStmt = $connexion->prepare("INSERT INTO livre (noauteur, titre, isbn13, anneeparution, detail, photo, dateajout) VALUES (:noauteur, :titre, :isbn13, :anneeparution, :detail, :photo, CURDATE())");
        
        // Récupérer les valeurs du formulaire
        $noauteur = $_POST['noauteur'];
        $titre = $_POST['titre'];
        $isbn13 = $_POST['isbn13'];
        $anneeparution = $_POST['anneeparution'];
        $detail = $_POST['detail'];
        $photo = $_POST['photo'];
        
        // Lier les valeurs avec types de données spécifiés
        $insertStmt->bindValue(':noauteur', $noauteur, PDO::PARAM_INT);
        $insertStmt->bindValue(':titre', $titre, PDO::PARAM_STR);
        $insertStmt->bindValue(':isbn13', $isbn13, PDO::PARAM_STR);
        $insertStmt->bindValue(':anneeparution', $anneeparution, PDO::PARAM_INT);
        $insertStmt->bindValue(':detail', $detail, PDO::PARAM_STR);
        $insertStmt->bindValue(':photo', $photo, PDO::PARAM_STR);
        
        // Exécuter la requête et afficher un message
        if ($insertStmt->execute()) {
            $nb_ligne_affectees = $insertStmt->rowCount();
            echo "<div class='alert alert-success mt-3'>";
            echo $nb_ligne_affectees . " livre(s) ajouté(s) avec succès.<br>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Erreur lors de l'ajout du livre.</div>";
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>