<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="style.css" rel="stylesheet">
    <title>Inscription</title>
</head>
<body>
    <?php
    session_start();
    require_once 'connexion.php';

    $message = '';

    	// Vérifier si le formulaire a été soumis
		if (!empty($_POST)) {
        // Récupérer les données du formulaire
        $mel = $_POST['mel'];
        $motdepasse = $_POST['motdepasse'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $adresse = $_POST['adresse'];
        $ville = $_POST['ville'];
        $codepostal = $_POST['codepostal'];

        // Vérifier si l'email est déjà utilisé
        $stmt = $connexion->prepare("SELECT mel FROM utilisateur WHERE mel = ?");
        $stmt->execute([$mel]);
        if ($stmt->fetch()) {
            // Email déjà existant
            $message = "Cet email est déjà utilisé.";
        } else {
            // Insérer le nouvel utilisateur avec profil 'client'
            $stmt = $connexion->prepare("INSERT INTO utilisateur (mel, motdepasse, nom, prenom, adresse, ville, codepostal, profil) VALUES (?, ?, ?, ?, ?, ?, ?, 'client')");
            if ($stmt->execute([$mel, $motdepasse, $nom, $prenom, $adresse, $ville, $codepostal])) {
                // Inscription réussie
                $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            } else {
                // Erreur lors de l'insertion
                $message = "Erreur lors de l'inscription.";
            }
        }
    }
    ?>

	    <!-- Colonne d'inscription à droite -->
		<div class="col-md-3 d-flex align-items-start justify-content-end">
			<div class="card w-100" style="max-width: 350px;">
				<div class="card-body">
					<h5 class="card-title">Inscription</h5>
					<!-- Afficher les messages (succès ou erreur) -->
					<?php if ($message): ?>
						<div class="alert alert-info"><?php echo $message; ?></div>
					<?php endif; ?>
					<!-- Formulaire d'inscription -->
					<form method="post" action="inscription.php">
						<div class="mb-3">
							<label for="mel" class="form-label">Email</label>
							<input type="email" class="form-control" id="mel" name="mel" required>
						</div>
						<div class="mb-3">
							<label for="motdepasse" class="form-label">Mot de passe</label>
							<input type="password" class="form-control" id="motdepasse" name="motdepasse" required>
						</div>
						<div class="mb-3">
							<label for="nom" class="form-label">Nom</label>
							<input type="text" class="form-control" id="nom" name="nom" required>
						</div>
						<div class="mb-3">
							<label for="prenom" class="form-label">Prénom</label>
							<input type="text" class="form-control" id="prenom" name="prenom" required>
						</div>
						<div class="mb-3">
							<label for="adresse" class="form-label">Adresse</label>
							<input type="text" class="form-control" id="adresse" name="adresse" required>
						</div>
						<div class="mb-3">
							<label for="ville" class="form-label">Ville</label>
							<input type="text" class="form-control" id="ville" name="ville" required>
						</div>
						<div class="mb-3">
							<label for="codepostal" class="form-label">Code postal</label>
							<input type="number" class="form-control" id="codepostal" name="codepostal" required>
						</div>
						<button type="submit" class="btn btn-primary w-100">S'inscrire</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>