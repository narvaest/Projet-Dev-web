<?php
session_start();

if ($_SESSION['connexion'] != 'jeune') {
    header('location: connexion.php');
    exit();
}

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
    honnêteté INTEGER,
    tolerance INTEGER,
    impartial INTEGER,
    travail INTEGER,
    equipe INTEGER,
    autonomie INTEGER,
    communication INTEGER
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

        if (!empty($_POST['savoir'])) {
            $savoir = $_POST['savoir'];
            $confiance = '0';
            $bienveillance = '0';
            $respect = '0';
            $honnêteté = '0';
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
                        $honnêteté = '1';
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
            $insert = $bdd->prepare('INSERT INTO referent (id_jeune, nom, prenom, duree, mail, milieu, description, confiance, bienveillance, respect, honnêteté, tolerance, impartial, travail, equipe, autonomie, communication) VALUES(:id_jeune, :nom, :prenom, :duree, :mail, :milieu, :description, :confiance, :bienveillance, :respect, :honnêteté, :tolerance, :impartial, :travail, :equipe, :autonomie, :communication)');

            $insert->execute(array(
                'id_jeune' => $_SESSION['id'],
                'nom' => $nom,
                'prenom' => $prenom,
                'duree' => $duree,
                'mail' => $mail,
                'milieu' => $milieu,
                'description' => $description,
                'confiance' => $confiance,
                'bienveillance' => $bienveillance,
                'respect' => $respect,
                'honnêteté' => $honnêteté,
                'tolerance' => $tolerance,
                'impartial' => $impartial,
                'travail' => $travail,
                'equipe' => $equipe,
                'autonomie' => $autonomie,
                'communication' => $communication
            ));
            echo "test";
        } catch (PDOException $e) {
            echo "Erreur => " . $e->getMessage();
            error_log($e->getMessage());
        }
    } else {
        echo 'Merci de remplir tous les champs.';
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

    <!--------------------------------------->
    <div class="menunav">
        <div class="nav">
            <ul class="navi">
                <li><a href="" title="aller a jeune"><mark>Jeune</mark></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="page_jeune_final.html" title="monprofil">Mon profil</a>
                        </li>
                        <li>
                            <a href="page_demande_reference.html" title="réference">Demande de référence</a>
                        </li>
                        <li>
                            <a href="page_liste_reference.html" title="liste">Liste de référence</a>
                        </li>
                    </ul>
                </li>
                <li>Référent</li>
                <li>Consultant</li>
                <li>Partenaire</li>
                </ul>
        </div>
    </div>

        <!--------------------------------------->
    <br>
    <div class="subtitle">
        <h1>Demande de référence</h1>
    </div>

     <!--------------------------------------->
    <div class="container2">
        <div class="middle">
            <form class="formulaireref" action="#" method="post">
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
                <input type="submit" value="Valider">
            </form>
            
        </div>

            <!--------------------------------------->
            <div class="right">

                <h2 style="color: rgb(247, 4, 194)">MES SAVOIRS ETRE </h2>
    
                <form class="formulaire2">
    
                    <h3 class="titre_encadrer">Je suis*</h3>
                    <label for="confiance">
                        <input class="check" type="checkbox" id="confiance" name="savoir" value="1"> Confiance
                    </label><br>
                    <label for="bienveillance">
                        <input class="check" type="checkbox" id="bienveillance" name="savoir" value="2"> Bienveillance
                    </label><br>
                    <label for="respect">
                        <input class="check" type="checkbox" id="respect" name="savoir" value="3"> Respect
                    </label><br>
                    <label for="honnetete">
                        <input class="check" type="checkbox" id="honnetete" name="savoir" value="4"> Honnêteté
                    </label><br>
                    <label for="tolerance">
                        <input class="check" type="checkbox" id="tolerance" name="savoir" value="5"> Tolérance
                    </label><br>
                    <label for="impartial">
                        <input class="check" type="checkbox" id="impartial" name="savoir" value="6"> Impartial
                    </label><br>
                    <label for="travail">
                        <input class="check" type="checkbox" id="travail" name="savoir" value="7"> Travail
                    </label><br>
                    <label for="esprit d equipe">
                        <input class="check" type="checkbox" id="esprit d equipe" name="savoir" value="8"> Esprit d'équipe
                    </label><br>
                    <label for="autonomie">
                        <input class="check" type="checkbox" id="autonomie" name="savoir" value="9"> Autonomie
                    </label><br>
                    <label for="communication">
                        <input class="check" type="checkbox" id="communication" name="savoir" value="10"> Communication
                    </label></br>
                </form>
    
                <p style="color: rgb(247, 4, 194)">* Faire 4 choix maximum </p>
                <input type="submit" value="Valider">
            </div>


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
