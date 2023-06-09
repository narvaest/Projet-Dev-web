<?php



    $bdd = new PDO('sqlite:bdd.db');



    function update($new, $session){

        if(empty($new)){

            return $session;

        } else{

            return htmlspecialchars($new);

        }

    }



    $num_ref = 1;

    $id_jeune = 1;



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

        $ref['date'] = update($_POST['date'], $ref['date']);

        $ref['mail'] = update($_POST['mail'], $ref['mail']);

        $ref['mail'] = strtolower($ref['mail']);

        $ref['duree'] = update($_POST['duree'], $ref['duree']);

        $ref['milieu'] = update($_POST['milieu'], $ref['milieu']);

        $validation = "validé";



        $commentaire = $_POST['commentaire'];



        $bdd->exec("UPDATE referent SET nom='{$ref['nom']}', prenom='{$ref['prenom']}', date='{$ref['date']}', mail='{$ref['mail']}', duree='{$ref['duree']}', milieu='{$ref['milieu']}', validation='$validation'  WHERE id_jeune = :id_jeune AND id = :num_ref");

        $bdd->exec();





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

    header('Location: confirmation.php');

}

?>



<!DOCTYPE html>

<html lang="fr">



<head>

    <title>Référent</title>

    <link rel="stylesheet" type="text/css" href="./assets/css/referent.css">

</head>



<body>

    <header>

        <img src="./assets/img/jeune64logo.png" id="logo" alt="Logo">

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

                    </form>

                    <form id="form3" class="formulaire3" method="post">

                        <h3 class="titre_encadrer1">COMMENTAIRES</h3>

                        <div class="align-label-input">

                            <label for="commentaire"></label>

                            <input type="commentaire" id="commentaire" name="commentaire" required>

                        </div>

                    </form>

                </div>



                <div class="top-right">

                    <h2 style="color: rgba(197, 214, 6, 0.479)">MES SAVOIRS ETRE </h2>

                    <form id="form2" class="formulaire2" method="post">

                        <h3 class="titre_encadrer">Je suis*</h3>

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

                    </form>



                    <button onclick="submitForms()" name="Valider">Valider</button>



                    <script langage="javascript">

                    function submitForms() {

                        document.getElementById("form1").submit();

                        document.getElementById("form2").submit();

                        document.getElementById("form3").submit();

                    }

                    </script>





                </div>

            </div>

            <div class="bottom-container">

            </div>

        </div>

    </div>

</body>

</html>

