<?php

// Connexion à la base de données
$db_host = "172.29.1.21"; // adresse IP du serveur MySQL
$db_user = "root"; // nom d'utilisateur MySQL
$db_pass = "1234"; // mot de passe MySQL
$db_name = "carapoutre"; // nom de la base de données

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Vérifie si la connexion est réussie
if (!$conn) {
  die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

// Etape 1 : Entrer le mail du coach dans un input
// Etape 2 : Entrer le mail de l'athlète numéro 1 dans un input
if (isset($_POST['coach_email']) && isset($_POST['athlete_email'])) {

  // Etape 3 : Afficher l'ID de l'athlète lorsque l'on fini d'écrire dans le input du mail athlète
  $athlete_email = $_POST['athlete_email'];
  $sql = "SELECT id FROM base_athlete WHERE email='$athlete_email'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {

    // Etape 4 : Récupérer la valeur de l'ID de l'athlète
    $athlete_row = mysqli_fetch_assoc($result);
    $athlete_id = $athlete_row['id'];

    // Etape 5 : Vérifier dans Id_coach de la table de l'athlète s'il y a un déjà l'id d'un coach qui est rentrée
    $coach_email = $_POST['coach_email'];
    $sql = "SELECT id FROM base_coach WHERE email='$coach_email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

      $coach_row = mysqli_fetch_assoc($result);
      $coach_id = $coach_row['id'];

      // vérifier si l'athlète n'a pas déjà un coach
      $sql = "SELECT id_coach FROM base_athlete WHERE id='$athlete_id'";
      $result = mysqli_query($conn, $sql);
      $athlete_row = mysqli_fetch_assoc($result);

      if ($athlete_row['id_coach'] == null) {

        // Etape 6 : Renvoyer cette valeur à Id_athlete1 dans la table_coach du coach en question
        $sql = "UPDATE base_coach SET Id_athlete1='$athlete_id' WHERE id='$coach_id'";
        $result = mysqli_query($conn, $sql);

        // Etape 7 : Récupérer l'ID du coach est entrer le dans Id_coach de l'athlete
        $sql = "UPDATE base_athlete SET id_coach='$coach_id' WHERE id='$athlete_id'";
        $result = mysqli_query($conn, $sql);

        echo "Coach ajouté avec succès pour l'athlète numéro $athlete_id.";

      } else {
        echo "L'athlète numéro $athlete_id a déjà un coach.";
      }

    } else {
      echo "Le coach n'existe pas dans la base de données.";
    }

} else {
    echo "L'athlète n'existe pas dans la base de données.";
  }

}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Ajouter un coach à un athlète</title>
</head>
<body>

  <h1>Ajouter un coach à un athlète</h1>

  <form method="post" action="">
    <label>Mail du coach :</label>
    <input type="text" name="coach_email" required><br>

    <label>Mail de l'athlète numéro 1 :</label>
    <input type="text" name="athlete_email" required><br>

    <input type="submit" value="Ajouter le coach">
  </form>

</body>
</html>


