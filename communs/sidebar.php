<?php require_once "config/connectDB.php"; ?>

<div class="col-md-4">
    <!-- Blog Search Well -->
    <!-- <div class="well">

        <h4>Recherche</h4>
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div> -->

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Catégories</h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-unstyled">

                    <?php 
                        $reqCategorie = "SELECT * FROM web_cms.categories ORDER BY id_categorie";
                        $execReqCategorie = $connectDB -> query($reqCategorie);

                        if( !$execReqCategorie) {
                           echo "Aucune catégorie disponible";

                        } else {
                            while($infos = $execReqCategorie -> fetch(PDO::FETCH_ASSOC)){

                                $categorieID = $infos['id_categorie'];
                                $nomCategorie = $infos['nom_categorie'];

                                echo "<li class='mb-2'>
                                        <a href='index.php?idCategorie=$categorieID'>".$nomCategorie."</a>
                                    </li> ";
                            }
                        }                                        
                    ?>                                                                   
                </ul>
            </div>
          
        </div>

    </div>
</div>

