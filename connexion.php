<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <?php
		try {
			$dns = 'mysql:host=localhost;dbname=bibliodrive';
			$utilisateur = 'root';
			$motDePasse = '';
			$connexion = new PDO($dns, $utilisateur, $motDePasse);
		} catch (PDOException $e) {
					echo 'Échec de la connexion : ' . $e->getMessage();
		}
	?>
</body>
</html>