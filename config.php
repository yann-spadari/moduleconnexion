<?php

// ------------------------------------------
// FICHIER CONFIGURATION <<<<<<<<<<<<<<<
// ------------------------------------------

try
{
    
    // Connexion à la base de donnée
    
    $db = new PDO('mysql:host=localhost;dbname=yann-spadari_moduleconnexion;', 'gecks', 'Gecks13013@');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}

catch (Exception $e)

{
        die('Erreur : ' . $e->getMessage());
}

?>
