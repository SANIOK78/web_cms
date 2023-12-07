<?php 
    $title = "Page d'un article ";
    require_once './communs/header.php';
    require_once './communs/navigation.php';
    require_once "config/connectDB.php";
    require_once "./fonctions.php";
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
                        $pseudoAuteur = $resultAuteur['pseudo'];

                        // Récup du nom de la categorie
                        $reqCategorie = "SELECT * FROM web_cms.categories WHERE id_categorie = '$categorieID'";
                        $execReqCategorie = $connectDB -> query($reqCategorie);
                        $resultCategorie = $execReqCategorie -> fetch(PDO::FETCH_ASSOC);
                        $nomCategorie = $resultCategorie['nom_categorie'];
                    ?>
                        <div class="card my-2 border border-primary ">
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

                // AJOUT DU CODE COMMENTAIRE
                ajouter_commentaireBD();
            ?>
     
            <!-- Comments Form -->
            <?php 
                // Affichage du formulaire "commentaires" seulement s'il a un "article_ID"
                // transmis en paramètre
                if(isset($_GET['articleID']) && $_GET['articleID'] !="") { ?>

                    <div class="well mt-5">
                        <?php if (isset($message)) echo $message; ?>
                        <h4>Laisser un commentaire:</h4>
                        
                        <form role="form" action="" method="post">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="contenu_comment">                            
                                </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_comment">
                                Enregistrer
                            </button>
                        </form>
                    </div>
                    <hr>
            <?php }?>

            <!--SECTION Comment -->
            <?php   //recupération des commentaire depuis la BD
                // Execution seulement s'il y a l'ID de l'article, pous savoir 
                // de quel article il s'agit
                if(isset($_GET['articleID']) && $_GET['articleID'] !== ''){
                    $id_article = $_GET['articleID'];

                    $reqRecupComment = "SELECT * FROM web_cms.commentaires WHERE id_article = $id_article";
                    $resultRecupComment = $connectDB -> query($reqRecupComment); //execution

                    if(!$resultRecupComment){
                        $messageComment = "<p style='color:red'>La récupération des commentaire a échoué :-(</p>";

                    } else {  //tous va bien => recup des commentaire line par line(tab associatif)

                        while($infoComment = $resultRecupComment -> fetch(PDO::FETCH_ASSOC)) {

                            $id_auteur = $infoComment['id_user'];

                            // recup "user_auteur" du commentaire
                            $reqRecupAuteur = "SELECT * FROM web_cms.utilisateurs WHERE id_user = $id_auteur ";
                            $reqRecupAuteur = $connectDB -> query($reqRecupAuteur); //execution

                            // recup des enregistrement dans un tab associatif
                            $infoAuteur = $reqRecupAuteur -> fetch(PDO::FETCH_ASSOC);

                            $auteurNom = $infoAuteur['nom_user'];
                            $auteurPrenom = $infoAuteur['prenom_user'];
                            $photoAuteur = $infoAuteur['photo_user'];

                            // Le commentaire
                            $idComment = $infoComment['id_comment'];
                            $contenuComment = $infoComment['contenu_comment'];
                            $dateComment = $infoComment['date_comment'];
                            $dateComment_fr = date('d/m/Y', strtotime($dateComment)); //date format France

                        ?>
                            <div class="media">
                               <?php if(isset($messageComment)) echo $messageComment; ?>

                                <a class="pull-left" href="#">
                                    <img class="media-object rounded-circle" width="50" height="50"
                                        src="images/photos_profil/<?= $photoAuteur ?>" 
                                        alt="<?= $pseudoAuteur ;?>"
                                    >
                                </a>

                                <div class="media-body">
                                    <h4 class="media-heading"><?= $auteurNom." ".$auteurPrenom ;?>
                                        <small><?= $dateComment_fr ;?></small>
                                    </h4>

                                    <?= $contenuComment ;?> 

                                    <!-- Partie "Suppression & Modification commentaire -->
                                    <?php 
                                      // S'il  a un user connecté ET s'il y a un "membre" connecté et son ID correspond a 
                                      // l'ID du auteur du commentaire
                                        if( isset($_SESSION['id_user']) && $_SESSION['id_user'] == $infoComment['id_user']){ 
                                            
                                            echo "<div class='media-footer mt-5'>
                                                <a class='py-3' href='article.php?modif_commentaire=$idComment '>
                                                    Modifier le commentaire
                                                </a>
                                                
                                                <a class='py-3 ms-4' 
                                                    href='article.php?supprimer_commentaire=$idComment&articleID=$id_article'
                                                >
                                                    Supprimer le commentaire
                                                </a>
                                            </div>";
                                        }                                   
                                    ?>  
                                </div>   
                            </div>
                            <hr>
                       <?php }
                    }
                }

                // Suppression du commentaire APRES CONFIRMATION via une boite de dialogue JS
                if(isset($_GET['supprimer_commentaire']) && $_GET['supprimer_commentaire'] != ""){

                    $idCommentASuppr = $_GET['supprimer_commentaire'];

                    echo '<script type="text/javascript">
                        if(confirm("Etes-vous sûr de vouloir supprimer votre commentaire?")){
                            window.location.href = "article.php?suppr_mon_comment_valid='.$idCommentASuppr .'";
                        }
                    </script> ';
                }

                // Suppression du commentaire en BD, une fois confirmé
                if(isset($_GET['suppr_mon_comment_valid']) && $_GET['suppr_mon_comment_valid'] != ""){

                    $id_Comment_A_Suppr = $_GET['suppr_mon_comment_valid'];

                    $reqSupprComment = "DELETE FROM web_cms.commentaires WHERE id_comment = $id_Comment_A_Suppr";
                    $resultSupprComment = $connectDB -> query($reqSupprComment);

                    if( !$resultSupprComment) {
                        echo "<p class='text-danger'>La suppression du commentaire a échoué !</p>";

                    } else {
                        echo "<p class='text-success'>Le commentaire a bien été supprimé !</p>";
                    }
                }
            ?>    
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php  require_once './communs/sidebar.php'; ?>                
    </div>
    
<!--footer-->
<?php 
    // include './communs/footer.php';
    require_once './communs/footer.php';
?>