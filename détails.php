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
	
    <?php 
    session_start();
    require_once 'navbar.php'; 
    $message = '';
    ?>

	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<?php
					require_once 'connexion.php';
					$livre = null;
					$searchQuery = isset($_GET['author']);
					// sélectionne les livres de l'auteur demandé
					if (isset($_GET['nolivre'])) {
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

					// Pour ajouter au panier 
					if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && isset($_SESSION['user'])) {
						if (!isset($_SESSION['cart'])) {
							$_SESSION['cart'] = [];
						}
						if (!in_array($nolivre, $_SESSION['cart'])) {
							if (count($_SESSION['cart']) < 5) {
								$_SESSION['cart'][] = $nolivre;
								$message = '<div class="alert alert-success">Livre ajouté au panier.</div>';
							} else {
								$message = '<div class="alert alert-danger">Panier plein. Limite de 5 livres atteinte.</div>';
							}
						} else {
							$message = '<div class="alert alert-warning">Ce livre est déjà dans votre panier.</div>';
						}
					}
				?>

				<?php if ($livre): ?>
					<div class="row">
						<div class="col-md-4">
							<img src="covers/<?php echo ($livre['photo']); ?>" class="img-fluid" alt="<?php echo ($livre['titre']); ?>" style="max-height:400px; object-fit:contain;">
						</div>
						<!--description / détail du livre-->
						<div class="col-md-8">
							<h2><?php echo ($livre['titre']); ?></h2>
							<p><strong>Auteur :</strong> <?php echo ($livre['prenom'] . ' ' . $livre['nom']); ?></p>
							<p><strong>ISBN-13 :</strong> <?php echo ($livre['isbn13']); ?></p>
							<p><strong>Année de parution :</strong> <?php echo ($livre['anneeparution']); ?></p>
							<p><strong>Date d'ajout :</strong> <?php echo ($livre['dateajout']); ?></p>
							<h5>Description :</h5>
							<p><?php echo (($livre['detail'])); ?></p>
							<?php echo $message; ?>
							<p class="disponible" >Disponible</p>
							<?php if (!isset($_SESSION['user'])): ?>
								<p class="indication">Pour pouvoir emprunter, vous devez posséder un compte et vous connecter.</p>
							<?php endif; ?>
							<?php if (isset($_SESSION['user'])): ?>
								<form method="post" style="display: inline;">
									<button type="submit" name="add_to_cart" class="btn btn-primary">Ajouter au panier</button>
								</form>
							<?php endif; ?>
							<a href="Recherche.php<?php echo !empty($searchQuery) ? '?author=' . ($searchQuery) : ''; ?>" class="btn btn-secondary">Retour à la recherche</a>
						</div>
					</div>
				<?php else: ?>
					<div class="alert alert-danger" role="alert">
						Livre non trouvé ou numéro invalide.
					</div>
					<a href="Recherche.php<?php echo !empty($searchQuery) ? '?author=' . ($searchQuery) : ''; ?>" class="btn btn-secondary">Retour à la recherche</a>
				<?php endif; ?>

				<!-- Bootstrap JS -->
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
			</div>

			<?php include 'connecte.php'; ?>
		</div>
	</div>

</body>
</html>