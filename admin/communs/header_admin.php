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

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>