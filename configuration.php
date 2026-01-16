<?php
session_start();

if (isset($_POST['deco'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}
require_once('connexion.php');
// Afficher l'en-tête selon le profil
if (isset($_SESSION['profil']) && $_SESSION['profil'] == 'admin') {
    include 'navbar.php';
} 
?>