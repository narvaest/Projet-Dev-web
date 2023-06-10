<?php

session_start();



if ($_SESSION['connexion'] != 'jeune') {

    header('location: connexion.php');

    exit(); // Terminer l'exécution du script après la redirection

}



// Connexion à la base de données

$bdd = new PDO('sqlite:bdd.db');



?>



<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="page_liste_reference.css">

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



    <h1>Liste des demandes de références</h1>



<form method="post" action="traitement.php">



<table class="table">

    <tr>
        <th class="mid">Nom</th>

        <th class="mid">Prénom</th>

        <th class="mid">Durée</th>

        <th class="long">Email</th>

        <th class="mid">Milieu</th>

        <th class="short">Validation</th>

        <th class="short">Sélectionner</th>

    </tr>



        <?php

        // Récupération des demandes de références

        $query = "SELECT * FROM referent WHERE id_jeune = :id";

        $statement = $bdd->prepare($query);

        $statement->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);

        $statement->execute();



        // Affichage des demandes de références

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

            echo "<tr>";

            echo "<td>".$row['nom']."</td>";

            echo "<td>".$row['prenom']."</td>";

            echo "<td>".$row['duree']."</td>";

            echo "<td>".$row['mail']."</td>";

            echo "<td>".$row['milieu']."</td>";

            echo "<td>".$row['validation']."</td>";

            if($row['validation']=='validé'){echo "<td><input type='checkbox' name='references[]' value='".$row['id']."'></td>";}

            echo "</tr>";

        }



        // Fermeture de la connexion à la base de données

        $bdd = null;

        ?>

    </table>

    <div class="mail">
        <label for="mail">MAIL du consultant pour les références séléctionnés:</label>
        <input type="email" id="mail" name="mail" value=''>
    </div>


    <input type="submit" name="valider" value="Valider">

</form>

</body>

</html>

