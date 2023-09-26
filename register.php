<?php
    // Importation code "header-register"
    require_once "communs/header_register.php";
?>

<body class="bg-primary">

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">

            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h2 class="text-center font-weight-light my-4">Inscription </h2>                                                        
                                </div>

                                <div class="card-body">

                                    <form action="" method="post" enctype="multipart/form-data">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="prenom" class="form-control" id="inputFirstName" type="text" />
                                                    <label for="inputFirstName">Prénom</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input name="nom" class="form-control" id="inputLastName" type="text" />
                                                    <label for="inputLastName">Nom</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input name="email" class="form-control" id="inputEmail" type="email" />
                                            <label for="inputEmail">Email</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="password" class="form-control" id="inputPassword" type="password" />
                                                    <label for="inputPassword">Mot de passe</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="confirm_mdp" class="form-control" id="mdpConfirm" type="password" />
                                                    <label for="mdpConfirm">Confirmer Mot de passe</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input name="pseudo" class="form-control" id="pseudo" type="text" />
                                                    <label for="pseudo">Pseudo</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <label for="photo">Photo de profil</label>
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" id="photo"  />
                                                    <input type="file"  id="photo"  />
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" name="inscription" 
                                                    class="btn btn-success btn-block" 
                                                    value="Créer votre compte"
                                                >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        <a href="login.html">
                                            Avez-vous un compte? Connectez-vous
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

<?php
    // Importation "footer.php"
    require_once "communs/footer.php";
?>
