<?php 
    $title = "Page d'un article ";
    require_once './communs/header.php';
    require_once './communs/navigation.php';
    require_once "config/connectDB.php";
?>

<!-- Page Content -->
<div class="container"
    <div class="row">       
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php   
                //CE cod doit s'executer seulement s'il a eu le transfert de 
                //parametre "articleID" dans URL
            if(isset($_GET['articleID'])) {  
                
                $idArticle = $_GET['articleID'];

                // Requête pour chercher en BD l'article correspondant au "ID" récupéré depuis URL
                $reqArticle = "SELECT * FROM web_cms.articles WHERE id_article = '$idArticle'";                                   
                $resultArticle = $connectDB -> query($reqArticle);  //execution 
                $infos = $resultArticle -> fetch(PDO::FETCH_ASSOC);  //result dans un tableau
               
                if( !$resultArticle) {
                    echo "<p class='text-danger py-1'>La récupération de l'articles a échoué!";
                } else {
                    // recup de resultat dans un tableau                   
                        $articleID = $infos['id_article'];
                        $titreArticle = $infos['titre_article'];    
                        //Date au format francais   
                        $datePublication = date('d/m/Y', strtotime($infos['date_article']));
                        $contenu = $infos['contenu_article'];
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
                        <div class="card my-2 ">
                            <!-- Affichage des articles -->
                            <div class="card-header p-4">
                                <img class='img-responsive border border-primary' 
                                    src="images/imagesArticles/<?= $imageArticle ;?> "
                                    alt="image article" 
                                />                              
                            </div>

                            <div class="card-body">
                                <h3 class="text-center">
                                    <?php
                                        echo "<a href='article.php?articleId=$articleID'>$titreArticle</a>" ;                                
                                    ?>                                                           
                                </h3>
                          
                                <?php echo "<p>".$contenu."</p>" ;  ?>                               
                            </div>
                            
                            <div class="card-footer">
                                <p class="lead my-2">
                                    Auteur : <a href="index.php"><?= $nomAuteur." ".$prenomAuteur ; ?></a>
                                </p>
                                <p class="my-2"><span class="glyphicon glyphicon-time"></span> 
                                    Publié le : <?= $datePublication ; ?> | Categorie : <?= $nomCategorie ; ?>
                                </p>
                            </div>   
                        </div>           
                <?php  
                }
            }
            ?>
          
            <!-- Comments Form -->
            <div class="well mt-5">
                <h4>Leave a Comment:</h4>
                <form role="form">
                    <div class="form-group">
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">Start Bootstrap
                        <small>August 25, 2014 at 9:30 PM</small>
                    </h4>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.                                       
                </div>
            </div>
    
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php  require_once './communs/sidebar.php'; ?>                
    </div>
    
<!--footer-->
<?php 
    // include './communs/footer.php';
    require_once './communs/footer.php';
?>