<?php
$bdd = new PDO('sqlite:bdd.db');

$errorMessage = '';

if (isset($_POST['inscription'])) {
    if (
        !empty($_POST['nom']) &&
        !empty($_POST['prenom']) &&
        !empty($_POST['mail']) &&
        !empty($_POST['mdp']) &&
        !empty($_POST['conf_mdp']) &&
        !empty($_POST['date'])
    ) {
        // On empêche les injections SQL et on stocke les variables
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $mail = htmlspecialchars($_POST['mail']);
        $date = htmlspecialchars($_POST['date']);

        $mail = strtolower($mail); // email transformé en minuscule

        $check = $bdd->prepare('SELECT COUNT(*) AS count FROM utilisateur WHERE mail = ?');
        $check->execute(array($mail));
        $row = $check->fetch();

        if ($row['count'] == 0) {
            if ((strlen($prenom) <= 20) && (strlen($nom) <= 20)) { // On vérifie que la longueur du nom/prénom <= 20
                if (strlen($mail) <= 100) { // On vérifie que la longueur du mail <= 100
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) { // On vérifie si l'e-mail est de la bonne forme
                        if ($_POST['mdp'] === $_POST['conf_mdp']) { // Si les deux mots de passe saisis sont bons
                            // "Crypte" le mot de passe
                            $options=['cost'>=12];
                            $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT,$options);

                            // On insère dans la base de données
                            $insert = $bdd->prepare('INSERT INTO utilisateur (nom, prenom, date, mail, mdp) VALUES(:nom, :prenom, :date, :mail, :mdp)');
                            $insert->execute(array(
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'date' => $date,
                                'mail' => $mail,
                                'mdp' => $mdp
                            ));
                            // On redirige avec le message de succès
                            header('Location:connexion.php');
                            die();
                        } else {
                            $errorMessage = 'Les mots de passe saisis ne correspondent pas.';
                        }
                    } else {
                        $errorMessage = 'L\'adresse email n\'est pas valide.';
                    }
                } else {
                    $errorMessage = 'La longueur de l\'adresse email dépasse la limite autorisée.';
                }
            } else {
                $errorMessage = 'La longueur du nom ou du prénom dépasse la limite autorisée.';
            }
        } else {
            $errorMessage = 'Un utilisateur avec cette adresse email est déjà enregistré.';
        }
    } else {
        $errorMessage = 'Veuillez remplir tous les champs.';
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
            <label for="nom">Votre nom</label>
            <input id="nom" name="nom" type="text" placeholder="Entrez votre nom">
            <br>
            <label for="prenom">Votre prénom</label>
            <input id="prenom" name="prenom" type="text" placeholder="Entrez votre prénom">
            <br>
            <label for="date">Votre date de naissance</label>
            <input id="date" name="date" type="date">
            <br>
            <label for="mail">Votre adresse email</label>
            <input id="mail" name="mail" type="email" placeholder="Entrez votre email">
            <br>
            <label for="mdp">Mot de passe</label>
            <input id="mdp" name="mdp" type="password">
            <label for="conf_mdp">Confirmation du mot de passe</label>
            <input id="conf_mdp" name="conf_mdp" type="password">
            <br>
            <input type="submit" value="Inscription" name="inscription">
        </form>
        <?php echo $errorMessage; ?>
    </body>
</html>