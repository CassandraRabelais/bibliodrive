<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
	<!--Pour avoir le détail de l'utilisateur sur le formulaire à droite-->
    <?php if (isset($_SESSION['user'])): ?>
			<div class="col-md-3 d-flex align-items-start justify-content-end">
				<div class="card w-100" style="max-width: 350px;">
					<div class="card-body">
						<h5 class="card-title">Informations utilisateur</h5>
						<p><strong>Nom :</strong> <?php echo htmlspecialchars($_SESSION['user']['nom']); ?></p>
						<p><strong>Prénom :</strong> <?php echo htmlspecialchars($_SESSION['user']['prenom']); ?></p>
						<p><strong>Email :</strong> <?php echo htmlspecialchars($_SESSION['user']['mel']); ?></p>
						<p><strong>Adresse :</strong> <?php echo htmlspecialchars($_SESSION['user']['adresse']); ?></p>
						<p><strong>Ville :</strong> <?php echo htmlspecialchars($_SESSION['user']['ville']); ?></p>
						<p><strong>Code postal :</strong> <?php echo htmlspecialchars($_SESSION['user']['codepostal']); ?></p>
					</div>
				</div>
			</div>
		<?php else: ?>
		<?php include 'formulaire.php'; ?>
        <?php endif; ?>
</body>
</html>
