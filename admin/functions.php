<?php

//Enregistrement d'une nouvelle categorie 
function saveNewCategorie() {

    global $connectDB;  //variable globales qui seront utilisés
    global $message;     //en dehors de la function

    // On va accepter que des caractère "alphanumerique"
    // 1.ce qu'on accept, 2.la saissie d'user, 3.s'il y a d'autre caractéres
    preg_match("/([^A-Za-z0-9'éèà^\s])/", $_POST['nom_categirie'], $result );  //on accept les espace( \s )

    // si le champs pas vide OU si $result pas vide
    if(empty($_POST["nom_categirie"]) || !empty($result) ) {
        $message = "<p class='text-danger py-2'>Catégorie requise avec chaine alphanumérique 
                (pas de caractères spéciaux)
            </p>";

    } else {  // champs "nom_categirie" et $result pas vide
        // On va enregistrer la categorie en BD
        $reqCategorie = $connectDB -> prepare('INSERT INTO web_cms.categories(nom_categorie)
                                    VALUES (:nom_categorie)' );

        $reqCategorie -> bindValue(':nom_categorie', $_POST['nom_categirie']);

        // Execution de la requete
        $result = $reqCategorie -> execute();

        if( !$result) {
            $message = "<p class='text-danger py-2'>Une problème est survenu, catégorie pas enregistré !</p>";

        } else {
            $message = "<p class='text-success py-2'>Catégorie enregistré avec succès !</p>";
        }
    }
}

// Suppression d'une categorie
function supprimerCategorie() {

    global $connectDB;  //variable globales qui seront utilisés
    global $msgSuppr;     //en dehors de la function
    
    $idCategorie = $_GET['supprimCategorie'];

    // on recherche en BD la correspondance
    $reqSuprim = "DELETE FROM web_cms.categories WHERE id_categorie = '$idCategorie' ";

    // Execution de la requete
    $resultSupprim = $connectDB -> exec($reqSuprim);

    if(!$resultSupprim ) {
        $msgSuppr = "<p class='text-danger'>Suppression de la catégorie echoué </p>";

    } else {
        $msgSuppr = "<p class='text-success'>Suppression de la catégorie effectué avec succès</p>";
    }
}

// Affichage de toutes les categorie
function afficherCategories() {

    //variable globales qui seront utilisés en dehors de la function
    global $connectDB;  
    
    $reqNomCateg = "SELECT * FROM web_cms.categories ORDER BY id_categorie ASC";

    $result = $connectDB -> query($reqNomCateg);

    if(!$result) {
        $msgError = "La récupération des données a echoué";
        echo "<center style='color:red'>".$msgError."</center>";
                
    } else {   //recup de resultat sous forme de tab associative ( $infos[])
        while( $infos = $result -> fetch(PDO::FETCH_ASSOC)){
            $nom_categorie =  $infos['nom_categorie'];
            $id_categorie = $infos['id_categorie'];

            echo "<tr>
                    <td>".$nom_categorie." </td>   

                    <td class='text-center'>
                        <a href='categorieArticle.php?modifCategorie=".$id_categorie."' 
                            class='btn btn-warning'>
                            Modifier
                        </a>
                    </td>

                    <td class='text-center'>
                        <a href='categorieArticle.php?supprimCategorie=".$id_categorie."'
                            class='btn btn-danger'>
                            Supprimer
                        </a>
                    </td>
            
                </tr>";
        }                           
    }
}

// Recuperation d'une categorie a mofdifier
function recupCategorieAModifier() {

    //variable globales qui seront utilisés en dehors de la function
    global $connectDB;
    global $nom_categorie_modif; 
    global $idModifCategorie; 
    global $infos; 

    $idModifCategorie = $_GET['modifCategorie'];
                            
    // Requete directe pour recuperer une categorie
    $reqModif = "SELECT * FROM web_cms.categories WHERE id_categorie = '$idModifCategorie'";
    $resultModif = $connectDB -> query($reqModif);
    // Récup resultat dans un tableau
    $infos = $resultModif -> fetch(PDO::FETCH_ASSOC);
    // récup nom_categorie pour l'afficher dans le input préremplis
    $nom_categorie_modif = $infos['nom_categorie'];
}

// modification Categorie en Bd
function updateCategorieBD() {
    global $connectDB;
    global $msgUpdate;

    // 1.ce qu'on accept, 2.la saissie d'user, 3.s'il y a d'autre caractéres
    preg_match("/([^A-Za-z0-9'\s])/", $_POST['nom_modif_categorie'], $result); 
                    
    // si le champs pas vide OU si $result pas vide
    if(empty($_POST["nom_modif_categorie"]) || !empty($result) ) {
        $msgUpdate = "<p class='text-danger py-2'>Catégorie requise avec chaine alphanumérique 
                (pas de caractères spéciaux)
            </p>";

    } else {  // champs "nom_categirie" et $result pas vide
        // On va enregistrer la categorie en BD
        $updateCategorie = $connectDB -> prepare('UPDATE web_cms.categories 
                                    SET nom_categorie = :nomModifCategorie
                                    WHERE id_categorie = :idModifCategorie' 
        );

        $updateCategorie -> bindValue(':nomModifCategorie', $_POST['nom_modif_categorie']); 
        $updateCategorie -> bindValue(':idModifCategorie', $_POST['id_categorie_modif']);   

        // Execution de la requete
        $resultUpdate = $updateCategorie -> execute();

        if( !$resultUpdate) {
            $msgUpdate = "<p class='text-danger py-2'>La modifiction de la categorie a échoue !</p>";

        } else {
            $msgUpdate = "<p class='text-success py-2'>Catégorie modifié avec succès !</p>";
        }
    } 
}

// Insertion d'un nouveau article
function enregistrementNewArticle(){

    global $connectDB;
    global $message;

    // Si les champs sont vide
    if(empty($_POST['titreArticle'])) {
    $message = "<p class='text-danger py-1'>
            Le titre de l'article doit être une chaine de caractéres non vide
        </p>"; 
    } elseif(empty($_POST['tagsArticle'])) {
        $message = "<p class='text-danger py-1'>
                Précisez au moins un mot-clé pour cet article
            </p>";
    } elseif(empty($_POST['contenuArticle'])) {
        $message = "<p class='text-danger py-1'>
                Rentrez le contenu de votre article
            </p>";             
    } elseif(empty($_POST['categorieArticle'])) {
        $message = "<p class='text-danger py-1'>
                Choisissez une catégorie pour votre article
            </p>";             
               
    } elseif(empty($_FILES['imageArticle']['name'])) {
        $message = "<p class='text-danger py-1'>
                Veillez selectionner une image pour votre article
            </p>";
        
    } else {   //tous les champs sont renseignées

        $titreArticle = htmlspecialchars($_POST['titreArticle']);
        $tagsArticle = htmlspecialchars($_POST['tagsArticle']);
        $contenuArticle = htmlspecialchars($_POST['contenuArticle']);
        $nomCategorieArticle = $_POST['categorieArticle'];
        $newImgArticle = "";

        // Test si on a la bonne extension image
        if(preg_match("#jpeg|png|jpg#", $_FILES['imageArticle']['type'] )) {
            // Astuce pour avoir une photo avec un nom unique
            $newImgArticle = uniqid()."-".$_FILES['imageArticle']['name'];
            // Chemin ou sera stoqué l'image
            $path = "../images/imagesArticles/";
            // upload de l'image
            move_uploaded_file($_FILES['imageArticle']['tmp_name'], $path.$newImgArticle );

            // Requete vers BD pour recupérer l'ID de la categorie séléctionne
            $reqIdCategorie = "SELECT * FROM web_cms.categories WHERE nom_categorie = '$nomCategorieArticle' ";
            // execution de la requete
            $resultCategorie = $connectDB -> query($reqIdCategorie);
            // Recup infos de la requete sous forme d'un tableau associatif
            $infosCategorie = $resultCategorie -> fetch(PDO::FETCH_ASSOC);
    
            // On récupèr iD de la categorie, qu'on va inserer dans la table "articles['id_categorie']"
            $id_categorie = $infosCategorie['id_categorie'];
    
            // La date qu'on va inserer dans la table "articles['date_article']"
            $aujourdhui = date('Y/m/d');
    
            // ID auteur récupéré depuis ca session ouverte
            $id_auteur = $_SESSION['id_user'];
    
            // Requete pour inserer les infos récupéré depuis formulaire en BD
            $reqInsertCategorie = $connectDB -> prepare("INSERT 
                INTO web_cms.articles(titre_article, date_article, contenu_article, tags_article, statut_article, img_article, id_categorie, id_auteur) 
                VALUES(:titre_article, :date_article, :contenu_article, :tags_article, :statut_article, :img_article, :id_categorie, :id_auteur)  
            ");
    
            $reqInsertCategorie -> bindValue(':titre_article', $titreArticle );
            $reqInsertCategorie -> bindValue(':date_article', $aujourdhui);
            $reqInsertCategorie -> bindValue(':contenu_article', $contenuArticle );
            $reqInsertCategorie -> bindValue(':tags_article',  $tagsArticle  );
            $reqInsertCategorie -> bindValue(':statut_article', "Publie" );   //vu que c'est le "admin" directement publié
            $reqInsertCategorie -> bindValue(':img_article', $newImgArticle);
            $reqInsertCategorie -> bindValue(':id_categorie', $id_categorie );
            $reqInsertCategorie -> bindValue(':id_auteur', $id_auteur );
    
            // Execution de la requete
            $result = $reqInsertCategorie -> execute();
    
            if(!$result) {
                $message = "<p class='text-danger py-1'>L'enregistrement de l'article aéchoué ! </p>";
    
            } else {
                $message = "<p class='text-success py-1'>Article enregistré avec succes !</p> ";
            } 
        } else {   //image avec un format differant ou plus grande de 1Mo

            $message = "<p class='text-danger py-1'>
                Image requis! Format acceptée: jpeg, png, jpg et la taille inferieur a 1 Mo.
            </p>"; 
        }
    }
}

// Affichage des article
function afficherArticles() {
    //variable globales qui seront utilisés en dehors de la function
    global $connectDB;  

    $reqArticle = "SELECT * FROM web_cms.articles ORDER BY id_article ASC";

    $resultArticle = $connectDB -> query($reqArticle);

    if(!$resultArticle) {
        $message = "La récupération des données a echoué";
        echo "<center style='color:red'>".$message."</center>";
                
    } else {   //recup de resultat sous forme de tab associative ( $infos[])
        while( $infos = $resultArticle -> fetch(PDO::FETCH_ASSOC)) {

            $articleId =  $infos['id_article'];  //pour le transferer dans URL
            $titre =  $infos['titre_article'];
            $datePublication =  $infos['date_article'];
            $motCles =  $infos['tags_article'];
            $status =  $infos['statut_article'];
            $imgArticle =  $infos['img_article'];
            $auteurId =  $infos['id_auteur'];
            $categorieId =  $infos['id_categorie'];

            // Conversion de la date au format (francais) qu'on veut, a partir de
            // 1970, en seconde
            $datePublication = date('d/m/Y', strtotime($datePublication));

            // Requete pour récupérer le nom de l'auteur
            $reqAuteur = "SELECT * FROM web_cms.utilisateurs WHERE id_user = '$auteurId'";
            $resultAurteur = $connectDB -> query($reqAuteur);  //execution
            // Recup resultat sous forme d'un tab
            $infosAuteur = $resultAurteur -> fetch(PDO::FETCH_ASSOC);
            $nomAuteur = $infosAuteur['nom_user'];
            $prenomAuteur = $infosAuteur['prenom_user'];

            // Requete pour récupérer le nom de la categorie
            $reqCategorie = "SELECT * FROM web_cms.categories WHERE id_categorie = '$categorieId'";
            $resultCategorie = $connectDB -> query($reqCategorie);  //execution
            // Recup resultat sous forme d'un tab
            $infosCategorie = $resultCategorie -> fetch(PDO::FETCH_ASSOC);
            $nomCategorie = $infosCategorie['nom_categorie'];
            
            echo "<tr>
                    <td>".$titre." </td>   
                    <td>".$nomAuteur." ".$prenomAuteur." </td>   
                    <td>".$datePublication." </td>   
                    <td>".$nomCategorie." </td>   
                    <td>".$motCles." </td>   
                    <td>".$status." </td>   
                    <td>
                        <img width='80' src='../images/imagesArticles/".$imgArticle."' alt='img article'/>
                    </td>  
                                        
                    <td class='text-center'>
                        <a href='articles.php?modifArticle=".$articleId."' class='btn btn-warning'>                            
                            Modifier
                        </a>
                    </td>

                    <td class='text-center'>
                        <a href='articles.php?supprimArticle=".$articleId."' class='btn btn-danger'>                          
                            Supprimer
                        </a>
                    </td>            
                </tr>";
        }                           
    }
}