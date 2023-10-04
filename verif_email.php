<?php
    // ici on va faire le traitement de la verification de @mail
    /**On va interoger la BD voir si l'@mail et le token transmit 
     * par URL existe dans notre table "utilisateurs" */   
    require_once "config/connectDB.php";

    // verif si on a reçu via URL une @mail et token et s'ils ne sont pas vide
    if (isset($_GET['email']) && !empty($_GET['email']) && 
        isset($_GET['token']) && !empty($_GET['token'])) {
      // Stocage des valeurs transmis depuis form, via URL, dans des variable
        $email = $_GET['email'];
        $token = $_GET['token'];
      // Verif des ces deux valeur avec ce qui a été inseré dans la BD
        $requete = $connectDB -> prepare('SELECT * FROM utilisateurs 
                        WHERE email_user = :email AND token_user = :token') ;               
      // on va lier les valeurs
        $requete -> bindValue(':email', $email); //$email rentré par user
        $requete -> bindValue(':token', $token);
      // Execution de la requette
        $requete -> execute();
      // On va recupérer le nombre des users qui corresponds
        $users = $requete -> rowCount(); 
        
        /*Normalement on devrai avoir qu'un seule correspondance qui a @mail
        et token transmit via url si non ca veut dire qu'il a un probléme  */
        if($users == 1) {    

            // On met a jour notre table "utilisateurs" => on modifie la valeur 
            // du champ "validation_email_user = 1" pour dire que cet user a
            // validé son @email et par la suite sa permettra de filtrer les users
            $update = $connectDB -> prepare('UPDATE utilisateurs 
                    SET validation_email_user = :validEmail, token_user = :token
                    WHERE email_user = :email ');
            
            $update -> bindValue(':email', $email );
            $update -> bindValue(':token', "EmailValide" );
            $update -> bindValue(':validEmail', 1 );

            // execution, resultat on stok dans variable
            $resultUpdate = $update -> execute();

            // Si tous va bien on va envoyer un message personnalisé
            if($resultUpdate) {
                echo "<script>alert('Votre adresse mail a été validé avec succes !');                                      
                        document.location.href='login.php';
                    </script>";
            }
        }
    } 
?>