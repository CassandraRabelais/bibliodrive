<!DOCTYPE html>
<html lang="en">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Page d'acceuil</title>
<html>
</head>
<body>
	La bibliothèque de Moulinsart est fermée au public jusqu'à nouvel ordre. Mais il vous est possible de réserver et retirer vos livres via notre service Biblio Drive !

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-expand-sm bg-dark navbar-dark py-2">
				<form class="form-inline d-flex gap-2 w-75 mx-auto" action="/action_page.php">
					<input class="form-control flex-grow-1" type="text" placeholder="Rechercher dans le catalogue (saisir le nom de l'auteur)" style="background-color: #e7f3ff; height: 32px;">
					<button class="btn btn-success" type="submit">Recherche</button>
				</form>
			</nav><br>			
		</div>
	</div>
	<div class="row">
		<div class="col-md-9">
			
			<?php
				require_once 'connexion.php';
				$stmt = $connexion->prepare("SELECT titre, photo FROM livre ORDER BY dateajout DESC LIMIT 3");
				$stmt->execute();
				$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
			?>
			<h2 class="mb-3">Dernières acquisitions</h2>
			<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">
					<?php foreach ($livres as $index => $livre): ?>
					<div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
						<img src="covers/<?php echo htmlspecialchars($livre['photo']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($livre['titre']); ?>" style="max-height: 500px; object-fit: contain;">
					</div>
					<?php endforeach; ?>
				</div>
				<style>
					.carousel-control-prev-icon,
					.carousel-control-next-icon {
						filter: invert(1);
					}
				</style>
				<!-- Boutons précédent / suivant -->
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
					<span class="carousel-control-prev-icon"></span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
					<span class="carousel-control-next-icon"></span>
				</button>
			</div>
			<!-- Bootstrap JS -->
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
		</div>
		<!-- Colonne de connexion à droite -->
		<div class="col-md-3 d-flex align-items-start justify-content-end">
			<div class="card w-100" style="max-width: 350px;">
				<div class="card-body">
					<h5 class="card-title">Connexion</h5>
					<!-- Image au-dessus du formulaire de connexion -->
					<div class="text-center mb-3">
						<img src="Moulinsart.jpg" alt="Biblio Drive" class="img-fluid" style="max-height:150px; object-fit:contain;">
					</div>
					<form method="post" action="login.php">
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" required>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Mot de passe</label>
							<input type="password" class="form-control" id="password" name="password" required>
						</div>
						<button type="submit" class="btn btn-primary w-100">Se connecter</button>
					</form>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
	