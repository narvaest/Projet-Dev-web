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





    function update($new, $session){







        if(empty($new)){







            return $session;







        } else{







            return htmlspecialchars($new);







        }







    }







    $id_jeune = decode($_GET['id'], $key);







    $num_ref = decode($_GET['num_ref'], $key);















    $statement = $bdd->prepare("SELECT * FROM referent WHERE id_jeune = :id_jeune AND id = :num_ref");















    $statement->bindValue(':id_jeune', $id_jeune);



    $statement->bindValue(':num_ref', $num_ref);







    $statement->execute();







    $ref = $statement->fetch();















    $statement2 = $bdd->prepare("SELECT * FROM utilisateur WHERE id = :id_jeune");







    $statement2->bindValue(':id_jeune', $id_jeune);







    $statement2->execute();















    $jeune = $statement2->fetch();



    











    if(isset($_POST['Valider'])){







        







         $ref['nom'] = update($_POST['nom'], $ref['nom']);







         $ref['prenom'] = update($_POST['prenom'], $ref['prenom']);







         $ref['mail'] = update($_POST['mail'], $ref['mail']);







         $ref['mail'] = strtolower($ref['mail']);







         $ref['duree'] = update($_POST['duree'], $ref['duree']);







         $ref['milieu'] = update($_POST['milieu'], $ref['milieu']);







         $valid = "validé";











        







































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











        if (!empty($_POST['savoir'])) {











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



    }

    $statement = $bdd->prepare("UPDATE referent SET nom=:nom, prenom=:prenom, mail=:mail, duree=:duree, milieu=:milieu, valid=:valid, confiance=:confiance, bienveillance=:bienveillance, respect=:respect, honnetete=:honnetete, tolerance=:tolerance, impartial=:impartial, travail=:travail, equipe=:equipe, autonomie=:autonomie, communication=:communication WHERE id_jeune = :id_jeune AND id = :num_ref");



    $statement->bindValue(':nom', $ref['nom']);

    $statement->bindValue(':prenom', $ref['prenom']);

    $statement->bindValue(':mail', $ref['mail']);

    $statement->bindValue(':duree', $ref['duree']);

    $statement->bindValue(':milieu', $ref['milieu']);

    $statement->bindValue(':valid', $valid);

    $statement->bindValue(':confiance', $confiance);

    $statement->bindValue(':bienveillance', $bienveillance);

    $statement->bindValue(':respect', $respect);

    $statement->bindValue(':honnetete', $honnetete);

    $statement->bindValue(':tolerance', $tolerance);

    $statement->bindValue(':impartial', $impartial);

    $statement->bindValue(':travail', $travail);

    $statement->bindValue(':equipe', $equipe);

    $statement->bindValue(':autonomie', $autonomie);

    $statement->bindValue(':communication', $communication);

    $statement->bindValue(':id_jeune', $id_jeune);

    $statement->bindValue(':num_ref', $num_ref);



    $statement->execute();



    header('Location: confirmation.php');







}







?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Référent</title>
    <link rel="stylesheet" type="text/css" href="referent.css">
</head>
<body>
    <header>
        <img src="jeune64logo.png" id="logo" alt="Logo">
        <div style="flex-direction: column; justify-content: center; align-items: flex-end; flex: 3 1 auto; display: flex;">
            <div id="title">RÉFÉRENT</div>
            <div id="subtitle">Je confirme la valeur de ton engagement</div>
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

    <div class="title">Confirmez cette expérience et ce que vous avez<br>
    pu constater au contact de ce jeune.</div>

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
                    <input type="text" class="field-name" value="" placeholder='<?php echo $jeune['nom'] ?>'/><br>
                    <label>Prénom :</label>
                    <input type="text" class="field-name" value="" placeholder='<?php echo $jeune['prenom'] ?>'/><br>
                    <label>Email :</label>
                    <input type="text" class="field-name" value="" placeholder='<?php echo $jeune['mail'] ?>'/><br>
                    <label>Date de naissance :</label>
                    <input type="text" class="field-name" value="" placeholder='<?php echo $jeune['date'] ?>'/><br>
                    <label>Milieu de l'engagement :</label>
                    <input type="text" class="field-name" value="" placeholder='<?php echo $ref['milieu'] ?>'/><br>
                    <label>Durée engagement :</label>
                    <input type="text" class="field-name" value="" placeholder='<?php echo $ref['duree'] ?>'/><br>
                </form>
            </div>
        </div>

        <div id="referent-container" class="container">
            <div class="top-container">
                <div class="top-left">
                    <a id="referent-title">RÉFÉRENT</a>
                    <form id="form1" method="post">
                        <label>Nom :</label>
                        <input type="text" class="field-name" name="nom" value="<?php echo $ref['nom'] ?>" /><br>
                        <label>Prénom :</label>
                        <input type="text" class="field-name" name="prenom" value="<?php echo $ref['prenom'] ?>" /><br>
                        <label>Email :</label>
                        <input type="text" class="field-name" name="mail" value="<?php echo $ref['mail'] ?>" /><br>
                        <label>Milieu de l'engagement :</label>
                        <input type="text" class="field-name" name="milieu" value="<?php echo $ref['milieu'] ?>" /><br>
                        <label>Durée engagement :</label>
                        <input type="text" class="field-name" name="duree" value="<?php echo $ref['duree'] ?>" /><br>
                    
                </div>
                <div class="top-right">
                    <div class="formulaire2">
                        <h3 class="titre_encadrer">SAVOIR ETRE</h3>
                        <label for="confiance">
                            <input class="check" type="checkbox" id="confiance" name="savoir[]" value="1" <?php if($ref['confiance']==1){echo 'checked';}?>> Confiance
                        </label>
                        <br>
                        <label for="bienveillance">
                            <input class="check" type="checkbox" id="bienveillance" name="savoir[]" value="2" <?php if($ref['bienveillance']==1){echo 'checked';}?>> Bienveillance
                        </label>
                        <br>
                        <label for="respect">
                            <input class="check" type="checkbox" id="respect" name="savoir[]" value="3" <?php if($ref['respect']==1){echo 'checked';}?>> Respect
                        </label>
                        <br>
                        <label for="honnêteté">
                            <input class="check" type="checkbox" id="honnêteté" name="savoir[]" value="4" <?php if($ref['honnetete']==1){echo 'checked';}?>> Honnêteté
                        </label>
                        <br>
                        <label for="tolerance">
                            <input class="check" type="checkbox" id="tolerance" name="savoir[]" value="5" <?php if($ref['tolerance']==1){echo 'checked';}?>> Tolérance
                        </label>
                        <br>
                        <label for="Impartial">
                            <input class="check" type="checkbox" id="Impartial" name="savoir[]" value="6" <?php if($ref['impartial']==1){echo 'checked';}?>> Impartial
                        </label>
                        <br>
                        <label for="Travail">
                            <input class="check" type="checkbox" id="Travail" name="savoir[]" value="7" <?php if($ref['travail']==1){echo 'checked';}?>> Travail
                        </label>
                        </br>
                        <label for="equipe">
                            <input class="check" type="checkbox" id="equipe" name="savoir[]" value="8" <?php if($ref['equipe']==1){echo 'checked';}?>> Travail en équipe
                        </label>
                        </br>
                        <label for="Autonomie">
                            <input class="check" type="checkbox" id="Autonomie" name="savoir[]" value="9" <?php if($ref['autonomie']==1){echo 'checked';}?>> Autonomie
                        </label>
                        <br>
                        <label for="Communication">
                            <input class="check" type="checkbox" id="Communication" name="savoir[]" value="10" <?php if($ref['communication']==1){echo 'checked';}?>> Communication
                        </label>
                        <br>
                        <p>* Faire 4 choix maximum </p>
                        <br>
                        <input type="submit" name="Valider" value="Valider">
                    </div>
                    </form>
                </div>
                <div class="top-text">
                    <p><b>JEUNES 6.4 est un programme soutenu par plusieurs acteurs institutionnels et organisations en Pyrénées-Atlantiques,<br>
                    visant à valoriser l'engagement des jeunes. Parmi les partenaires impliqués figurent l'État, le Conseil général,<br>
                    le conseil régional, les CAF Béarn-Soule et Pays Basque, la MSA, l'université de Pau et des pays de l'Adour,<br>
                    ainsi que la CPAM. Le dispositif vise à reconnaître et promouvoir les actions et initiatives entreprises <br>
                    par les jeunes dans différents domaines.</b></p>
                    </div>
                </div>
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
