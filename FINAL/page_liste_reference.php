<?php



session_start();



require_once('tcpdf/tcpdf.php');



if ($_SESSION['connexion'] != 'jeune') {



    header('location: connexion.php');



    exit(); // Terminer l'exécution du script après la redirection



}

// Connexion à la base de données



$bdd = new PDO('sqlite:bdd.db');



$id_jeune = $_SESSION['id'];
$nom_jeune = $_SESSION['prenom'].' '.$_SESSION['nom'];

function fetch_data()
{
    //récupération des données pour le pdf
    global $id_jeune;
    global $bdd;

    $output = '';

    $createTableQuery = 'CREATE TABLE IF NOT EXISTS referent (
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

    $bdd->exec($createTableQuery);

    // Fetch data from the table
    $selectQuery = "SELECT * FROM referent WHERE id_jeune = :id_jeune";
    $results = $bdd->prepare($selectQuery);
    $results->bindValue(':id_jeune', $id_jeune, PDO::PARAM_INT);
    $results->execute();

    // Loop through the results and generate the table rows
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $output .= '
        <tr>
            <td align="center">Referent: '.$row["prenom"].' '.$row["nom"].'</td>
            <td align="center">Milieu: '.$row["milieu"].'</td>
            <td align="center">Duree: '.$row["duree"].'</td>
            <td align="center">Mail: '.$row["mail"].'</td>
        </tr>
        <tr>
            <td align="center" colspan="4">Description: '.$row["description"].'</td>
        </tr>
        ';

        // Savoir
        $savoir = '';
        if ($row["confiance"] == 1) {
            $savoir .= ' confiance ';
        }
        if ($row["bienveillance"] == 1) {
            $savoir .= ' bienveillance ';
        }
        if ($row["respect"] == 1) {
            $savoir .= ' respect ';
        }
        if ($row["honnetete"] == 1) {
            $savoir .= ' honnetete ';
        }
        if ($row["tolerance"] == 1) {
            $savoir .= ' tolerance ';
        }
        if ($row["travail"] == 1) {
            $savoir .= ' travail ';
        }
        if ($row["autonomie"] == 1) {
            $savoir .= ' autonomie ';
        }
        if ($row["communication"] == 1) {
            $savoir .= ' communication ';
        }

        if ($savoir != '') {
            $output .= '
            <tr>
                <td align="center" colspan="4">Savoir: '.$savoir.'</td>
            </tr>';
        }

        $output .= '<br><br>';
    }

    return $output;
}







$selectedReferences = [];

if (isset($_POST['Pdf'])){

    ob_start(); // Start output buffering
    $id_jeune = $_SESSION['id'];
    $nom_jeune = $_SESSION['prenom'].' '.$_SESSION['nom'];


    // Create new PDF document
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $pdf->SetCreator('Jeunes 6.4');
    $pdf->SetAuthor('Cy-tech');
    $pdf->SetTitle('Vos references');
    $pdf->SetSubject('Reference');
    $pdf->SetKeywords('utilisateur, reference, details');

    // Add a page
    $pdf->AddPage();

    // Set the font and font size
    $pdf->SetFont('helvetica', '', 12);

    // Output the user details
    $html = '
        <table border="1">
        <tr>
            <th colspan="4" align="center">Reference de '.$nom_jeune.'</th>
        </tr>
        <br><br>
    ';

    $html .= fetch_data();

    $html .= '</table>';
    $pdf->writeHTML($html, true, 0, true, false, '');

    // Output the PDF as a file or inline
    $pdf->Output('Vos_references.pdf', 'D');  // 'D' to force download, 'I' to open in the browser

    ob_end_flush(); // Flush and stop output buffering
}

if (isset($_POST['Valider'])) {



    if(!empty($_POST['mail'])){



        if (isset($_POST['references']) && is_array($_POST['references'])) {

        // Parcourir les références sélectionnées

            foreach ($_POST['references'] as $referenceId) {

            // Ajouter l'ID de référence au tableau

                $selectedReferences[] = $referenceId;

            }



            echo $selectedReferences['0'];

        }else{echo "vous n'avez sélectionné aucune référence à envoyer" ;}



// Récupération de l'adresse e-mail

        $consultantEmail = strtolower(htmlspecialchars($_POST['mail']));

    }else{echo "vous n'avez sélectionné aucun mail de consultant";}



}





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







<form method="post" action="">







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



            echo "<td>".$row['valid']."</td>";



            if($row['valid']=='validé'){echo "<td><input type='checkbox' name='references[]' value='".$row['id']."'></td>";}



            echo "</tr>";



        }







        // Fermeture de la connexion à la base de données



        $bdd = null;



        ?>



    </table>



    <div class="mail">

        <label for="mail">MAIL du consultant pour les références séléctionnés:</label>

        <input type="email" id="mail" name="mail">

    </div>





    <input type="submit" name="Valider" value="Valider">
    <br><br>
    <input type="submit" name="Pdf" value="Télécharger toutes les références">



</form>



</body>



</html>



