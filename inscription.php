<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
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