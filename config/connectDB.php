<?php 
    // stokage de nom BD et du serveur
    $dsn = 'mysql:dbname=web_cms;host=localhost';

    // nom utilisateur DB et mot de passe
    $user = 'root';
    $password = '';

    // Configuration de la connexion a la BD
    try {
        $connectDB = new PDO($dsn, $user, $password);

        // configuration des paramétres
        $connectDB -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verification si tous va bien
        // if($connectDB) {
        //     echo "<br>";
        //     echo "<b style='color:green;font-size:20px;'>Connexion a la BD réussi :-) !!!</b>";
        // }

    } catch(PDOException $e){

        echo "Echec lors de la connexion : => ".$e -> getMessage();
    }

?>