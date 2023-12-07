<?php
    $title = "Profil administrateur";
    session_start();  //ouverture de la session
    require_once "config/connectDB.php";
    require_once "communs/header_login.php";

    // On doit s'assurer que user est connecté
    if(isset($_SESSION['id_user'])) {

        // stokage de la session ouverte
        $userID = $_SESSION['id_user'];

        // Recherche en BD l'user qui a l'ID transferé par la session
        $requete = "SELECT * FROM web_cms.utilisateurs 
            WHERE id_user = $userID AND role_user = 'Admin' ";
           
        $result = $connectDB -> query($requete); //$userID = 9
        // Récup de tous les infos de user correspondant a $_SESSION['id_user]
        $infoUser = $result -> fetch(PDO::FETCH_ASSOC); //resultat un tableau

        $nomUser = $infoUser['nom_user'];
        $prenomUser = $infoUser['prenom_user'];
        $pseudo = $infoUser['pseudo'];
        $email = $infoUser['email_user'];
        $photoProfil = $infoUser['photo_user'];
       
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

                                        echo "<a class='btn btn-primary' 
                                                href='modifier_profil.php?modif_userId=".$userID."'
                                            >
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