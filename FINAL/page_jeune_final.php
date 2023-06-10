<?php

session_start();

if($_SESSION['connexion']!='jeune'){

    header('location: connexion.php');

}



$bdd = new PDO('sqlite:bdd.db');



$errorMessage = '';



function update($new, $session){

    if(empty($new)){

        return $session;

    } else{

        return htmlspecialchars($new);

    }

}



if(isset($_POST['Valider'])){

    $nom = update($_POST['nom'], $_SESSION['nom']);

    $prenom = update($_POST['prenom'], $_SESSION['prenom']);

    $date = update($_POST['date'], $_SESSION['date']);

    $mail = update($_POST['mail'], $_SESSION['mail']);

    $mail = strtolower($mail);



    if(empty($_POST['mdp'])){

        $mdp=$_SESSION['mdp'];

    } else{

        $options=['cost'>=12];

        $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT,$options);

    }



    if ((strlen($prenom) <= 20) && (strlen($nom) <= 20)) { // On vérifie que la longueur du nom/prénom est inférieure ou égale à 20

        if (strlen($mail) <= 100) { // On vérifie que la longueur du mail est inférieure ou égale à 100

            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) { // On vérifie si l'e-mail est de la bonne forme

                $check = $bdd->prepare('SELECT COUNT(*) AS count FROM utilisateur WHERE mail = ?');

                $check->execute(array($mail));

                $row = $check->fetch();

                if ($row['count'] == 0 || $mail==$_SESSION['mail']) {

                    $bdd->exec("UPDATE utilisateur SET nom='$nom', prenom='$prenom', date='$date', mail='$mail', mdp='$mdp' WHERE id='{$_SESSION['id']}'");

                    $_SESSION['nom'] = $nom;

                    $_SESSION['prenom'] = $prenom;

                    $_SESSION['mail'] = $mail;

                    $_SESSION['date'] = $date;

                    $_SESSION['mdp'] = $mdp;

                } else {

                    $errorMessage = 'Un utilisateur avec cette adresse email est déjà enregistré.';

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

}



if($errorMessage!=''){

    // Affiche une alerte en JavaScript avec le message d'erreur

    echo "<script langage='javascript'>alert(".$errorMessage.");</script>";

}

?>



<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="page_jeune_final.css">

    <link rel="stylesheet" type="text/css" href="reset.css">

    <title>Jeunes 6.4</title>

</head>

<body>

    <header role="banner">

        <div class="container">

            <div name="logo" id="logo">

                <img src="logo2.png" alt="logo.jpg" class="image">

            </div>

            <div class="text">

                <div class="titre" id="bigtext">

                    JEUNE

                </div>

                <div class="titre" id="soustexte">

                    Je donne de la valeur à mon engagement

                </div>

            </div>

        </div>

    </header>



    <div class="menunav">

        <div class="nav">

            <ul class="navi">

                <li><a href="" title="aller a jeune"><mark>Jeune</mark></a>

                    <ul class="sub-menu">

                        <li>

                            <a href="page_jeune_final.php" title="monprofil">Mon profil</a>

                        </li>

                        <li>

                            <a href="page_demande_reference.php" title="réference">Demande de référence</a>

                        </li>

                        <li>

                            <a href="page_liste_reference.php" title="liste">Liste de référence</a>

                        </li>

                    </ul>

                </li>

                <li>Référent</li>

                <li>Consultant</li>

                <li>Partenaire</li>

            </ul>

        </div>

    </div>



    <div class="subtitle">

        <h1>Mon profil</h1>

    </div>



    <div class="container2">

        <div class="middle">

            <form class="formulaire1" action="#" method="POST">

                <div class="align-label-input">

                    <label for="nom">NOM :</label>

                    <input type="text" id="nom" name="nom" value='<?php echo $_SESSION['nom']?>'>

                </div>

                <div class="align-label-input">

                    <label for="prenom">PRENOM :</label>

                    <input type="text" id="prenom" name="prenom" value='<?php echo $_SESSION['prenom']?>'>

                </div>

                <div class="align-label-input">

                    <label for="date">DATE DE NAISSANCE:</label>

                    <input type="text" id="date" name="date" value='<?php echo $_SESSION['date']?>'>

                </div>

                <div class="align-label-input">

                    <label for="mail">MAIL :</label>

                    <input type="email" id="mail" name="mail" value='<?php echo $_SESSION['mail']?>'>

                </div>

                <br>

                <div class="align-label-input">

                    <label for="mdp">mot de passe :</label>

                    <input type="password" id="mdp" name="mdp">

                </div>

                <br>

                <input type="submit" name='Valider' value="Valider">

            </form>

        </div>

    </div>
    <div class="deconnection">
        <div class="msg">Si vous voulez vous déconnectez :</div>
        <div class="button">
            <button>Se déconnecter</button>
        </div>
    </div>

</body>

</html>

