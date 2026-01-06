<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Administration</title>
</head>
<body>
    <?php
    session_start();
    require_once 'connexion.php';

    if (!isset($_SESSION['user']) || $_SESSION['user']['profil'] != 'admin') {
        header("Location: login.php");
        exit;
    }

    require_once 'navbar.php';
    ?>

    <div class="container mt-4">
        <h1>Panneau d'Administration</h1>
        
        <!-- Exemple de fonctionnalités admin -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gérer les utilisateurs</h5>
                        <p class="card-text">Ajouter, modifier ou supprimer des utilisateurs.</p>
                        <a href="ajoutermembre.php" class="btn btn-primary">Ajouter un utilisateur</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gérer les livres</h5>
                        <p class="card-text">Ajouter, modifier ou supprimer des livres.</p>
                        <a href="ajouteruunlivre.php" class="btn btn-primary">Ajouter un livre</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
