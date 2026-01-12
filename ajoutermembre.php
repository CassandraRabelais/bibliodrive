<?php
// ======================================
// PAGE D'AJOUT DE MEMBRE (ADMIN)
// ======================================
// Permet aux administrateurs d'ajouter des nouveaux utilisateurs
// Accessible uniquement aux admins

session_start();
require_once 'connexion.php';

// Vérifier que l'utilisateur est connecté ET qu'il est admin
if (!isset($_SESSION['user']) || $_SESSION['user']['profil'] != 'admin') {
    // Si pas admin, rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Ajouter un membre</title>
</head>
<body>
    <?php require_once 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Ajouter un nouveau membre</h2>
        <!-- Formulaire d'ajout de membre -->
        <form method="post">
            <div class="mb-3">
                <label for="mel" class="form-label">Email:</label>
                <input type="email" name="mel" class="form-control" id="mel" required>
            </div>
            <div class="mb-3">
                <label for="motdepasse" class="form-label">Mot de passe:</label>
                <input type="password" name="motdepasse" class="form-control" id="motdepasse" required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" name="nom" class="form-control" id="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom:</label>
                <input type="text" name="prenom" class="form-control" id="prenom" required>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse:</label>
                <input type="text" name="adresse" class="form-control" id="adresse" required>
            </div>
            <div class="mb-3">
                <label for="ville" class="form-label">Ville:</label>
                <input type="text" name="ville" class="form-control" id="ville" required>
            </div>

            <div class="mb-3">
                <label for="codepostal" class="form-label">Code postal:</label>
                <input type="text" name="codepostal" class="form-control" id="codepostal" required> 

            <div class="mb-3">
                <label for="profil" class="form-label">Profil:</label>
                <!-- Sélectionner le type de profil (Client ou Admin) -->
                <select name="profil" class="form-control" id="profil" required>
                    <option value="client">Client</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <!-- Boutons d'action -->
            <button type="submit" class="btn btn-primary">Ajouter le membre</button>
            <a href="admin.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    <?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Préparer la requête d'insertion dans la table utilisateur
        $insertStmt = $connexion->prepare("INSERT INTO utilisateur (mel, motdepasse, nom, prenom, adresse, ville, codepostal, profil) VALUES (:mel, :motdepasse, :nom, :prenom, :adresse, :ville, :codepostal, :profil)");
        
        // Récupérer les valeurs du formulaire
        $mel = $_POST['mel'];
        $motdepasse = $_POST['motdepasse'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $adresse = $_POST['adresse'];
        $ville = $_POST['ville'];
        $codepostal = $_POST['codepostal'];
        $profil = $_POST['profil'];
        
        // Lier les paramètres à la requête préparée
        $insertStmt->bindValue(':mel', $mel);
        $insertStmt->bindValue(':motdepasse', $motdepasse);
        $insertStmt->bindValue(':nom', $nom);
        $insertStmt->bindValue(':prenom', $prenom);
        $insertStmt->bindValue(':adresse', $adresse);
        $insertStmt->bindValue(':ville', $ville);
        $insertStmt->bindValue(':codepostal', $codepostal);
        $insertStmt->bindValue(':profil', $profil);
        
        // Exécuter la requête et afficher un message de confirmation
        if ($insertStmt->execute()) {
            echo "<div class='alert alert-success mt-3'>Membre ajouté avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Erreur lors de l'ajout du membre.</div>";
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>