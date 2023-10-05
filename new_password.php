<?php require_once "communs/header_password.php"; ?>
<?php 
    // TRAITEMENT DE "REINITIALISATION DU MOT DE PASSE"

    // Vérif si token et @mail transmit via URL et pas vide
    if(isset($_GET['token']) && !empty($_GET['token']) && 
        isset($_GET['email']) && !empty($_GET['email'])) {

        //Récup et stokage des valeur 
        $email = htmlspecialchars($_GET['email']);
        $token = htmlspecialchars($_GET['token']);

        // On va interoger la BD s'il existe un membre avec cette  
        // @mail et qu'il est attaché au token récupéré
        require_once "config/connectDB.php";
        $requete = $connectDB -> prepare('SELECT * FROM web_cms.utilisateurs 
                WHERE email_user = :email AND token_user = :token');

        $requete -> bindValue(':email', $email);
        $requete -> bindValue(':token', $token);

        $requete -> execute();  //Execution de la requete
        $nombre = $requete -> rowCount();  //Pour avoir le Nb d'enregistrements
        
        if($nombre != 1) {   //si "$nombre !=1" il y a une problème
            header('location: login.php');

        } else {  //si nb de resultat = 1 (donc OK)

            // On declanche ce code seulement si user clic sur btn "Valider"
            if (isset($_POST['nouveau_mdp'])){ 

                // Si MDP vide et que les deux MDP corresponds pas
                if(empty($_POST['password']) || ($_POST['password'] != $_POST['confirm_mdp'])) {

                    $message = "Mots de passe absents ou ne corresponds pas ! ";

                } else {   //les 2 mot de passe corresponds 

                    // Hachage de MDP
                    $pwdHashe = password_hash($_POST['password'], PASSWORD_DEFAULT);

                    // insertion en BD
                    $reqPwd = $connectDB -> prepare('UPDATE utilisateurs 
                            SET password_user = :motdepasse WHERE email_user = :email') ;
                    
                    $reqPwd -> bindValue(':motdepasse', $pwdHashe);  //password haché
                    $reqPwd -> bindValue(':email', $email );

                    $result = $reqPwd -> execute(); //On stoc le resultat

                    if($result ) {  //si la requete s'execute avec succes
                        echo "<script type='text/javascript'>
                                alert('Votre mot de passe a été réinitialisé avec succes :-)');
                                document.location.href='login.php';
                            </script>";

                    } else { // si probleme => redirection au debut de processus de réinitialisation
                        header('location: password.php');
                    }
                }
            }
        }
    } else {  // pas de email et token récu via URL => rédirection 
        header('location: password.php');
    }
?>

<body class="bg-info">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">

                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">
                                            Réinitialisez votre mot de passe
                                        </h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h5 class="text-primary"> 
                                               Veillez choisir votre nouveau mot de passe.
                                            </h5>
                                        </div>

                                        <form action="#" method="post">

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input name="password" type="password" class="form-control" id="pwd" />
                                                        <label for="pwd">Mot de passe</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input name="confirm_mdp" type="password" class="form-control" id="mdpConfirm" />
                                                        <label for="mdpConfirm">Confirmer Mot de passe</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-1">
                                                <a class="btn btn-info"  href="login.php">Connexion</a>

                                                <input type="submit" name="nouveau_mdp" class="btn btn-primary" value="Confirmer">                                                                                                                                            
                                            </div>
                                           
                                        </form>

                                        <?php if(isset($message)) {echo "<p class='text-danger'>".$message."</p>" ;} ?>
                                    </div>                               
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

<?php require_once "communs/footer.php" ; ?>
