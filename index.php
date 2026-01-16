<!DOCTYPE html>
<html lang="en">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="style.css" rel="stylesheet">
	<title>Page d'acceuil</title>
</head>
<body>
	
<?php 
session_start();
require_once 'navbar.php'; 
?>
	
	<div class="container">
	<div class="row">
		<div class="col-md-9">
			<!--Selectionne les 3 derniers livres par date d'ajout-->
			<?php
				require_once 'connexion.php';
				$stmt = $connexion->prepare("SELECT titre, photo FROM livre ORDER BY dateajout DESC LIMIT 3");
				$stmt->execute();
				$livres = $stmt->fetchAll(PDO::FETCH_OBJ); // Récupère tous les livres en tant qu'objets
			?>
			<!--Pour afficher le carrousel de façon dynamique-->
			<h2 class="mb-3">Dernières acquisitions</h2>
			<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">
					<?php foreach ($livres as $index => $livre): ?>
					<div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>"> <!-- Rend le premier élément actif -->
					<img src="covers/<?php echo ($livre->photo); ?>" class="d-block w-100" alt="<?php echo ($livre->titre); ?>" style="max-height: 500px; object-fit: contain;">
					</div>
					<?php endforeach; ?>
				</div>

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
		<?php include 'connecte.php'; ?>
	</div>
	</div>
</body>
</html>
	