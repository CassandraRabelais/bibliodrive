<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Panier</title>
</head>
<body>

<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

require_once 'navbar.php';
require_once 'connexion.php';

$message = '';

/*Retirer un livre du panier*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $nolivre = (int) $_POST['nolivre'];
    if (($key = array_search($nolivre, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

/*Emprunter tous les livres*/
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['borrow_all'])
    && isset($_SESSION['user'])
    && !empty($_SESSION['cart'])
) {
    $userEmail = $_SESSION['user']['mel'];

    $success = true;

    foreach ($_SESSION['cart'] as $nolivre) {

        // Vérifie si le livre est déjà emprunté
        $checkSql = "SELECT 1 FROM emprunter 
                     WHERE mel = :mel 
                     AND nolivre = :nolivre 
                     AND dateretour IS NULL";
        $checkStmt = $connexion->prepare($checkSql);
        $checkStmt->execute([
            ':mel' => $userEmail,
            ':nolivre' => $nolivre
        ]);

        if ($checkStmt->rowCount() == 0) {
            // Emprunt
            $borrowSql = "INSERT INTO emprunter (mel, nolivre, dateemprunt)
                          VALUES (:mel, :nolivre, CURDATE())";
            $borrowStmt = $connexion->prepare($borrowSql);

            if (!$borrowStmt->execute([
                ':mel' => $userEmail,
                ':nolivre' => $nolivre
            ])) {
                $success = false;
            }
        }
    }

    if ($success) {
        $message = '<div class="alert alert-success">
                        Tous les livres ont été empruntés avec succès !
                    </div>';
    }

    $_SESSION['cart'] = []; // Vider le panier
}

/*Récupérer les livres du panier*/
$cartBooks = [];

if (!empty($_SESSION['cart'])) {
    $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
    $sql = "SELECT l.nolivre, l.titre, l.photo, a.nom, a.prenom
            FROM livre l
            JOIN auteur a ON l.noauteur = a.noauteur
            WHERE l.nolivre IN ($placeholders)";
    $stmt = $connexion->prepare($sql);
    $stmt->execute($_SESSION['cart']);
    $cartBooks = $stmt->fetchAll(PDO::FETCH_OBJ);
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-9">
            <h1>Votre Panier</h1>

            <?php echo $message; ?>

            <?php if (empty($cartBooks)): ?>
                <p>Votre panier est vide.</p>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($cartBooks as $book): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $book->titre; ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="nolivre" value="<?php echo $book->nolivre; ?>">
                                <button type="submit" name="remove" class="btn btn-danger btn-sm">
                                    Retirer
                                </button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <?php if (isset($_SESSION['user'])): ?>
                    <form method="post" class="mt-3">
                        <button type="submit" name="borrow_all" class="btn btn-success">
                            Emprunter tous les livres
                        </button>
                    </form>
                <?php else: ?>
                    <p class="alert alert-warning mt-3">
                        Vous devez être connecté pour emprunter.
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php include 'connecte.php'; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
