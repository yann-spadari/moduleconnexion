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

<!--Création du formulaire d'update du profil de l'utilisateur-->


<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Espace Membre</title>
<link rel="stylesheet" href="profil.css">
<link rel="icon" href="favicon.ico" />
</head>
<body>

<!--Import du header -->

<?php include('includes/user_header.php'); ?>


    
    <?php

    // Checker si le compte est présent dans la table

    $check = $db->prepare('SELECT id, login, prenom, nom, password FROM utilisateurs WHERE id= ?');
    $check->execute(array($_SESSION['id']));
    $data = $check->fetch();
    $row = $check->rowCount();

    ?>
    
    <div class="user_profil">
        
        <form action="" method="POST">
          
            <h1 class="profil_text">Espace Membre</h1>
            <h2>Hello <?php echo $_SESSION['login']; ?> !</h2>
            <p class="text-form">Modifier votre profil, c'est facile !</p>
            <p class="text-form2">Changer son mot de passe nécessite une ré-authentification.</p>
            
            <div class= form_group>
            <div id="form_container">
            <input type="text" class="form_input" name="prenom" id="prenom" required="required" autocomplete="off" value=<?php echo $data['prenom']; ?>>
            </div>
            
            <div class="form_container">
            <input type="text" class="form_input" name="nom" id="nom" required="required" autocomplete="off" value=<?php echo $data['nom']; ?>>
            </div>
            
            <div class="form_container">
            <input type="password" class="form_input" name="current_password" id="current_password" placeholder="Mot de passe actuel" required="required" autocomplete="off">
            </div>
            
            <div class="form_container">
            <input type="password" class="form_input" name="password" id="password" placeholder="Nouveau mot de passe" autocomplete="off"; ?>
            </div>

            <div class="form_container">
            <input type="password" class="form_input" name="cpassword" id="cpassword" placeholder="Retapez le mot de passe" autocomplete="off">
            </div>
            
            <div class="form_container">
            <input type="submit" class="btn" name="formsend" id="formsend" value="Sauvegarder">
            </div>    
        </form>
</div>
    </div>

<?php

if(isset($_POST) AND !empty($_POST) ) { 

    // Empêcher les failles XSS

    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $current_password = htmlspecialchars($_POST['current_password']);
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);
    
    // Si le mot de passe actuel est correct

    if (password_verify($current_password, $_SESSION['password'])) { 
        
        if ($_POST['prenom'] !== $data['prenom'] || $_POST['nom'] !== $data['nom']) {

            // Mise à jour des données entrées par l'utilisateur

            $update = $db->prepare("UPDATE utilisateurs SET prenom= ?, nom = ? WHERE id = ?");
            $update->execute(array($_POST['prenom'], $_POST['nom'], $_SESSION['id']));

            // Si mise à jour 'Prénom et Nom' réussie

            // echo '<div class= "success_php">' . "Vos données ont été modifiées." . "</br>" . '</div>';
			
			header("Location:modification.php?=data_saved");
        }

        else {

            // Si les champs sont restés inchangés

            echo '<div class= "err_php">' . "Vos données n'ont pas été modifiées." . "</br>" .'</div>';

        }
    
        // Si l'utilisateur a décidé de changer son mot de passe
            
        if(isset($_POST['password']) && !empty($_POST['password'])) {

            // Si le nouveau mot de passe est différent de l'ancien

            if ($password != $current_password) {

                // Si les deux nouveaux mots de passe entrés sont identiques
    
                if ($password == $cpassword) {

                // Hashage du mot de passe

                $cost = ['cost' => 12];
                $password = password_hash($password, PASSWORD_BCRYPT, $cost);
            

                // Mise à jour du mot de passe entré par l'utilisateur
            
                $update = $db->prepare("UPDATE utilisateurs SET password = :password WHERE id = :id");
                $update->execute(array('password' => $password, 'id' => $_SESSION['id']));

                $password = $_POST['password'];

                // Si mise à jour 'Mot de passe' réussie

                // echo '<div class= "success_php">' . "Votre mot de passe a été modifié." . '</div>';
                
                header('Location: connexion.php?=password_changed');
                die();

                }

                else {

                    // Si les nouveaux mots de passe ne sont pas identiques
        
                    echo '<div class= "err_php">' . "Les mots de passe ne sont pas identiques." . '</div>';


                }

            }

            else {

                
                // Si le nouveau mot de passe est identique au mot de passe actuel
                
                echo '<div class= "err_php">' .  "Le nouveau mot de passe est identique au mot de passe actuel." . '</div>';

            }


        }

        else {

            echo '<div class= "err_php">' . "Votre mot de passe n'a pas été modifié." . '</div>'; 

        }

    }

    else {

    // Si le mot de passe ne correspond pas
    
    echo '<div class= "err_php">' . "Mot de passe incorrect." . '</div>';

    }

}

?>

<!--Import du footer -->

<?php include('includes/footer.php'); ?>

</body>
</html>