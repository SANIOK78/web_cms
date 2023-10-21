<?php 
    session_start();  //ouverture de session "Admin"

    // Vérif si "session_ID" et "session_role" n'existe pas
    if( !($_SESSION['id_user'] && $_SESSION['role_user'] && 
        $_SESSION['role_user'] == 'Admin' )) {

        //On va pas authoriser l'acces a cette page
        header('location: login.php'); 
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ; ?></title>

    <!-- Lien éditeur de text "summernote"-->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->
    <!-- <script src="js/jquery-3.5.1.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
        crossorigin="anonymous">
    </script> -->
    <!-- <script src="js/popper.min.js" ></script> -->
 
    <!-- <script src="js/bootstrap.min.js"></script> -->

    <!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet"> -->
    <!-- <link href="css/summernote-bs4.min.css" rel="stylesheet" > -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> -->
    <!-- <script src="js/summernote-bs4.min.js"></script>  -->

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet"
    >

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>