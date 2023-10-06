<?php
    session_start();  //ouverture de la session
    require_once "config/connectDB.php";
    require_once "communs/header_login.php";

    // On doit s'assurer que user est connecté
    if(isset($_SESSION['id_user'])) {

        // stokage de la session ouverte
        $userID = $_SESSION['id_user'];

        // Recherche en BD l'user qui a l'ID transferé par la session
        $requete = "SELECT * FROM web_cms.utilisateurs WHERE id_user = $userID";
           
        $result = $connectDB -> query($requete); //$userID = 9
        // Récup de tous les infos de user correspondant a $_SESSION['id_user]
        $infoUser = $result -> fetch(PDO::FETCH_ASSOC); //resultat un tableau

        $nomUser = $infoUser['nom_user'];
        $prenomUser = $infoUser['prenom_user'];
        $pseudo = $infoUser['pseudo'];
        $email = $infoUser['email_user'];
        $photoProfil = $infoUser['photo_user'];

        // Logique pour supprimer un compte
        if(isset($_POST['valider_supprim_compte'])) {

            $requete = $connectDB ->prepare('DELETE FROM web_cms.utilisateurs WHERE id_user = :userId');
            $requete -> bindValue(':userId', $userID);
    
            // execution de la suppression dans la BD
            $result = $requete -> execute();
    
            if($result) {  //Si membre supprimé en BD on doit aussi detruire sa SESSION
                if($_SESSION) {   //si il y a une session en cour
                    session_unset();   // suppression de tous les variable de session
                    session_destroy();   //uppression de la session
                }
    
                header('location: index.php'); 
            } else {
                $message = "Votre compte n'a pas été supprimé !";
            }
        }

    } else {

        echo "<script type='text/javascript'>
            alert('Vous devez être connecté pour acceder a votre profil');
            document.location.href = 'login.php';
        </script>";
    }
?>

<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">            
            <main class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center text-primary my-4">
                                    Bienvenue <b><?php if(isset($pseudo)) echo $pseudo; ?></b>
                                </h3>

                                <div>
                                    <?php 
                                        //Pour supprimer le compte on doit tester si on recoit un paramétre contenant
                                        // l'ID user et si il a une sesion ouvetre ET si les deux ID identiques
                                        if(isset($_GET['supprim_userId']) && $_SESSION['id_user'] && 
                                        $_GET['supprim_userId'] == $_SESSION['id_user']) {

                                            echo "<p class='text-danger'>Votre compte sera supprimé ! Vous confirmer ?</p>";
                                            echo "<form action='#' method='post'>
                                                    <div class='d-grid'>
                                                        <input type='submit' 
                                                            class='btn btn-danger btn-block'  
                                                            value='Oui, supprimer mon compte'
                                                            name='valider_supprim_compte'
                                                        >
                                                    </div>
                                                </form>";
                                        }
                                    ?>
                                </div>

                            </div>                        
                            <div class="card-body d-flex align-items-center justify-content-between my-4"> 
                                <div>
                                    <p><?php if(isset($nomUser)) echo "<b>Nom : </b>".$nomUser ; ?></p>
                                    <p><?php if(isset($prenomUser)) echo "<b>Prénom : </b>".$prenomUser ; ?></p>
                                    <p><?php if(isset($email)) echo "<b>Email : </b>".$email ; ?></p>                                        
                                </div> 

                                <div>
                                    <?php 
                                        if(isset($photoProfil)){
                                            echo "<center>
                                                <img width=160 class='media-object rounded' 
                                                    src='images/photos_profil/".$photoProfil."' 
                                                    alt='photo profil' 
                                                />
                                            </center>"; 
                                        } 
                                    ?>  
                                </div>                                                                                            
                            </div>

                            <div class="card-footer d-flex align-items-center justify-content-between p-3">
                                <?php 
                                    if(isset($userID)) {

                                        echo "<a class='btn btn-danger' href='profilUser.php?supprim_userId=".$userID."'>
                                                Supprimer mon compte
                                            </a>";

                                        echo "<a class='btn btn-primary' href='modifier_profil.php?modif_userId=".$userID."'>
                                                Modifier mon compte
                                            </a>";
                                    } 
                                ?>                                
                            </div>
                        </div>
                    </div>    
                </div>
            </main>
        </div>

<?php require_once "communs/footer.php"; ?>