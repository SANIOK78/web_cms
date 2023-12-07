<?php 
    // Insertion COMMENTAIRE en BD
    function ajouter_commentaireBD(){

        global $connectDB;
        global $message;
        
        //Enregistrement du commentaire en BD. Ce code doit s'executer 
        //seulement si user a cliké sur bouton "Enregistrer".
        if(isset($_POST['add_comment'])) {

            // ET user doit être connecté (avoir une SESSION ouverte) 
            if(isset($_SESSION['id_user'])) {

                //on a besoin de "id_user" pour l'inserer dans la tble "commentaires"
                //pour savoir a qui appartient le commentaire    
                $id_user_comment = $_SESSION['id_user'];
                //On recupère aussi l'id de l'article depuis paramétres URL
                $id_article_comment = $_GET['articleID'];
                //La date d'aujourd'hui
                $date_comment = date("Y-n-d");

                // On va permettre que des caractère alphanumeriques; / sur quelle 
                // variable on veut appliquer le test. "result" qui va verifier
                // s'il y a d'autre caractère apars ceux  precisées dans le "regex"
                preg_match("/(^[A-Za-z0-9]\s)/", $_POST['contenu_comment'], $result);

                // test si champ "comment" est vide OU si "$result" NonVide, donc la
                // presence d'autre caractère que ceux alfanumerique de 'regex'
                if(empty($_POST['contenu_comment']) || !empty($result)) {
                    $message = "<br><p style= 'color:red;'>
                        Le contenu du commentaire doit être un chaine de caractère alphanumerique !!! </p>";
                   
                } else {
                    // Insertion commentaire en BD
                    $reqComment = $connectDB->prepare('INSERT INTO web_cms.commentaires(
                        contenu_comment, date_comment, id_article, id_user) 
                        VALUES(:contenu_comment, :date_comment, :id_article, :id_user) ');
                    
                    //On va lier les champs
                    $reqComment -> bindValue(':contenu_comment', $_POST['contenu_comment']);
                    $reqComment -> bindValue(':date_comment', $date_comment);
                    $reqComment -> bindValue(':id_article', $id_article_comment);
                    $reqComment -> bindValue(':id_user', $id_user_comment);
                  // execution
                    $resultComment = $reqComment->execute();
                  // Test si tous va bien
                    if(!$resultComment) {
                        $message = "<br><p style='color:red;'>L'ajout du commentaire a échoué !!!</p>";                
                    } else {
                        $message = "<br><p style='color:green;'>Commentaire enregistré avec succes !!!</p>";
                    }
                }

            } else {
                $message = "<br><p style= 'color:red;'>
                        Vous devez être connecté pour pouvoir laisser un commentaire !!!</p>";                    
            }                   
        } 
    }