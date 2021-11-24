<?php

// ----------------------------
// ESPACE ADMIN <<<<<<<<<<<<<<<
// ----------------------------

// Démarrage de la session

session_start();

// Connexion à la base de donnée

require 'config.php'; 

?>

<?php

// Récupération des données de tous les utilisateurs

$req = $db->prepare('SELECT * FROM utilisateurs ORDER BY id ASC');
$req->execute(array());

?>

<?php

// Vérification si l'utilisateur s'est connecté correctement

if (!isset($_SESSION['id']))
{
    header('Location:index.php?connexion_error');

}

?>

<!--Création du tableau -->

<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Espace Admin</title>
<link rel="stylesheet" href="./admin_panel.css">
</head>

<body>
  
  <!--Import du header -->

  <?php include('includes/admin_header.php'); ?>

<section>
  <h1>Liste des utilisateurs</h1>
  
  <div class="tbl-header">
    <table>
      <thead>
        
        <tr>
          <th>Id</th>
          <th>Nom d'utilisateur</th>
          <th>Prénom</th>
          <th>Nom</th>
        </tr>
    
      </thead>
    </table>
  </div>
    
    
  <div class="tbl-content">
    <table>
      <tbody>
        
        <?php while($data = $req->fetch(PDO::FETCH_ASSOC)) : ?>
        
        <tr>
          <td><?php echo htmlspecialchars($data['id']); ?></td>
          <td><?php echo htmlspecialchars($data['login']); ?></td>
          <td><?php echo htmlspecialchars($data['prenom']); ?></td>
          <td><?php echo htmlspecialchars($data['nom']); ?></td>
        </tr>
        
        <?php endwhile; ?>
      
      </tbody>
    </table>
  </div>
</section>

<!--Import du footer -->

<?php include('includes/footer.php'); ?>


</body>
