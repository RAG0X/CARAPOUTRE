<?php
    session_start();

    if(!isset($_SESSION["username"]) || $_SESSION["user_type"] !== "coach"){
        header("Location: login.html");
        exit();
    }    
    // Connexion à la base de données
    $db_host = "172.29.1.21"; // adresse IP du serveur MySQL
    $db_user = "root"; // nom d'utilisateur MySQL
    $db_pass = "1234"; // mot de passe MySQL
    $db_name = "carapoutre"; // nom de la base de données

    // Création d'une connexion MySQLi
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // Vérification de la connexion
    if (!$conn) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    $username = $_SESSION["username"];
    $sql = "SELECT * FROM base_coach WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        $email = $row["email"];
        $password = $row["password"];
        $id_athlete1 = $row["Id_athlete1"];
        $id_athlete2 = $row["Id_athlete2"];
        $id_athlete3 = $row["Id_athlete3"];
        $id_athlete4 = $row["Id_athlete4"];
        }
    } else {
        echo "0 results";
    }

    // Récupération des usernames des athlètes correspondants aux IDs stockés dans les variables $id_athlete1, $id_athlete2, $id_athlete3, $id_athlete4
    $username_athlete1 = "";
    $username_athlete2 = "";
    $username_athlete3 = "";
    $username_athlete4 = "";

    if ($id_athlete1 != "") {
        $sql = "SELECT username FROM base_athlete WHERE id='$id_athlete1'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username_athlete1 = $row["username"];
        }
    }

    if ($id_athlete2 != "") {
        $sql = "SELECT username FROM base_athlete WHERE id='$id_athlete2'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username_athlete2 = $row["username"];
       }
    }

    if ($id_athlete3 != "") {
        $sql = "SELECT username FROM base_athlete WHERE id='$id_athlete3'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username_athlete3 = $row["username"];
        }
    }

    if ($id_athlete4 != "") {
        $sql = "SELECT username FROM base_athlete WHERE id='$id_athlete4'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username_athlete3 = $row["username"];
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARAPOUTRE - Paramètres</title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
    <nav class="navbar">
        <a href="index.html"><img src="img/logo-carapoutre.png" alt="logo Carapoutre" class="logo"></a>
        <div class="nav-links">
            <ul>
                <li><a href="index.html">Déconnexion</a></li>
            </ul>
        </div>
        <img src="img/menu-btn.png" alt="menu hamburger" class="menu-hamburger">
    </nav>
    <div class="menu">
        <div class="wrap-menu">
            <h1 id="welcome-message">Prêt à faire suer tes athlètes <?php echo $_SESSION["username"]; ?> ?</h1>
        </div>
        <div class="contenu-menu">
            <div class="colonne-bloc-athlete">
                <?php if ($username_athlete1 != ""): ?>
                    <div class="bloc-athlete" id="bloc-athlete1">
                        <!-- Contenu du bloc-athlete1-->
                        <h2 class="titre-bloc-athlete"><?php echo $username_athlete1 ?></h2>
                        <button class="button2" id="access-page-athlete-btn">Accéder à son profil</button>
                    </div>
                <?php endif; ?>
                <?php if ($username_athlete2 != ""): ?>
                    <div class="bloc-athlete" id="bloc-athlete2">
                        <!-- Contenu du bloc-athlete2-->
                        <h2 class="titre-bloc-athlete"><?php echo $username_athlete2 ?></h2>
                        <button class="button2" id="access-page-athlete-btn">Accéder à son profil</button>
                    </div>
                <?php endif; ?>
                <?php if ($username_athlete3 != ""): ?>
                    <div class="bloc-athlete" id="bloc-athlete3">
                        <!-- Contenu du bloc-athlete3-->
                        <h2 class="titre-bloc-athlete"><?php echo $username_athlete3 ?></h2>
                        <button class="button2" id="access-page-athlete-btn">Accéder à son profil</button>
                    </div>
                <?php endif; ?>
                <?php if ($username_athlete4 != ""): ?>
                    <div class="bloc-athlete" id="bloc-athlete4">
                        <!-- Contenu du bloc-athlete4-->
                        <h2 class="titre-bloc-athlete"><?php echo $username_athlete4 ?></h2>
                        <button class="button2" id="access-page-athlete-btn">Accéder à son profil</button>
                    </div>
                <?php endif; ?>
            </div>
            <button class="button2" id="retour-btn" onclick="window.location.href='menu_coach.php'">Retour</button>
        </div>
    </div>

    <script>
        const menuHamburger = document.querySelector(".menu-hamburger");
        const navLinks = document.querySelector(".nav-links");

        menuHamburger.addEventListener('click',()=>{
            navLinks.classList.toggle('mobile-menu')
            document.body.classList.toggle('no-scroll')
            window.scrollTo(0,0)
        });
    </script>
</body>
</html>