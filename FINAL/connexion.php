<?php
session_start(); // Démarrage de la session

$bdd = new PDO('sqlite:bdd.db');

$query = 'CREATE TABLE IF NOT EXISTS utilisateur (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT NOT NULL,
        prenom TEXT NOT NULL,
        date TEXT NOT NULL,
        mail TEXT NOT NULL,
        mdp TEXT NOT NULL            
    )';

// Execute the query
$bdd->exec($query);

if(isset($_POST['connexion'])){
    if (!empty($_POST['mail']) && !empty($_POST['mdp'])) {
        // On récupère les variables en évitant les injections SQL
        $mail = htmlspecialchars($_POST['mail']);
        $mdp = htmlspecialchars($_POST['mdp']);

        $mail = strtolower($mail); // Email transformé en minuscule

        // On regarde si l'utilisateur est inscrit dans la table utilisateur



        // Si row = 1 alors l'utilisateur existe
        $check = $bdd->prepare('SELECT COUNT(*) AS count FROM utilisateur WHERE mail = ?');
        $check->execute(array($mail));
        $row = $check->fetch();

        if ($row['count'] > 0) {
            // Si le mail est au bon format
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                // récupération des données de l'utilisateur
                $check = $bdd->prepare('SELECT * FROM utilisateur WHERE mail = :mail');
                $check->execute(array($mail));
                $data = $check->fetch();

                // vérification du mot de passe
                if (password_verify($mdp, $data['mdp'])) {
                    // on redirige vers jeune.php

                    //stockage des données utilisateur dans la session
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['nom'] = $data['nom'];
                    $_SESSION['prenom'] = $data['prenom'];
                    $_SESSION['mail'] = $data['mail'];
                    $_SESSION['date'] = $data['date'];
                        
                    $_SESSION['connexion']='jeune';

                    // on redirige l'utilisateur vers la page jeune
                    header('Location: page_jeune_final.php');
                    die();
                } else {
                    $error = 'Mot de passe incorrect.';
                }
            } else {
                $error = 'Adresse email invalide.';
            }
        } else {
            $error = 'Aucun utilisateur trouvé avec cette adresse email.';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Création de compte</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" type="text/css" href="connexion.css">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <title>Connection</title>
    
    </head>
    <body>
        <header role="banner">
            <div class="container">
                <div name="logo" id="logo">
                    <img src="logo2.png" alt="logo.jpg" class="image">
                </div>
                <div class="text">
                    <div class="titre" id="bigtext">
                        Se connecter
                    </div>  
                    <div class="titre" id="soustexte">
                        Connexion à votre compte Jeune
                    </div>          
                </div>
            </div>   
        </header>    
        <div class="formulaire">
            <div class="h1">Entrer vos infomations :</div>
            <form action="" method="POST">
                <div class="align-label" id="top">
                    <label for="mail">Votre adresse email :</label>
                    <input id="mail" name="mail" type="email" placeholder="Entrez votre email">
                </div>
                <br>
                <div class="align-label">
                    <label for="mdp">Mot de passe :</label>
                    <input id="mdp" name="mdp" type="password">
                </div>
                <br>
                <div class="button">
                    <input type="submit" value="Connexion" name="connexion">
                </div>
            </form>
        </div>
        <div class="inscription">
            <div class="h1">Si vous n'avez pas de compte, inscrivez vous ! : </div>
            <div class="button">
                <button onclick="self.location.href='inscription.php'">Inscription</button>
            </div>
        </div>
        <?php echo $error; ?>
    </body>
</html>
