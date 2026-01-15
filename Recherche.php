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
		session_start();
		require_once 'navbar.php';
	?>

	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="alert alert-info" role="alert">
					Vous pouvez emprunter jusqu'à 5 livres maximum.
				</div>
				<?php
					require_once 'connexion.php';
					$livres = [];
					$searchQuery = '';
					
					//Pour afficher les livres de tels ou tels auteur juste avec le nom ou prénom
					if (isset($_GET['author'])) {
    				$searchQuery = ($_GET['author']);

   					$sql = "SELECT l.nolivre, l.titre, a.nom, a.prenom
            				FROM livre l
            				INNER JOIN auteur a ON l.noauteur = a.noauteur
            				WHERE a.nom LIKE :author
               				OR a.prenom LIKE :author
            				ORDER BY l.dateajout DESC";

    				$stmt = $connexion->prepare($sql);
    				$param = '%' . $searchQuery . '%';
					$stmt->bindValue(':author', $param, PDO::PARAM_STR);
					$stmt->execute();
    				$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
					}				
					?>


				<?php if (!empty($searchQuery)): ?>
					<h2 class="mb-3">Résultats de recherche pour "<?php echo ($searchQuery); ?>"</h2>
					
					<?php if (!empty($livres)): ?>
						<ul class="list-group">
							<?php foreach ($livres as $livre): ?>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									<a href="détails.php?nolivre=<?php echo ($livre['nolivre'] ?? ''); ?>&author=<?php echo ($searchQuery); ?>" class="text-decoration-none"><?php echo ($livre['titre']); ?></a>
									<?php if (isset($_SESSION['user'])): ?>
<!--emmène vers la page détail-->			<form method="post" action="détails.php?nolivre=<?php echo ($livre['nolivre'] ?? ''); ?>&author=<?php echo ($searchQuery); ?>" style="display: inline;">
											<input type="hidden" name="add_to_cart" value="1">
											<button type="submit" class="btn btn-sm btn-primary">Ajouter au panier</button>
										</form>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<div class="alert alert-warning" role="alert">
							Aucun livre trouvé pour l'auteur "<?php echo ($searchQuery); ?>".
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

				<?php include 'connecte.php'; ?>
		</div>
	</div>

</body>
</html>