<?php 
    $title = "Modification d'un Article";
    require_once "communs/header_admin.php";
    require_once "config/connectDB.php";
    require_once "functions.php";

    // Modification d'un article
    modifierArticle();
    
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php require_once "communs/sidebar_left_admin.php" ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Navbar top -->
                <?php require_once "communs/navbar_top_admin.php" ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                
                    <?php
                    // Si bouton "Mettre à jour l'article" déclanché
                    if(isset($_GET['modifArticle']) && $_GET['modifArticle'] != "") {

                        $articleID = $_GET['modifArticle'];

                        // Requete pour récupérer les infos d'un article
                        $reqArticle = "SELECT * FROM web_cms.articles WHERE id_article = '$articleID' ";
                        $resultArticle = $connectDB -> query($reqArticle); //execution de la requête

                        // On va récuperer les nb de ligne retourné par la requete
                        $nb_lignes = $resultArticle -> rowCount();

                        if($nb_lignes == 0) {
                            $msgErreur = "<p class='text-danger text-center'>Aucun article répondant a vos critères !</p>";

                        } else {
                    
                            $infosArticle = $resultArticle -> fetch(PDO::FETCH_ASSOC);
                    
                            $titreArticle = $infosArticle['titre_article'] ;
                            $motsClesArticle = $infosArticle['tags_article'] ;
                            $contenuArticle = $infosArticle['contenu_article'] ;
                            $statutArticle = $infosArticle['statut_article'] ;
                    
                            $categorieArticleID = $infosArticle['id_categorie'] ;
                    
                            // Requête pour récupérer le nom de la categorie
                            $reqCategorie = "SELECT * FROM web_cms.categories 
                                WHERE id_categorie = '$categorieArticleID '";
                    
                            $resultCateg = $connectDB -> query($reqCategorie);    //execution
                            $infoCateg = $resultCateg -> fetch(PDO::FETCH_ASSOC);//recup resultat dans tableau
                            $nomCategorieModif = $infoCateg['nom_categorie'];  
                        
                            // $imgArticle = $infosArticle[''] ; 
                        ?>    
                            <!-- Formulaire pour modifier un article -->
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10">
        
                                        <div class="card shadow-lg border-0 rounded-lg mt-3">
                                            <?php if(isset($message)) echo $message ;?>
                                            <div class="card-header">
                                                <h3 class="text-center text-primary my-2">Modifier votre article</h3>
                                            </div>
        
                                            <div class="card-body">
                                                        
                                                <form action="#" method="post" enctype="multipart/form-data">
        
                                                    <div class="row mb-3">
        
                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-3 mb-md-0">
                                                                <label for="titreArticle"><b>Titre Article</b></label>
                                                                <input type="text" name="titreArticle" class="form-control" id="titreArticle" 
                                                                    value="<?= $titreArticle; ?>" 
                                                                />                                                            
                                                            </div>
                                                        </div>
        
                                                        <div class="col-md-6">
                                                            <div class="form-floating">
                                                                <label for="tagsArticle"><b>Mots clés</b></label>
                                                                <input type="text" name="tagsArticle" class="form-control" id="tagsArticle"
                                                                    value="<?= $motsClesArticle; ?>"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="form-floating mb-3">
                                                        <label for="summernote"><b>Contenu de l'article</b></label>
                                                        <textarea type="text" name="contenuArticle" class="form-control" id="summernote">                                                   
                                                            <?= $contenuArticle; ?>
                                                        </textarea>                                                
                                                                                                    
                                                        <script>
                                                            $('#summernote').summernote({
                                                                placeholder: 'Editez votre text ici',
                                                                tabsize: 2,
                                                                height: 100
                                                            });
                                                        </script>
                                                    </div>
                                                
                                                    <div class="row mb-3">
        
                                                        <div class="col-md-6">
                                                            <div class="form-floating mb-3 mb-md-0">
                                                                <label for="categorie"><b>Catégorie de votre article</b></label>
                                                                <select name="categorieArticle" class="form-control" id='categorie' >
        
                                                                    <option value="<?= $nomCategorieModif; ?>" selected >
                                                                        <?= $nomCategorieModif; ?> 
                                                                    </option>   
        
                                                                    <?php
                                                                        $reqNomCateg = "SELECT * FROM web_cms.categories ORDER BY id_categorie ASC";
        
                                                                        $result = $connectDB -> query($reqNomCateg);
                                                                    
                                                                        if(!$result) {  //si pas de catégorie trouvé
                                                                            $msgError = "La récupération des données a echoué";
                                                                            echo "<center style='color:red'>".$msgError."</center>";
                                                                                    
                                                                        } else {   //recup de resultat sous forme de tab associative ( $infos[])
                                                                            while( $infos = $result -> fetch(PDO::FETCH_ASSOC)) {
                                                                                $nom_categorie =  $infos['nom_categorie'];                                                                      
                                                                                echo "<option>".$nom_categorie."</option>";
                                                                            }                           
                                                                        }                                                            
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-floating">
                                                                <label for="statusArticle"><b>Statut de l'article</b></label>
                                                                <select name="statutArticle" class="form-control" id="statusArticle" >
        
                                                                    <option value="<?= $statutArticle; ?>" selected >
                                                                        <?= $statutArticle; ?> 
                                                                    </option> 
                                                                    <option>Publié</option>                                                             
                                                                    <option>En attente de publication</option>                                                             
                                                                    <option>Brouillon</option>                                                             
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-md-6">
                                                        <label for="imgArticle"><b>Image de l'article</b></label>
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" 
                                                            id="imgArticle"  />
        
                                                        <input type="file" name="imageArticle" id="imgArticle"  />

                                                    </div>
                                                    
                                                    <!-- Imput chargé de transmettre l'ID de l'article -->
                                                    <input type="hidden" name="idArticle" value="<?= $articleID ;?>" >

                                                    <div class="mt-4 mb-0">
                                                        <div class="d-grid">
                                                            <input type="submit" name="modifier_article" 
                                                                class="btn btn-primary btn-block"                                                        
                                                                value="Mettre à jour l'article"
                                                            >
                                                        </div>
                                                    </div>
        
                                                </form>                                   
                                            </div>
                                            <!-- FIN ".card-body"  -->
                                        </div>
                                    </div>
                                </div>
                            </div>   <br><br>
                                            
                       <?php }

                    } else {
                        $msgErreur = "<p class='text-danger py-1'>Aucun article a modifier</p>";
                    } 
 
                    if(isset($msgErreur)) echo $msgErreur ; 

                    ?>              
                </div>
                <!-- End of ".container-fluid" -->
            </div>
            <br><br>

            <!-- Footer -->
            <?php require_once "communs/footer_admin.php" ; ?>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

   <!-- Bootstrap core JavaScript-->
   <?php require_once "communs/modal_logout_admin.php" ; ?>
    <?php require_once "communs/boostrap_js.php"; ?> 

</body>

</html>