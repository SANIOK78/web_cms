<?php 
    $title = "Catégories d'Articles";
    require_once "communs/header_admin.php";
    require_once "config/connectDB.php";
    require_once "functions.php";

    // Enregistrement d'une catégorie: 

    
    if(isset($_POST['addCategorie'])) {

        saveNewCategorie();  //function qui va créer une nouvelle categorie             
    }

    // SUPPRESSION d'une catégorie
    // s'il y a un paramétre 'supprimCategorie" transmit dans URL
    if(isset($_GET['supprimCategorie']) ) {   //on recup l'id

        supprimerCategorie(); //function qui va supprimer categorie 
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

                <!-- Topbar -->
                <?php require_once "communs/navbar_top_admin.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 text-primary"><u>Catégories</u></h1>

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card shadow-lg border-0 rounded-lg mt-3">

                                    <div class="card-header">
                                        <h3 class="text-center text-primary my-2">Nouvelle Catégorie</h3>
                                    </div>
                                    <div class="card-body">
                                                
                                        <form action="#" method="post">

                                            <div class="form-floating mb-3">
                                                <label for="nomCategirie">Nom Catégorie</label>
                                                <input type="text" name="nom_categirie" class="form-control" id="nomCategirie">                                                                           
                                            </div>
                              
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                              
                                                <input type="submit" name="addCategorie" class="btn btn-primary" value="Enregistrer">
                                            </div>

                                            <?php if(isset($message)){ echo $message ; } ?>

                                        </form>                                   
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>   <br><br>
                 
                    <!-- Modification d'une catégorie -->
                    <?php
                        // si le paramétre "modifCategorie" a été transmit dans URL
                        if(isset($_GET['modifCategorie'])){  

                            // Recuperation d'une categorie a mofdifier
                            recupCategorieAModifier();

                            // MODIFICATION / UPDATE d'une categorie en BD
                            if(isset($_POST['modifCategorie'])) {

                                updateCategorieBD();      
                            }
                    ?>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="card shadow-lg border-0 rounded-lg mt-3">
                                        <div class="card-header">
                                            <h3 class="text-center text-primary my-2">Modifier Catégorie</h3>
                                        </div>
 
                                        <div class="card-body">                                                   
                                            <form action="#" method="post">
                                                <div class="form-floating mb-3">
                                                    <label for="nomCategirie">Nom Catégorie</label>
                                                    <input type="text" name="nom_modif_categorie" value="<?= $nom_categorie_modif ; ?>"
                                                        class="form-control" id="nomCategirie"
                                                    >
                                                    <!-- On transmet l'ID de la categorie via un input caché -->
                                                    <input type="hidden" name="id_categorie_modif" value="<?= $idModifCategorie ; ?>" >                                                                         
                                                </div>
                                
                                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">                                               
                                                    <input type="submit" name="modifCategorie" class="btn btn-success" value="Mettre a jour">
                                                </div>

                                                <?php if(isset($msgUpdate)){ echo $msgUpdate ; } ?>

                                            </form>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   <br><br>

                    <?php  } ?>
                                        
                    <div class="row justify-content-center">
                        <div class="col-lg-8">

                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Catègories</h6>
                                    
                                </div>

                                <?php if(isset($msgSuppr)) echo "<center>".$msgSuppr."</center><br>" ; ?>

                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nom de la catégorie</th> 
                                                    <th colspan="2" class="text-center">Actions</th> 
                                                </tr>                                                                      
                                            </thead>
                                  
                                            <tbody>
                                                <?php 
                                                    // Afficher toutes les categories
                                                    afficherCategories();
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   <!-- Bootstrap core JavaScript-->
    <?php require_once "communs/boostrap_js.php"; ?> 

</body>

</html>