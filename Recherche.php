<!DOCTYPE html>
<html lang="en">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="style.css" rel="stylesheet">
	<title>Résultats de recherche</title>
</head>
<body>
	
	<?php
		require_once 'navbar.php';
	?>

		<div class="row">
			<div class="col-md-9">
				<?php
					require_once 'connexion.php';
					$livres = [];
					$searchQuery = '';
					
					if (isset($_GET['author']) & trim($_GET['author']) !== '') {
						$searchQuery = trim($_GET['author']);
						$sql = "SELECT DISTINCT l.nolivre, l.titre, l.photo, a.nom, a.prenom FROM livre l 
								JOIN auteur a ON l.noauteur = a.noauteur 
								WHERE LOWER(a.nom) LIKE LOWER(:s) 
								OR LOWER(a.prenom) LIKE LOWER(:s) 
								OR LOWER(CONCAT(a.prenom, ' ', a.nom)) LIKE LOWER(:s) 
								OR LOWER(CONCAT(a.nom, ' ', a.prenom)) LIKE LOWER(:s)
								/*OR LOWER(l.titre) LIKE LOWER(:s)*/
								ORDER BY l.dateajout DESC";
						$stmt = $connexion->prepare($sql);
						$param = '%'.$searchQuery.'%';
						$stmt->bindParam(':s', $param, PDO::PARAM_STR);
						$stmt->execute();
						$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
				?>

				<?php if (!empty($searchQuery)): ?>
					<h2 class="mb-3">Résultats de recherche pour "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
					
					<?php if (!empty($livres)): ?>
						<ul class="list-group">
							<?php foreach ($livres as $livre): ?>
								<li class="list-group-item">
									<a href="détails.php?nolivre=<?php echo htmlspecialchars($livre['nolivre'] ?? ''); ?>&author=<?php echo urlencode($searchQuery); ?>" class="text-decoration-none"><?php echo htmlspecialchars($livre['titre']); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<div class="alert alert-warning" role="alert">
							Aucun livre trouvé pour l'auteur "<?php echo htmlspecialchars($searchQuery); ?>".
						</div>
					<?php endif; ?>
				<?php else: ?>
						<div class="alert alert-secondary" role="alert">
							Veuillez saisir le nom d'un auteur dans la barre de recherche pour afficher les résultats.
					</div>
				<?php endif; ?>

				<!-- Bootstrap JS -->
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
			</div>

			<?php include 'inscription.php'; ?>

</body>
</html>