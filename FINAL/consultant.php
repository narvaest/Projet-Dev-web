<?php

$bdd = new PDO('sqlite:bdd.db');





$key='~nu!j_EBK,:XE2e{kQ!bhuQ9j]%SlF]z3L^Qy.Q[Gn?NCe&lt;BBy&gt;^LHv~1P]nq~&amp;;';







    function decode($string, $key) {



        $key = sha1($key); // Génère une clé de chiffrement à partir de la clé fournie en utilisant SHA-1



        $strLen = strlen($string); // Longueur de la chaîne chiffrée



        $keyLen = strlen($key); // Longueur de la clé de chiffrement



        $j = 0; // Indice pour parcourir la clé



        $hash = ''; // Chaîne déchiffrée résultante



        for ($i = 0; $i < $strLen; $i += 2) {



            $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16)); // Convertit la représentation base 36 inversée en décimal



            if ($j == $keyLen) { $j = 0; } // Réinitialise l'indice de la clé si on atteint sa fin



            $ordKey = ord(substr($key, $j, 1)); // Récupère l'ordre du caractère correspondant à l'index $j de la clé



            $j++; // Incrémente l'indice de la clé



            $hash .= chr($ordStr - $ordKey); // Soustrait l'ordre de la clé de l'ordre du caractère et ajoute le caractère déchiffré à la chaîne déchiffrée



        }



        return $hash;



    }



$id_jeune = decode($_GET['id'],$key);









$statement = $bdd->prepare("SELECT * FROM utilisateur WHERE id = :id_jeune");



$statement->bindValue(':id_jeune', $id_jeune);



$statement->execute();







$jeune = $statement->fetch();



?>





<!DOCTYPE html>

<html lang="fr">

<head>

    <title>Consultant</title>

    <link rel="stylesheet" type="text/css" href="consultant.css">

</head>

<body>

<header>

    <img src="logo2.png" id="logo" alt="Logo">



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

        <li><a id="partenaires" href="page_partenaire_final.html">PARTENAIRES</a></li>

    </ul>

</div>



<div class="title">consultez cet engagement en prenant en compte sa valeur</div>









<div class="outer-container">



<div id="jeune-container" class="container">



    <div class="top-container">



        <div class="top-left">



            <a id="jeune-title">JEUNE</a>



        </div>







    </div>





    <div class="bottom-container">

        <form>

            <label>Nom :</label>

            <input type="text" class="field-name" value="" placeholder="<?php echo $jeune['nom']; ?>"/><br>



            <label>Prénom :</label>

            <input type="text" class="field-name" value="" placeholder="<?php echo $jeune['prenom']; ?>"/><br>



            <label>Email :</label>

            <input type="text" class="field-name" value="" placeholder="<?php echo $jeune['mail']; ?>"/><br>



            <label>Date de naissance :</label>

            <input type="text" class="field-name" value="" placeholder="<?php echo $jeune['date']; ?>"/><br>



        </form>

    </div>

</div><br>







<?php



$selectedReferences = $_GET['num_ref'];





    foreach($selectedReferences as $items){



        $query = "SELECT * FROM referent WHERE id_jeune = :id AND id = :num_ref" ;



        $statement2 = $bdd->prepare($query);

    

        $statement2->bindValue(':id', $id_jeune);

        $statement2->bindValue(':num_ref', $items);

    

        $statement2->execute();





    $ref = $statement2->fetch();



// Affichage des demandes de références





    echo '<div id="referent-container" class="container">';



    echo '<div class="top-container">';



    echo '<div class="top-left">';

    echo '<a id="referent-title">REFERENT</a>'; echo '<br>';

    echo '<form id="form1" method="post">';



    echo '<label>Nom :</label>';

    echo '<input type="text" class="field-name" name="nom" value="' . $ref['nom'] . '" /><br>';



    echo '<label>Prénom :</label>';

    echo '<input type="text" class="field-name" name="prenom" value="' . $ref['prenom'] . '" /><br>';



    echo '<label>Email :</label>';

    echo '<input type="text" class="field-name" name="mail" value="' . $ref['mail'] . '" /><br>';



    echo '<label>Milieu de l\'engagement :</label>';

    echo '<input type="text" class="field-name" name="milieu" value="' . $ref['milieu'] . '" /><br>';



    echo '<label>Durée engagement :</label>';

    echo '<input type="text" class="field-name" name="duree" value="' . $ref['duree'] . '" /><br>';



    echo '<label>Description :</label>';

    echo '<input type="text" class="field-name" name="description" value="' . $ref['description'] . '" /><br>';



    echo '</div>';



    echo '<div class="top-right">';

    

    echo '<div class="formulaire2" >';



    echo '<h2 style="color: rgba(197, 214, 6, 0.479)"> SAVOIRS ETRE </h2>';



    echo '<label for="confiance">';

    echo '<input class="check" type="checkbox" id="confiance" name="savoir[]" value="1" ' . ($ref['confiance'] == 1 ? 'checked' : '') . ' > Confiance';

    echo '</label><br>';



    echo '<label for="bienveillance">';

    echo '<input class="check" type="checkbox" id="bienveillance" name="savoir[]" value="2" ' . ($ref['bienveillance'] == 1 ? 'checked' : '') . ' > Bienveillance';

    echo '</label><br>';



    echo '<label for="respect">';

    echo '<input class="check" type="checkbox" id="respect" name="savoir[]" value="3" ' . ($ref['respect'] == 1 ? 'checked' : '') . ' > Respect';

    echo '</label><br>';



    echo '<label for="honnêteté">';

    echo '<input class="check" type="checkbox" id="honnêteté" name="savoir[]" value="4" ' . ($ref['honnetete'] == 1 ? 'checked' : '') . ' > Honnêteté';

    echo '</label><br>';



    echo '<label for="tolerance">';

    echo '<input class="check" type="checkbox" id="tolerance" name="savoir[]" value="5" ' . ($ref['tolerance'] == 1 ? 'checked' : '') . ' > Tolérance';

    echo '</label><br>';



    echo '<label for="Impartial">';

    echo '<input class="check" type="checkbox" id="Impartial" name="savoir[]" value="6" ' . ($ref['impartial'] == 1 ? 'checked' : '') . ' > Impartial';

    echo '</label><br>';



    echo '<label for="Travail">';

    echo '<input class="check" type="checkbox" id="Travail" name="savoir[]" value="7" ' . ($ref['travail'] == 1 ? 'checked' : '') . ' > Travail';

    echo '</label><br>';



    echo '<label for="equipe">';

    echo '<input class="check" type="checkbox" id="equipe" name="savoir[]" value="8" ' . ($ref['equipe'] == 1 ? 'checked' : '') . ' > Travail en équipe';

    echo '</label><br>';



    echo '<label for="Autonomie">';

    echo '<input class="check" type="checkbox" id="Autonomie" name="savoir[]" value="9" ' . ($ref['autonomie'] == 1 ? 'checked' : '') . ' > Autonomie';

    echo '</label><br>';



    echo '<label for="Communication">';

    echo '<input class="check" type="checkbox" id="Communication" name="savoir[]" value="10" ' . ($ref['communication'] == 1 ? 'checked' : '') . ' > Communication';

    echo '</label><br>';





    echo '</div>';



    echo '</div>';



    echo '</div>';



    echo '</div>';



    



    echo '</div><br>';

    }

?>







</body>

</html>

