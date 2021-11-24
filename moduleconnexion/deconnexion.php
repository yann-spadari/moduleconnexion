<?php 
    
// Démarrage de la session
    
session_start();
    
// Destruction de la session
        
session_destroy(); // on détruit la/les session(s), soit si vous utilisez une autre session, utilisez de préférence le unset()
    
// Redirection vers la page de connexion

header('Location:index.php');

die();

?>