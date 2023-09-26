<?php 
    require_once './communs/header.php';
    require_once './communs/navigation.php';
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">Page Heading <small>Secondary Text</small> </h1>   
                             
            <!-- First Blog Post -->
            <h2>
                <a href="#">Blog Post Title</a>
            </h2>
            <p class="lead">
                by <a href="index.php">Start Bootstrap</a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on August 28, 2013 at 10:00 PM</p>
            <hr>
            <img class="img-responsive" src="http://placehold.it/900x300" alt="">
            <hr>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore, veritatis, tempora, necessitatibus
                inventore nisi quam quia repellat ut tempore laborum possimus eum dicta id animi corrupti debitis
                ipsum officiis rerum.
            </p>
            <a class="btn btn-primary" href="#">
                Read More <span class="glyphicon glyphicon-chevron-right"></span>                        
            </a>
            <hr>
            
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
  