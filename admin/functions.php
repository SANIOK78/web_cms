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