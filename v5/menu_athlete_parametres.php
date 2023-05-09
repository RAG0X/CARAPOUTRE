<?php
    session_start();
    if(!isset($_SESSION["username"]) || $_SESSION["user_type"] !== "athlete"){
        header("Location: login.html");
        exit();
    }

    // Connexion à la base de données
    $db_host = "172.29.1.21"; // adresse IP du serveur MySQL
    $db_user = "root"; // nom d'utilisateur MySQL
    $db_pass = "1234"; // mot de passe MySQL
    $db_name = "carapoutre"; // nom de la base de données

    // Création d'une connexion MySQLi
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM base_athlete WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $email = $row["email"];
            $password = $row["password"];
            $birthdate = $row["date_de_naissance"];
            $height = $row["taille_cm"];
            $weight = $row["poids_kg"];
        }
    } else {
        echo "0 results";
    }

    if(isset($_POST["update-info"])){
        $username = $_SESSION["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $birthdate = $_POST["birthdate"];
        $height = $_POST["height"];
        $weight = $_POST["weight"];

        // Mettre à jour les informations dans la table base_athlete
        $update_query = "UPDATE base_athlete SET email='$email', password='$password', date_de_naissance='$birthdate', taille_cm='$height', poids_kg='$weight' WHERE username='$username'";
        if(mysqli_query($conn, $update_query)){
            // Mettre à jour les informations de la session
            $_SESSION["email"] = $email;
            header("Location: menu_athlete_parametres.php");
            exit();
        }
    }    

    if(isset($_POST["delete-account"])){
        $username = $_SESSION["username"];

        // Afficher une boîte de dialogue de confirmation avant de supprimer l'utilisateur
        echo "<script>
        var confirmation = confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');
        if(confirmation)
        {
            window.location.href='delete-account.php';
        }
        </script>";
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
                <h1 id="welcome-message">Besoin de changement <?php echo $_SESSION["username"]; ?> ?</h1>
            </div>
            <div class="contenu-menu">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="row">
                    <div class="column">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" value="<?php echo $email ?>" required>
                    </div>
                    <div class="column">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" value="<?php echo $password ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="column">
                        <label for="birthdate">Date de naissance</label>
                        <input type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="column">
                        <label for="height">Taille (en cm)</label>
                        <input type="number" id="height" name="height" value="<?php echo $height ?>" required>
                    </div>
                    <div class="column">
                        <label for="weight">Poids (en kg)</label>
                        <input type="number" id="weight" name="weight" value="<?php echo $weight ?>" required>
                    </div>
                </div>

                <div class="row">
                        <button id="update-btn" type="submit" name="update-info">Mettre à jour les informations</button>
                        <button id="delete-btn" type="submit" name="delete-account">Supprimer le compte</button>
                </div>
            </form>
            <button class="button2" id="retour-btn" onclick="window.location.href='menu_athlete .php'">Retour</button>
            </div>
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

    <script>
        const welcomeMessage = document.getElementById("welcome-message");
        welcomeMessage.innerHTML = "Besoin de changement " + "<?php echo $_SESSION['username']; ?>" + " ?";
    </script>
</body>
</html>
