<?php 
    $title = "Accueil - Web_CMS";
    require_once './communs/header.php';
    require_once './communs/navigation.php';
    require_once "config/connectDB.php";
?>

<!-- Page Content -->
<div class="container"
    <div class="row">

        <h1 class="page-header text-center text-primary">Nos articles</h1>  
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            
            <?php 
                // Si on récupèr dans URL un paramétre "idCategorie" alors on affiche tous
                // les articles de cette catagorie
                if(isset($_GET['idCategorie']) && !empty($_GET['idCategorie']) ) {

                    $idCategorie = $_GET['idCategorie'];

                    // Requete pour récupérer tous les articles d'une catégorie
                    $reqArticle = "SELECT * FROM web_cms.articles 
                        WHERE id_categorie = '$idCategorie' AND statut_article = 'Publie' 
                        ORDER BY id_article DESC ";

                    $execReqArticle = $connectDB -> query($reqArticle);

                    $nb_articles = $execReqArticle -> rowCount();  //récup les nombre des article

                    if($nb_articles == 0) {
                        echo "<p class='text-danger p-5'><b>Aucun article dans cette categorie !</b></p>";
                    }

                } else { // SI NON on affiche tous les articles disponible en BD

                    $reqArticle = "SELECT * FROM web_cms.articles WHERE statut_article = 'Publie' 
                        ORDER BY id_article DESC ";  

                    $execReqArticle = $connectDB -> query($reqArticle);

                    if($nb_articles == 0) {
                        echo "<p class='text-danger p-5'><b>Aucun article disponible !</b></p>";
                    }
                }

                if( !$execReqArticle) {
                    echo "<p class='text-danger py-1'>La récupération des articles a échoué!";

                } else {
                    // recup de resultat dans un tableau
                    while($infos = $execReqArticle -> fetch(PDO::FETCH_ASSOC)) { 

                        $articleID = $infos['id_article'];
                        $titreArticle = $infos['titre_article'];    
                        //Date au format francais   
                        $datePublication = date('d/m/Y', strtotime($infos['date_article']));

                        // On va afficher l'article avec un nb limité des caracteres (de 0 à 400)
                        $contenu = $infos['contenu_article'];
                        if(strlen($contenu) > 400 ) {
                            $contenu = substr($contenu, 0, 400);

                        } else {  //$contenu < 400

                            $contenu = $contenu;
                        }

                        $tagsArticle = $infos['tags_article'];
                        $statutArticle = $infos['statut_article'];
                        $imageArticle = $infos['img_article'];
                        $auteurID = $infos['id_auteur'];
                        $categorieID = $infos['id_categorie'];

                        // Recupération du nom et prenom du auteur 
                        $reqAuteur = "SELECT * FROM web_cms.utilisateurs WHERE id_user = '$auteurID'";
                        $execReqAuteur = $connectDB -> query($reqAuteur);
                        $resultAuteur = $execReqAuteur -> fetch(PDO::FETCH_ASSOC);
                        $nomAuteur = $resultAuteur['nom_user'];
                        $prenomAuteur = $resultAuteur['prenom_user'];

                        // Récup du nom de la categorie
                        $reqCategorie = "SELECT * FROM web_cms.categories WHERE id_categorie = '$categorieID'";
                        $execReqCategorie = $connectDB -> query($reqCategorie);
                        $resultCategorie = $execReqCategorie -> fetch(PDO::FETCH_ASSOC);
                        $nomCategorie = $resultCategorie['nom_categorie'];
                    ?>
                        <div class="card mb-5">
                            <!-- Affichage des articles -->
                            <div class="card-header">
                                <h3>
                                    <?php
                                        echo "<a href='article.php?articleId=$articleID'>$titreArticle</a>" ;                                
                                    ?>                                                           
                                </h3>
                                <hr>
                                            
                                <p class="lead">
                                    Auteur : <a href="index.php"><?= $nomAuteur." ".$prenomAuteur ; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> 
                                    Publié le : <?= $datePublication ; ?> | Categorie : <?= $nomCategorie ; ?>
                                </p>
                            </div>

                            <div class="card-body">
                                
                                <img class='img-responsive border'  whidth="800" height="200"
                                    src="images/imagesArticles/<?= $imageArticle ;?> "
                                    alt="image article" 
                                />

                                <?php echo "<p>".$contenu."</p>" ;  ?>                               
                            </div>

                            <div class="card-footer">
                                <a class='btn btn-primary' href='article.php?articleID=<?php echo $articleID ;?>' >
                                Voir plus... 
                                    <span class='glyphicon glyphicon-chevron-right'></span> 
                                </a>
                        
                            </div>
                        </div>
            
                <?php  }
                }
                
            ?>
                             
            
            <!-- Pager -->
            <ul class="pager">
                <li class="previous"> <a href="#">&larr; Précedent</a> </li>              
                <li class="next"> <a href="#">Suivant &rarr;</a> </li>              
            </ul>

        </div>
       
        <!-- Blog Sidebar Widgets Column -->
        <?php 
            require_once './communs/sidebar.php';
        ?>
        
     <!-- /.row -->
    </div>
    
    <!--footer-->
    <?php 
        // include './communs/footer.php';
        require_once './communs/footer.php';
    ?>
  