<?php
    // Importation code "header-register"
    require_once "communs/header_register.php";
?>

<?php 
    // traitement données utilisateur
    if(isset($_POST['inscription'])) {   //si user a cliqué sur bouton 'inscription'
        // Si le champ est vide OU que user a saisi autre caracter que "string"
        if(empty($_POST['prenom']) || !ctype_alpha($_POST['prenom'])) {
            $message = 'Votre prenom doit être une chaine de caractère alphabetique !';

        } elseif(empty($_POST['nom']) || !ctype_alpha( $_POST['nom'])) {
            $message = 'Votre nom doit être une chaine de caractère alphabetique !';

        }  elseif(empty($_POST['pseudo']) || !ctype_alnum( $_POST['pseudo'])) {
            $message = 'Votre pseudo doit être une chaine de caractère alphanumerique !';

        } elseif(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message = 'Format email invalide !';

        } elseif(empty($_POST['password']) || $_POST['password'] != $_POST['confirm_mdp']) {
            $message = 'Rentrez un mot de passe valide !';

        } else {
            // RECUPERATION DE LA CONNEXION   
            require_once "config/connectDB.php";

            // Rquête preparé = Récupération des données depuis la BD:
            $reqPseudo = $connectDB->prepare('SELECT * FROM utilisateurs WHERE pseudo = :pseudo');
            // On fait la liaison du paramétre nomé avec "pseudo" saisi par l'utilisateur
            $reqPseudo -> bindValue(":pseudo", $_POST['pseudo']);
            // execution de la requete
            $reqPseudo -> execute();
            // On stock le resultat dans un tableau
            $resultPseudo = $reqPseudo -> fetch();

            $reqEmail = $connectDB->prepare('SELECT * FROM utilisateurs WHERE email_user = :email');
            // On fait la liaison du paramétre nomé avec "email" saisi par l'utilisateur
            $reqEmail -> bindValue(":email", $_POST['email']);
            // execution de la requete
            $reqEmail -> execute();
            // On stock le resultat dans un tableau
            $resultEmail = $reqEmail -> fetch();

            // Si on a déjà le même "pseudo" enregistré dans la BD
            if($resultPseudo) {
                $message ="Ce pseudo est déjà pris, choisissez un autre.";

            } elseif($resultEmail) {  // Si même "@email" enregistré dans la BD
                $message ="Un compte est déjà attaché a cet email.";

            } else {
                // INSERTION DE INFOS RECUPERES DEPUIS LE FORM DANS DE BD:

                // Importation function "tokenAleaString($len)
                require_once "config/token.php";

                // Hachage du "mot de passe" rentré par utilisateur
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // Rquête preparé = 
                $requete = $connectDB -> prepare('INSERT 
                    INTO utilisateurs(nom_user, prenom_user, email_user, password_user, pseudo, token_user, photo_user)
                    VALUES (:nom, :prenom, :email, :motpasse, :pseudo, :token, :photo_profil)
                ');
                $requete -> bindValue(':nom', $_POST['nom']);
                $requete -> bindValue(':prenom', $_POST['prenom']);
                $requete -> bindValue(':email', $_POST['email']);
                $requete -> bindValue(':motpasse', $password);  //ici le mot de passe cripté
                $requete -> bindValue(':pseudo', $_POST['pseudo']);
                $requete -> bindValue(':token', $token);
    
                // Enregistrement de la photo de profil
                if(empty($_FILES['photo_profil']['name'])) {   //si user n'a pas choisit une foto
                    $photo_profil_avatar = 'avatar_defaut.png';    //on met une avatar par defaut
                    $requete -> bindValue(':photo_profil', $photo_profil_avatar);  //enregistrement en BD
    
                } else {   //si user a choisi une photo
                    // la "photo de profil" apres avoir vérifié si elle correspond au exigences .jpeg, .jpg        
                    if(preg_match("#jpeg|png|jpg#", $_FILES['photo_profil']['type'])){

                        // Astuce pour avoir une photo avec un nom unique
                        $newPhotoProfil = date('His')."_".$_FILES['photo_profil']['name'];
    
                        // On precise le chemin ou on va stoquer les photo de profil
                        $path = 'images/photos_profil/';
    
                        // ensuite on deplace la photo depuis l'espace temporaire de stockage vers le 
                        //dossier definitif de stockage ("chaimen"."nouveauNomAttribué")
                        move_uploaded_file($_FILES['photo_profil']['tmp_name'], $path.$newPhotoProfil );
    
                    } else {  //si le fichier ne respecte pas les conditions
                        $message = 'La photo doit être de type: jpeg, png, jpg';
                    }
                    
                    // enregistrement du photo en BD
                    $requete -> bindValue(':photo_profil', $newPhotoProfil );
                } 

                // execution de la requette pour inserer dans la BD les infos entré par user
                $requete -> execute(); 

                // On include le fichier d'envoi de mail de confirmation
                require_once "envois_email.php";
            }
        }       
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
                                    <h2 class="text-center font-weight-light my-4">Inscription </h2>                                                        
                                </div>

                                <div class="card-body">

                                    <form action="register.php" method="post" enctype="multipart/form-data">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="prenom" class="form-control" id="inputFirstName" type="text" />
                                                    <label for="inputFirstName">Prénom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input name="nom" class="form-control" id="inputLastName" type="text" />
                                                    <label for="inputLastName">Nom</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="pseudo" class="form-control" id="pseudo" type="text" />
                                                    <label for="pseudo">Pseudo</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="email" class="form-control" id="inputEmail" type="email" />
                                                    <label for="inputEmail">Email</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="password" class="form-control" id="inputPassword" type="password" />
                                                    <label for="inputPassword">Mot de passe</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="confirm_mdp" class="form-control" id="mdpConfirm" type="password" />
                                                    <label for="mdpConfirm">Confirmer Mot de passe</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                          
                                            <div class="col-md-6">
                                                <label for="photo">Photo de profil</label>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" id="photo"  />
                                                <input type="file" name="photo_profil" id="photo"  />
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" name="inscription" 
                                                    class="btn btn-success btn-block" 
                                                    value="Créer votre compte"
                                                >
                                            </div>
                                        </div>
                                        
                                    </form>                                    
                                </div>

                                <!-- Affichage du message d'erreur -->
                                <?php 
                                    if (isset($message)) echo "<p class='text-danger p-1'>".$message."</p>";
                                ?>

                                <div class="card-footer text-center py-3">
                                    <!-- <div class="small"> -->
                                        <a href="login.php">
                                            Vous avez un compte ? Connectez-vous !
                                        </a>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>



<?php
    // Importation "footer.php"
    require_once "communs/footer.php";
?>
