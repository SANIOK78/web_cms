<?php 
    require_once "config/connectDB.php";

    // si user clik sur btn "se connecter"
    if(isset($_POST['connexion'])) {

        // verif si tous les champs sont renseignés
        if(!empty($_POST['email']) && !empty($_POST['password']) ) {

            // stokage valeurs
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            // verif en BD si on trouve un USER avec cette @mail
            $requete = $connectDB -> prepare('SELECT * FROM utilisateurs WHERE email_user = :email ');
            // execution de la requete sous forme de tableau 
            $requete -> execute(array('email'=> $email)); 
            
            $result = $requete -> fetch();  //fetch() => recup de tous les information 

            // Verif si on a une correspondance trouvé :
            if( !$result ) {     //pas de correspondances

                $message ="Utilisateur avec cette @mail introuvable...";  

            } else if ($result['validation_email_user'] == 0 ) {  //test si @email validé 
                
                // ENVOI D'UN MAIL avec lien pour valider son @email:
                // 1.Géneration d'un token aleatoir
                require_once "config/token.php";

                // 2.Mise a jour du token déjà existant
                $updateToken = $connectDB -> prepare('UPDATE utilisateurs SET token_user = :token WHERE email_user = :email ' );

                // 2.1 lieson des valeurs
                $updateToken -> bindValue(':token', $token);  //$token généré par "config/token.php"
                $updateToken -> bindValue(':email', $_POST['email'] );   //email recup depuis form connexion

                // 2.2 execution de la requete: mise a jour du token existant par le nouveua token généré "config/token.php"
                $updateToken -> execute();

                // 3. On envois le mail pour confirmer @email
                require_once "envois_email.php";

            } else {    //si email existe en BD et si @email validé ("validation_email_user == 1") 
                // On va comparer le Mot de passe rentré par user depuis form et celui de BD
                $pwdIsOk = password_verify($_POST['password'], $result['password_user']);   //"password_verify()" = boolean

                // Si tous correspond on va créer une SESSION
                if($pwdIsOk) {

                    session_start();

                    $_SESSION['id_user'] = $result['id_user'];
                    $_SESSION['pseudo'] = $result['pseudo'];
                    $_SESSION['email_user'] = $email;
                    $_SESSION['role_user'] = $result['role_user'];

                    // On va créer un coockis pour functionnalité "Se souvenir de moi"
                    // Si la case "Se souvenir de moi" est coché
                    if(isset($_POST['sesouvenir'])) {
                        setcookie("email", $_POST['email'], time()+3600 *24 * 365);   //date presente + une année(en sec)
                        setcookie("password", $_POST['password'], time()+3600 *24 * 365); 

                    } else {   // Si la case "Se souvenir de moi" n'est pas coché
                        if(isset($_COOKIE['email'])) {   //s'il existe déjà une coockis "email"
                            setcookie($_COOKIE['email'], "");   //on leur attribue une valeur null
                        }

                        if(isset($_COOKIE['password'])) {          //s'il existe déjà une coockis "password"
                            setcookie($_COOKIE['password'], "");   //on leur attribue une valeur null
                        }
                    }

                    // redirection
                    header('location: index.php');

                } else {
                    $message = "Mote de passe incorrect...";
                }
            }

        } else {
            $message = "Renseignez tous les champs";
        }
    } 
?>

<?php require_once "communs/header_login.php"; ?>  
    
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Connexion</h3>
                                </div>
                                <div class="card-body">

                                    <?php if(isset($message)){ echo "<p class='text-danger p-2'>".$message."</p>"; } ?> 
                                            
                                    <form action="login.php" method="post">

                                        <div class="form-floating mb-3">
                                            <input type="email" name="email"  class="form-control" id="email"
                                                value=<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email']; ?>
                                            >
                                            <label for="inputEmail">Email</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" name="password" class="form-control" id="pwd"
                                            value=<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>
                                            >
                                            <label for="pwd">Mot de passe</label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="pwdOblie" type="checkbox" name="sesouvenir" value="" />
                                            <label class="form-check-label" for="pwdOblie">Se souvenir de moi</label>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.php">Mot de passe oublié?</a>
                                            <input type="submit" name="connexion" class="btn btn-primary" value="Se connecter">
                                        </div>

                                    </form>                                   
                                </div>

                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        <a href="register.php">Pas de compte? Créer votre compte!</a>
                                    </div>
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

