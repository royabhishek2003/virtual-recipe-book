<?php
session_start();

if (!isset($_SESSION['aname'])) {
    $_SESSION['error'] = "Unauthorized access.";
    header('Location: login.php');
    exit;
}

if (isset($_GET['rid'])) {
    try {
        $dbhandler = new PDO('mysql:host=127.0.0.1;dbname=cookie_rookie(4)', 'root', '');
        $dbhandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $rid = $_GET['rid'];

        $query = $dbhandler->prepare("DELETE FROM recipe WHERE rid = ?");
        $query->execute([$rid]);

        if ($query->rowCount() > 0) {
            $_SESSION['success'] = "Recipe deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete the recipe.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

header('Location: viewRequestedRecipe.php');
exit;
?>