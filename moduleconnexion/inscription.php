<?php

// -------------------------------------------
// TRAITEMENT DE L'INSCRIPTION <<<<<<<<<<<<<<<
// -------------------------------------------

// Connexion à la base de donnée

require 'config.php';

?>

<!--Création du formulaire d'inscription-->


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="inscription.css">
</head>
<body>

<!--Import du header -->

<?php include('includes/main_header.php'); ?>

<div class="user_register">
    
    <form class="register_form" action="" method="POST">
        
      <h1 class="register_text">Inscription</h1>
      
      <div class="form_container">
      <input type="text" class="form_input" name="login" id="login" placeholder="Nom d'utilisateur" required="required" autocomplete="off">
      </div>
      
      <div class="form_container">
      <input type="text" class="form_input" name="prenom" id="prenom" placeholder="Prénom" required="required" autocomplete="off">
      </div>
      
      <div class="form_container">
      <input type="text" class="form_input" name="nom" id="nom" placeholder="Nom de famille" required="required" autocomplete="off">
      </div>
      
      <div class="form_container">
      <input type="password" class="form_input" name="password" id="password" placeholder="Nouveau mot de passe" required="required" autocomplete="off">
      </div>
      
      <div class="form_container">
      <input type="password" class="form_input" name="cpassword" id="cpassword" placeholder="Retapez le mot de passe" required="required" autocomplete="off">
      </div>
      
      <div class="form_container">
      <input type="submit" class="btn" name="formsend" id="formsend" value="S'inscrire">
      </div>    
    
    </form>

</div>

<?php

// Vérification si le formulaire a été envoyé

if(isset($_POST) AND !empty($_POST) ) {

  // Empêcher les failles XSS

  $login = htmlspecialchars($_POST['login']);
  $prenom = htmlspecialchars($_POST['prenom']);
  $nom = htmlspecialchars($_POST['nom']);

  // Checker si le compte existe

  $check = $db->prepare('SELECT login, prenom, nom, password FROM utilisateurs WHERE login = ?');
  $check->execute(array($login));
  $data = $check->fetch();
  $row = $check->rowCount();

  // Si le compte n'existe pas

  if ($row == 0) {

    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);

    // Si les deux mots de passe sont identiques
  
    if ($password == $cpassword) {

    // Hashage du mot de passe

    $cost= ['cost' => 12];
    $password = password_hash($password, PASSWORD_BCRYPT, $cost);

    // Insertion des données entrées par l'utilisateur dans la table

    $insert = $db->prepare ('INSERT INTO utilisateurs(login, prenom, nom, password) VALUES (:login, :prenom, :nom, :password)');
    $insert->execute(array('login' => $login, 'prenom' => $prenom, 'nom' => $nom, 'password' => $password));

    // Si inscription réussie

    $_SESSION['id'] = $data['id'];

    echo '<div class= "success_php">' ."L'inscription a été effectué avec succès." . '</br>' . "Vous pouvez vous connecter " . '<a style= "color: #337BD4" href="connexion.php">' . "ici" . '</a>' . '</div>';
    // header('Location:connexion.php' . $_SESSION['id']);
    

    }

    else {

      // Si les mots de passes ne correspondent pas

      echo '<div class= "err_php">' ."Les mots de passe ne sont pas identiques." . '</div>';

    }

  }

  else {

    // Si le login entré par l'utilisateur existe déjà dans la base de donnée
    
    echo '<div class= "err_php">' ."Le nom d'utilisateur est déjà utilisé." . '</div>';

  }

}

?>

<!--Import du footer -->

<?php include('includes/footer.php'); ?>


</body>
</html>
