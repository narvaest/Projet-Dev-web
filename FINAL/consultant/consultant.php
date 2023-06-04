<?php
$bdd = new PDO('sqlite:bdd.db');

//$query = "SELECT nom, prenom, date_naissance, mail, reseau_social, mon_engagement_duree FROM jeune";
//$result = $bdd->query($query);
//
//while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//    $nom = $row['nom'];
//    $prenom = $row['prenom'];
//    $dateNaissance = $row['date_naissance'];
//    $mail = $row['mail'];
//    $reseauSocial = $row['reseau_social'];
//    $monEngagementDuree = $row['mon_engagement_duree'];
//}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Consultant</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/consultant.css">
</head>
<body>
<header>
    <img src="./assets/img/jeune64logo.png" id="logo" alt="Logo">

    <div style="flex-direction: column; justify-content: center; align-items: flex-end; flex: 3 1 auto; display: flex;">
        <div id="title">CONSULTANT</div>
        <div id="subtitle">Je donne de la valeur à ton engagement</div>
    </div>
</header>


<div class="navbar">
    <ul>
        <li><a id="jeune" href="#">JEUNE</a></li>
        <li><a id="referent" href="#">RÉFÉRENT</a></li>
        <li><a id="consultant" href="#">CONSULTANT</a></li>
        <li><a id="partenaires" href="#">PARTENAIRES</a></li>
    </ul>
</div>

<div class="title">Validez cet engagement en prenant en compte sa valeur</div>


<div class="outer-container">
    <div id="jeune-container" class="container">
        <div class="top-container">
            <div class="top-left">
                <a id="jeune-title">JEUNE</a>
            </div>
            <div class="top-right">
                <table class="checkbox-table">
                    <tr id="jeune-column-title">
                        <th>Je suis*</th>
                    </tr>
                    <tr id="jeune-column-content">
                        <th>
                            <input checked type="checkbox" class="checkbox" name="checkbox1">Autonome<br>
                            <input checked type="checkbox" class="checkbox" name="checkbox2">Passioné<br>
                            <input checked type="checkbox" class="checkbox" name="checkbox3">Réfléchi<br>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="bottom-container">
            <form>
                <label>Nom : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Prénom : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Email : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Date de naissance : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Réseau social : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Mon engagement : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Durée : </label>
                <input type="text" class="field-name" value=""/><br>
            </form>
        </div>
    </div>

    <div id="referent-container" class="container">
        <div class="top-container">
            <div class="top-left">
                <a id="referent-title">RÉFÉRENT</a>
            </div>
            <div class="top-right">
                <table class="checkbox-table">
                    <tr id="referent-column-title">
                        <th>Je confirme sa (son)*</th>
                    </tr>
                    <tr id="referent-column-content">
                        <th>
                            <input checked type="checkbox" class="checkbox" name="checkbox1">Confiance<br>
                            <input checked type="checkbox" class="checkbox" name="checkbox2">Bienveillance<br>
                            <input checked type="checkbox" class="checkbox" name="checkbox3">Respect<br>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="bottom-container">
            <form>
                <label>Nom : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Prénom : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Email : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Date de naissance : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Réseau social : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Présentation : </label>
                <input type="text" class="field-name" value=""/><br>
                <label>Durée : </label>
                <input type="text" class="field-name" value=""/><br>
            </form>
        </div>
    </div>
</div>

</body>
</html>
