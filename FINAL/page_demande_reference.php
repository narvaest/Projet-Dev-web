<?php
session_start();
if ($_SESSION['connexion'] != 'jeune') {
    header('location: connexion.php');
    exit();
}
require 'vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function encode($string, $key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = '';
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}



$key = '~nu!j_EBK,:XE2e{kQ!bhuQ9j]%SlF]z3L^Qy.Q[Gn?NCe&lt;BBy&gt;^LHv~1P]nq~&amp;;';
$id = encode($_SESSION['id'], $key);
$num_ref = encode($data['num_ref'], $key);




$bdd = new PDO('sqlite:bdd.db');

$query = 'CREATE TABLE IF NOT EXISTS referent (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_jeune INTEGER,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    duree TEXT NOT NULL,
    mail TEXT NOT NULL,
    milieu TEXT NOT NULL,
    description TEXT NOT NULL,
    confiance INTEGER,
    bienveillance INTEGER,
    respect INTEGER,
    honnetete INTEGER,
    tolerance INTEGER,
    impartial INTEGER,
    travail INTEGER,
    equipe INTEGER,
    autonomie INTEGER,
    communication INTEGER,
    valid TEXT NOT NULL
)';

// Execute the query
$bdd->exec($query);

if (isset($_POST['Valider'])) { // lorsque le bouton de validation est cliqué

    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['Duree']) && !empty($_POST['mail']) && !empty($_POST['Milieu']) && !empty($_POST['Description'])) { // aucun champ vide
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $duree = htmlspecialchars($_POST['Duree']);
        $mail = htmlspecialchars($_POST['mail']);
        $milieu = htmlspecialchars($_POST['Milieu']);
        $description = htmlspecialchars($_POST['Description']);

        $valid='non validé';

        if (!empty($_POST['savoir'])) {
            $savoir = $_POST['savoir'];
            $confiance = '0';
            $bienveillance = '0';
            $respect = '0';
            $honnetete = '0';
            $tolerance = '0';
            $impartial = '0';
            $travail = '0';
            $equipe = '0';
            $autonomie = '0';
            $communication ='0';

            

            foreach ($savoir as $item) {
                switch ($item) {
                    case '1':
                        $confiance = '1';
                        break;
                    case '2':
                        $bienveillance = '1';
                        break;
                    case '3':
                        $respect = '1';
                        break;
                    case '4':
                        $honnetete = '1';
                        break;
                    case '5':
                        $tolerance = '1';
                        break;
                    case '6':
                        $impartial = '1';
                        break;
                    case '7':
                        $travail = '1';
                        break;
                    case '8':
                        $equipe = '1';
                        break;
                    case '9':
                        $autonomie = '1';
                        break;
                    case '10':
                        $communication = '1';
                        break;
                }
            }
        } else {
            echo 'vide';
        }

        try {
            $insert = $bdd->prepare('INSERT INTO referent (id_jeune, nom, prenom, duree, mail, milieu, description, confiance, bienveillance, respect, honnetete, tolerance, impartial, travail, equipe, autonomie, communication, valid) VALUES(:id_jeune, :nom, :prenom, :duree, :mail, :milieu, :description, :confiance, :bienveillance, :respect, :honnetete, :tolerance, :impartial, :travail, :equipe, :autonomie, :communication, :valid)');

            $insert->bindValue(':id_jeune', $_SESSION['id']);
            $insert->bindValue(':nom', $nom);
            $insert->bindValue(':prenom', $prenom);
            $insert->bindValue(':duree', $duree);
            $insert->bindValue(':mail', $mail);
            $insert->bindValue(':milieu', $milieu);
            $insert->bindValue(':description', $description);
            $insert->bindValue(':confiance', $confiance);
            $insert->bindValue(':bienveillance', $bienveillance);
            $insert->bindValue(':respect', $respect);
            $insert->bindValue(':honnetete', $honnetete);
            $insert->bindValue(':tolerance', $tolerance);
            $insert->bindValue(':impartial', $impartial);
            $insert->bindValue(':travail', $travail);
            $insert->bindValue(':equipe', $equipe);
            $insert->bindValue(':autonomie', $autonomie);
            $insert->bindValue(':communication', $communication);
            $insert->bindValue(':valid', $valid);

            $insert->execute(); 

        //.....email........
            
        //lien
        $lien = "http://localhost:8080/referent.php?id=".$id."&num_ref=".$num_ref;
        // nom jeune
        $nom = $_SESSION["nom"];
        //prenom
        $prenom = $_SESSION["prenom"];
        //nom referent
        $nom_ref = $_POST["nom"];
        //prenom referent
        $prenom_ref = $_POST["prenom"];

        $email = $_POST["mail"];
        $subject = "Demande de référence de ".$nom; 
        $message = "Bonjour ".$prenom_ref." ".$nom_ref.", ".$prenom." ".$nom." vous a envoyé une demande de référence sur Jeunes 6.4. Merci de la remplir en cliquant sur ce lien : ".$lien;



        $mail = new PHPMailer(true);

        try {
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jeunes.6.4@outlook.com';
        $mail->Password = 'w88YDP2F6zLMit5';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
  

        // Set other email parameters (to, subject, message, headers)
        $mail->setFrom('jeunes.6.4@outlook.com');
        //destination
        $mail->addAddress($email);
        $mail->Subject = utf8_decode($subject);
        $mail->Body = utf8_decode($message);
  

        // Send the email
        $mail->send();

  
        echo "<script>if(confirm('Demande envoyé avec succès')){document.location.href='page_jeune_final.php'};</script>";
        } catch (Exception $e) {
        echo "<script>if(confirm('Probleme lors de l'envoie du mail')){document.location.href='page_demande_reference.php};</script>";
        }

            echo 'Votre demande a bien été enregistrée.';
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }




    } else {
        echo 'Veuillez remplir tous les champs obligatoires.';
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="page_demande_reference.css">
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
        <h1>Demande de référence</h1>
    </div>

    <div class="container2">
        <form class="formulaireref" action="#" method="post">
            <div class="middle">
                <br>
                <ul>
                    <li>
                        <label for="Nom">Nom du référent</label>
                        <input type="text" id="nom" name="nom" required>
                    </li>
                    <li>
                        <label for="prenom">Prénom du référent</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </li>
                    <li>
                        <label for="Duree">Durée de l'engagement</label>
                        <input type="text" id="Duree" name="Duree" required>
                    </li>
                    <li>
                        <label for="Milieu">Milieu de l'engagement</label>
                        <input type="text" id="Milieu" name="Milieu" required>
                    </li>
                    <li>
                        <label for="mail">Email du référent</label>
                        <input type="email" id="mail" name="mail" required>
                    </li>
                    <li>
                        <label for="Description">Description de l'engagement</label>
                        <input type="text" id="Description" name="Description" required>
                    </li>
                </ul>
                <input type="submit" name="Valider" value="Valider">
                <br><br>
            
            </div>

            <!--------------------------------------->
            <div class="right">

                <h2 style="color: rgb(247, 4, 194)">MES SAVOIRS ETRE </h2>
    
                <h3 class="titre_encadrer">Je suis*</h3>
                <label for="confiance">
                    <input class="check" type="checkbox" id="confiance" name="savoir[]" value="1"> Confiance
                </label>
                <br>
                <label for="bienveillance">
                    <input class="check" type="checkbox" id="bienveillance" name="savoir[]" value="2"> Bienveillance
                </label>
                <br>
                <label for="respect">
                    <input class="check" type="checkbox" id="respect" name="savoir[]" value="3"> Respect
                </label>
                <br>
                <label for="honnêteté">
                    <input class="check" type="checkbox" id="honnêteté" name="savoir[]" value="4"> Honnêteté
                </label>
                <br>
                <label for="tolerance">
                    <input class="check" type="checkbox" id="tolerance" name="savoir[]" value="5"> Tolérance
                </label>
                <br>
                <label for="Impartial">
                    <input class="check" type="checkbox" id="Impartial" name="savoir[]" value="6"> Impartial
                </label>
                <br>
                <label for="Travail">
                    <input class="check" type="checkbox" id="Travail" name="savoir[]" value="7"> Travail
                </label>
                </br>
                <label for="equipe">
                    <input class="check" type="checkbox" id="equipe" name="savoir[]" value="8"> Travail en équipe
                </label>
                </br>
                <label for="Autonomie">
                    <input class="check" type="checkbox" id="Autonomie" name="savoir[]" value="9"> Autonomie
                </label>
                <br>
                <label for="Communication">
                    <input class="check" type="checkbox" id="Communication" name="savoir[]" value="10"> Communication
                </label>
                <br>
    
                <p style="color: rgb(247, 4, 194)">* Faire 4 choix maximum </p>
            </div>
        </form>
    </div>
    <script>
        var checks = document.querySelectorAll(".check");

        var max = 4;

        for (var i = 0; i < checks.length; i++) {
            checks[i].onclick = selectiveCheck;
        }

        function selectiveCheck(event) {
            var checkedChecks = document.querySelectorAll(".check:checked");
            if (checkedChecks.length >= max + 1)
                return false;
        }
    </script>
</body>

</html>
