<?php
session_start(); // Démarrage de la session

$bdd = new PDO('sqlite:bdd.db');

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
                    $_SESSION['nom'] = $data['nom'];
                    $_SESSION['prenom'] = $data['prenom'];
                    $_SESSION['mail'] = $data['mail'];
                    $_SESSION['date'] = $data['date'];

                    // on redirige l'utilisateur vers la page jeune
                    header('Location: jeune.php');
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
    </head>
    <body>
        <form action="" method="POST">
            
            <label for="mail">Votre adresse email</label>
            <input id="mail" name="mail" type="email" placeholder="Entrez votre email">

            <br>

            <label for="mdp">Mot de passe</label>
            <input id="mdp" name="mdp" type="password">
            <br>

            <input type="submit" value="Connexion" name="connexion">
        </form>
        <button onclick="self.location.href='inscription.php'">Inscription</button>
        <?php echo $error; ?>
    </body>
</html>