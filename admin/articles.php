<?php 
    $title = "Les Articles";
    require_once "communs/header_admin.php";
    require_once "config/connectDB.php";
    require_once "functions.php";

    // Suppression d'un article => va se faire seulement si on va detecter le
    // paramétre "supprimArticle" dans URL 
    if(isset($_GET['supprimArticle']) && $_GET['supprimArticle'] != "") {

        supprimArticle();
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
                    <h1 class="h3 text-primary"><u>Nos Articles</u></h1>
                                                            
                    <div class="row justify-content-center">
                        <div class="col-lg-12">

                            <!-- Data Tales Articles -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h4 class="text-center text-primary">Les Articles</h4>                                   
                                </div>
                                
                                <?php if(isset($message)) echo "<center>$message</center>"; ?>

                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Titre</th> 
                                                    <th>Auteur</th> 
                                                    <th>Date publication</th> 
                                                    <th>Catégorie</th> 
                                                    <th>Mot clés</th> 
                                                    <th>Status</th> 
                                                    <th>Image</th> 
                                                  
                                                    <th colspan="2" class="text-center">Actions</th> 
                                                </tr>                                                                      
                                            </thead>
                                  
                                            <tbody>
                                                <?php  afficherArticles(); ?> 
                                               
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