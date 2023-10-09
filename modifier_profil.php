<?php
    session_start();
    $title = "Modifier votre profil";
    // Importation code "header-register"
    require_once "communs/header_login.php";
    require_once "config/connectDB.php";

    // Vérif s'il y un transfert du paramétre "modif_userId"
    // Et si ce membre est toujours connecté
    if(isset($_GET['modif_userId']) && $_SESSION['id_user'] && 
        $_GET['modif_userId'] == $_SESSION['id_user']) {
        
        $userId = $_SESSION['id_user'];

        // Récupération des infos depuis BD
        $requete = "SELECT * FROM web_cms.utilisateurs WHERE id_user = $userId " ;
        $result = $connectDB -> query($requete);

        // Récup resultat sous forme d'un tableau
        $infosUser = $result -> fetch(PDO::FETCH_ASSOC);

        //On va stoker les infos dans des variables
        $nomUser = $infosUser['nom_user'];
        $prenomUser = $infosUser['prenom_user'];
        $pseudo = $infosUser['pseudo'];
        $photoProfil = $infosUser['photo_user'];   
        
        // Logique pour mettre a jour le compte
        if(isset($_POST['modif_profil'])) {

            // On dois s'assurer que les champs ne sont pas vide
            // et qu'ils contient le bon type de valeur
            if(empty($_POST['prenom']) || !ctype_alpha($_POST['prenom'])) {
                $message = 'Votre prenom doit être une chaine de caractère alphabetique !';

            } elseif(empty($_POST['nom']) || !ctype_alpha( $_POST['nom'])) {
                $message = 'Votre nom doit être une chaine de caractère alphabetique !';

            } elseif(empty($_POST['pseudo']) || !ctype_alnum( $_POST['pseudo'])) {
                $message = 'Votre pseudo doit être une chaine de caractère alphanumerique !';
    
            } else {   //tous les champs sont correctement remplis

                // On va S'assurer qu'il n'y a pas déjà le même "pseudo" 
                // en BD, qui doit être unique 
                $reqPseudo = $connectDB->prepare('SELECT * FROM utilisateurs WHERE pseudo = :pseudo');
                // On fait la liaison du paramétre nomé avec "pseudo" saisi par l'utilisateur
                $reqPseudo -> bindValue(":pseudo", $_POST['pseudo']);
                // execution de la requete
                $reqPseudo -> execute();
                // On stock le resultat dans un tableau
                $resultPseudo = $reqPseudo -> fetch(); 

                if($resultPseudo) {
                    $message = "Ce pseudo est déjà pris, choisissez un autre.";

                } else {   
                    $updateProfil = $connectDB -> prepare("UPDATE web_cms.utilisateurs 
                        SET nom_user=:nom, prenom_user=:prenom, pseudo=:pseudo, photo_user=:photoProfil
                        WHERE id_user = :userID ");
                    
                    $updateProfil -> bindValue(':userID', $userId);
                    $updateProfil -> bindValue(':nom', $_POST['nom'] );
                    $updateProfil-> bindValue(':prenom', $_POST['prenom'] );
                    $updateProfil -> bindValue(':pseudo', $_POST['pseudo']);

                    // On va voir si l'utilisateur a choisit une nouvelle photo
                    if(empty($_FILES['photo_profil']['name'])) {   //si pas de photo profil

                        // On garde l'ancien photo
                        $updateProfil -> bindValue(':photoProfil', $photoProfil);

                    } else {  //si user a choisi une nouvelle photo
                        //1. Suppresion de l'ancienne photo:
                        $ancienneImg = "images/photos_profil/".$photoProfil; // Chemin de l'ancienne photo
                        if(file_exists($ancienneImg)) { 
                            unlink($ancienneImg);      // Supprimer l'ancienne image
                        }
                        // 2. On rajoute la nouvelle photo
                        //  vérif si elle correspond au type : .jpeg, .jpg, .png        
                        if(preg_match("#jpeg|png|jpg#", $_FILES['photo_profil']['type'])){

                            // Astuce pour avoir une photo avec un nom unique
                            $newPhotoProfil = uniqid()."-".$_FILES['photo_profil']['name'];
        
                            // On precise le chemin ou on va stoquer les photo de profil
                            $path = 'images/photos_profil/';
        
                            // ensuite on deplace la photo depuis l'espace temporaire de stockage vers le 
                            //dossier definitif de stockage ("chaimen"."nouveauNomAttribué")
                            move_uploaded_file($_FILES['photo_profil']['tmp_name'], $path.$newPhotoProfil );
        
                        } else {  //si le fichier ne respecte pas les conditions
                            $message = 'La photo doit être de type: jpeg, png, jpg';
                        }
                        
                        // enregistrement du photo en BD
                        $updateProfil -> bindValue(':photoProfil', $newPhotoProfil );
                    }

                    $resultUpdate = $updateProfil -> execute();

                    if($resultUpdate) {
                        header('location: profilUser.php');

                    } else {
                        $message = "Votre profil n'a pas été modifié"; 
                    }
                }
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
                                    <h3 class="text-center text-primary my-4">Modifier mon profil </h3>                                                        
                                </div>
                                <div class="card-body">

                                    <form action="" method="post" enctype="multipart/form-data">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input type="text" name="prenom" class="form-control" 
                                                        id="prenom" value="<?= $prenomUser; ?>"
                                                    />
                                                    <label for="prenom">Prénom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="nom" class="form-control" 
                                                        id="nom" value="<?= $nomUser; ?>"
                                                    />
                                                    <label for="inputnomLastName">Nom</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input type="text" name="pseudo" class="form-control" 
                                                        id="pseudo"  value="<?= $pseudo ; ?>"
                                                    />
                                                    <label for="pseudo">Pseudo</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <?php 
                                                    echo "<img width=30 class='media-object' 
                                                        src='images/photos_profil/$photoProfil' 
                                                        alt='photo de profil'
                                                    />";
                                                ?>
                                                <label for="photo">Photo de profil</label>
                                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" id="photo"  />
                                                <input type="file" name="photo_profil" id="photo"  />
                                            </div>
                                           
                                        </div>
                                        
                                        <?php if(isset($message)) echo "<p class='text-danger'>".$message."</p>" ;?>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" value="Modifier mon profil" name="modif_profil" 
                                                    class="btn btn-success btn-block"
                                                >
                                            </div>
                                        </div> 

                                    </form>                                    
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
