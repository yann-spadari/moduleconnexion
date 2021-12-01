<?php

// ---------------------------------------------
// TRAITEMENT DE L'ESPACE MEMBRE <<<<<<<<<<<<<<<
// ---------------------------------------------

// Démarrage de la session

session_start();

// Connexion à la base de donnée

require 'config.php'; 

?>

<?php

// Vérification si l'utilisateur s'est connecté correctement

if (!isset($_SESSION['id']))
{
    header('Location:index.php?connexion_error');

}

?>

<!-- Création de la page de confirmation des modifications effectuées par l'utilisateur -->

<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Travely</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<link rel="stylesheet" href="modification.css">
<link rel="icon" href="favicon.ico" />
</head>
<body>
    
  <!--Import du header -->

  <?php include('includes/user_header.php'); ?>

  <!-- MAIN INDEX -->

  <div class="container">
    
    <div class="text">

      <h2 class="title">Modification réussie !</h2>
      <h3>Vos données ont bien été modifiées.</h3>
      <p>Vous souhaitez faire d'autres modifications ?</p>
      <a href="profil.php">Retour au profil</a>

    </div>
    
  </div>

  <!--Import du footer -->

  <?php include('includes/footer.php'); ?>

</body>
</html>
