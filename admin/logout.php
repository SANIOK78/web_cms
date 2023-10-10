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

        // Redirection vers la page "index.php"
        header('location: index.php');

    } else {   //si pas de session ouverte
        echo "<p class='text-danger p-2''>Vous n'êtes pas connecté </p>";
    }

?>