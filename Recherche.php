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
	<div class="alert alert-info text-center my-3">
		La bibliothèque de Moulinsart est fermée au public jusqu'à nouvel ordre. Mais il vous est possible de réserver et retirer vos livres via notre service Biblio Drive !
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-expand-sm bg-dark navbar-dark py-2">
					<a class="navbar-brand" href="index.php">Accueil</a>
					<form class="form-inline d-flex gap-2 w-75 mx-auto" action="Recherche.php" method="get">
						<input name="author" class="form-control flex-grow-1" type="text" placeholder="Rechercher dans le catalogue (saisir le nom de l'auteur)" style="background-color: #e7f3ff; height: 32px;" value="<?php echo isset($_GET['author']) ? htmlspecialchars(trim($_GET['author'])) : ''; ?>">
						<button class="btn btn-success" type="submit">Recherche</button>
					</form>
				</nav><br>            
			</div>
		</div>

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
								OR LOWER(l.titre) LIKE LOWER(:s)
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
						<div class="row">
							<?php foreach ($livres as $livre): ?>
								<div class="col-md-4 mb-3">
									<div class="card h-100">
										<a href="détails.php?nolivre=<?php echo htmlspecialchars($livre['nolivre'] ?? ''); ?>&author=<?php echo urlencode($searchQuery); ?>" class="text-decoration-none">
											<img src="covers/<?php echo htmlspecialchars($livre['photo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($livre['titre']); ?>" style="max-height:250px; object-fit:contain;">
											<div class="card-body">	
												<h6 class="card-title"><?php echo htmlspecialchars($livre['titre']); ?></h6>
												<?php if (isset($livre['nom'])): ?>
													<p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($livre['prenom'] . ' ' . $livre['nom']); ?></small></p>
												<?php endif; ?>
											</div>
										</a>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
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