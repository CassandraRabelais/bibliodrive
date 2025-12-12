<!DOCTYPE html>
<html lang="en">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="style.css" rel="stylesheet">
	<title>Détails du livre</title>
</head>
<body>
	
    <?php require_once 'navbar.php'; ?>

		<div class="row">
			<div class="col-md-9">
				<?php
					require_once 'connexion.php';
					$livre = null;
					$searchQuery = isset($_GET['author']) ? trim($_GET['author']) : '';
					
					if (isset($_GET['nolivre']) && is_numeric($_GET['nolivre'])) {
						$nolivre = (int) $_GET['nolivre'];
						$sql = "SELECT l.titre, l.photo, l.isbn13, l.anneeparution, l.detail, l.dateajout, a.nom, a.prenom 
								FROM livre l 
								JOIN auteur a ON l.noauteur = a.noauteur 
								WHERE l.nolivre = :nolivre";
						$stmt = $connexion->prepare($sql);
						$stmt->bindParam(':nolivre', $nolivre, PDO::PARAM_INT);
						$stmt->execute();
						$livre = $stmt->fetch(PDO::FETCH_ASSOC);
					}
				?>

				<?php if ($livre): ?>
					<div class="row">
						<div class="col-md-4">
							<img src="covers/<?php echo htmlspecialchars($livre['photo']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($livre['titre']); ?>" style="max-height:400px; object-fit:contain;">
						</div>
						<div class="col-md-8">
							<h2><?php echo htmlspecialchars($livre['titre']); ?></h2>
							<p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['prenom'] . ' ' . $livre['nom']); ?></p>
							<p><strong>ISBN-13 :</strong> <?php echo htmlspecialchars($livre['isbn13']); ?></p>
							<p><strong>Année de parution :</strong> <?php echo htmlspecialchars($livre['anneeparution']); ?></p>
							<p><strong>Date d'ajout :</strong> <?php echo htmlspecialchars($livre['dateajout']); ?></p>
							<h5>Description :</h5>
							<p><?php echo nl2br(htmlspecialchars($livre['detail'])); ?></p>
							<p class="disponible" >Disponible</p>
							<p class="indication" >Pour pouvoir vous identifier, vous devez posséder un compte et vous connecter.</p>
							<a href="Recherche.php<?php echo !empty($searchQuery) ? '?author=' . urlencode($searchQuery) : ''; ?>" class="btn btn-secondary">Retour à la recherche</a>
						</div>
					</div>
				<?php else: ?>
					<div class="alert alert-danger" role="alert">
						Livre non trouvé ou numéro invalide.
					</div>
					<a href="Recherche.php<?php echo !empty($searchQuery) ? '?author=' . urlencode($searchQuery) : ''; ?>" class="btn btn-secondary">Retour à la recherche</a>
				<?php endif; ?>

				<!-- Bootstrap JS -->
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
			</div>

			<?php include 'inscription.php'; ?>
		</div>
	</div>

</body>
</html>