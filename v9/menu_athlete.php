<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["user_type"] !== "athlete") {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARAPOUTRE - Menu Athlete</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <img href="index.html" src="img/logo-carapoutre.png" alt="logo Carapoutre" class="logo"></img>
        <div class="nav-links">
            <ul>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
        <img src="img/menu-btn.png" alt="menu hamburger" class="menu-hamburger">
    </nav>

    <div class="menu">
        <div class="wrap-menu">
            <h1 id="welcome-message">Hey <?php echo $_SESSION["username"]; ?> !</h1>
        </div>
        <div class="contenu-menu">
            <button class="button2" id="menu-btn1" href="index.html">Programmation</button>
            <button class="button2" id="menu-btn2" onclick="window.location.href='menu_athlete_evolution.php'">Evolution</button>
            <button class="button2" id="menu-btn3" onclick="window.location.href='menu_athlete_parametres.php'">Parametres</button>
        </div>
    </div>

    <script src="js/menu-hamburger.js"></script>
    <script src="js/welcome-message.js"></script>
    <script src="js/button-click.js"></script>
</body>
</html>