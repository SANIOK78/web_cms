<?php 
    $title = "Nouveau Article";
    require_once "communs/header_admin.php";
    require_once "config/connectDB.php";
    require_once "functions.php";

    // Test si bouton "Soumettre" déclanché
    if(isset($_POST['ajoutArticle'])) {

        // Enregistrement d'un nouveau article
        enregistrementNewArticle();      
    } 
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
                   
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">

                                <div class="card shadow-lg border-0 rounded-lg mt-3">

                                    <div class="card-header">
                                        <h3 class="text-center text-primary my-2">Créez votre article</h3>
                                    </div>

                                    <div class="card-body">
                                                
                                        <form action="#" method="post" enctype="multipart/form-data">

                                            <div class="row mb-3">

                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <label for="titreArticle"><b>Titre Article</b></label>
                                                        <input type="text" name="titreArticle" class="form-control" id="titreArticle" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <label for="tagsArticle"><b>Mots clés</b></label>
                                                        <input type="text" name="tagsArticle" class="form-control" id="tagsArticle"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <label for="summernote"><b>Contenu de l'article</b></label>
                                                <textarea type="text" name="contenuArticle" class="form-control" 
                                                    id="summernote">
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

                                                            <option value="">Choisir une catégorie</option>                                                    
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
                                                    <label for="imgArticle"><b>Image de l'article</b></label>
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" id="imgArticle"  />

                                                    <input type="file" name="imageArticle" id="imgArticle"  />
                                                </div>
                                            </div>

                                            <?php if(isset($message)) echo $message ; ?>

                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <input type="submit" name="ajoutArticle" class="btn btn-primary btn-block"                                                        
                                                        value="Soumettre votre article"
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