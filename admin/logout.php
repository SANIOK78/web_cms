<?php 
    // Ouverture de la session
    session_start();

    // S'il y a une session ouverte, 
    // si on est connecté
    if($_SESSION) {
 
        // On detrouill toutes le variable 
        // de la session courante
        session_unset();

        // Destruction de la session elle-même
        session_destroy();

        // Redirection vers "index.php" publique
        header('location: ../index.php');

    } else {   //si pas de session ouverte
        echo "<p style='color:red; font-size:18px'>
                Vous n'êtes pas connecté 
            </p>";
    }
?>