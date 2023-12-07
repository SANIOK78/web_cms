<body class="sb-nav-fixed">
    <!--navigation-->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-5" href="index.php">
            <img src="images/logo.png" width="120" height="30" alt="logo">
        </a>
       
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="index.php">
                    Accueil <span class="sr-only">(current)</span>
                </a>
                <a class="nav-item nav-link" href="#"><strong>Contact</strong></a>
                <a class="nav-item nav-link" href="#"><strong>Blog</strong></a>
            </div>
        </div>


        <!-- Navbar-->
        <!--Right menu -->

        <ul class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" 
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  
                    <?php 
                        if(isset($_SESSION['id_user']) && $_SESSION['role_user'] == "Admin" ) {

                            echo "<li><a class='dropdown-item' href='admin/index.php'>Espace Admin</a></li>";
                        }
                    ?>

                    <li><a class="dropdown-item" href="profilUser.php">Profil</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>

                </ul>
            </li>
        </ul>
    </nav>