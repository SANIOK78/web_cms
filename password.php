<?php
    require_once "config/connectDB.php";

    // reinitialisation du mot de passe
    // Vérif si user a clické sur bouton "Réinitialise le mot de passe"
    if(isset($_POST['forget_pwd'])) {
        // si le champ est vide et si ce n'est pas au bon format
        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message = "Rentrez un adresse email valide !";
        } else {  //si @mail format valide
            $email = htmlspecialchars($_POST['email']);  
          // Interogation de la BD si @mail enregistré
            $requete = $connectDB -> prepare('SELECT * FROM utilisateurs WHERE email_user = :email');                   
          // La liaison des info
            $requete -> bindValue(':email', $email);
          // Execution de la requete
            $requete -> execute();
          // Recup de resultat sous forme tableau
            $result = $requete -> fetch();
          // Nombre d'enregistrements récupéré => 1
            $nombre = $requete -> rowCount();

            if($nombre == 0 ) {
                $message = "Aucun membre enregistré avec cette @email !";

            } else {   // adresse valide
                // On va vérifier si cette @mail a été déjà validé (validation_emai_user = 1)
                if($result['validation_email_user'] != 1) {  //si @mail pas validé

                    require_once "config/token.php"; // On génér un token

                    // Mise a jour du token de notre table "utilisateur"
                    $updateToken = $connectDB -> prepare('UPDATE utilisateurs SET token_user =:token 
                                                        WHERE email_user = :email');
                    $updateToken -> bindValue(':token', $token);
                    $updateToken -> bindValue(':email', $email);

                    $updateToken ->execute();  //on remplace l'ancien token par le nouveau

                    // Envoi du mail avec un lien permettant de confirmer l'@email
                    require_once "envois_email.php";

                } else {  // @email valide => envois mail/lien permettant de réinitialiser MdP

                    require_once "config/token.php"; // On génér un token aleatoir
                  // Mise a jour du token de notre table "utilisateur"
                    $updateToken = $connectDB -> prepare('UPDATE utilisateurs SET token_user =:token
                                                        WHERE email_user = :email');
                    $updateToken -> bindValue(':token', $token);
                    $updateToken -> bindValue(':email', $email);

                    $updateToken ->execute();  //on remplace l'ancien token par le nouveau

                    // Envoi du mail avec un lien permettant de réinitialiser le mot de passe
                    require_once "mail_reinit_mdp.php";
                }
            }           
        }
    }
?>

<?php require_once "communs/header_password.php"; ?>

<body class="bg-info">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">

                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Réinitialisez le mot de passe</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">
                                            <p> 
                                                Entrez votre adresse email et nous vous enverrons un lien pour 
                                                réinitialiser votre mot de passe.
                                            </p>
                                        </div>

                                        <form action="password.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input type="email" name="email" class="form-control" id="email" />
                                                <label for="email">Email</label>
                                            </div>

                                            <?php if(isset($message)) {echo "<p class='text-danger'>".$message."</p>" ; } ?>

                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="btn btn-info"  href="login.php">Connexion</a>

                                                <input type="submit" name="forget_pwd" class="btn btn-primary" 
                                                    value="Envoyer" 
                                                >
                                            </div>
                                           
                                        </form>
                                    </div>

                                    <div class="card-footer text-center py-3">
                                        <!-- <div class="small"> -->
                                            <a href="register.php">Pas de compte ? Créez un compte !</a>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

<?php require_once "communs/footer.php" ; ?>
