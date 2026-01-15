<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="style.css" rel="stylesheet">
    <title>Document</title>
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
					<input name="author" class="form-control flex-grow-1" type="text" placeholder="Rechercher dans le catalogue (saisir le nom de l'auteur)" style="background-color: #e7f3ff; height: 32px;" value="">
					<button class="btn btn-success" type="submit">Recherche</button>
				</form>
				<?php if (!isset($_SESSION['user'])): ?>
					<a href="login.php" class="btn btn-outline-primary ms-2">Connexion</a>
				<?php endif; ?>
				<?php if (isset($_SESSION['user'])): ?>
						<?php if ($_SESSION['user']['profil'] == 'admin'): ?>
							<a href="admin.php" class="btn btn-outline-warning ms-2">Administration</a>
						<?php endif; ?>
						<a href="logout.php" class="btn btn-outline-danger ms-2">Déconnexion</a>
				<?php endif; ?>
				<a href="panier.php" class="btn btn-outline-info ms-2">Panier</a>
			</nav><br>
		</div>
	</div>
	</div>	