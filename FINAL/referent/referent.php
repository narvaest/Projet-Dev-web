<?php
$bdd = new PDO('sqlite:bdd.db');
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
                    <input type="text" class="field-name" value="" /><br>
                    <label>Prénom : </label>
                    <input type="text" class="field-name" value="" /><br>
                    <label>Email : </label>
                    <input type="text" class="field-name" value="" /><br>
                    <label>Date de naissance : </label>
                    <input type="text" class="field-name" value="" /><br>
                    <label>Milieu de l'engagement : </label>
                    <input type="text" class="field-name" value="" /><br>
                    <label>Mon engagement : </label>
                    <input type="text" class="field-name" value="" /><br>
                    <label>Durée : </label>
                    <input type="text" class="field-name" value="" /><br>
                </form>
            </div>
        </div>

        <div id="referent-container" class="container">
            <div class="top-container">
                <div class="top-left">
                    <a id="referent-title">RÉFÉRENT</a>

                    <form>
                        <label>Nom : </label>
                        <input type="text" class="field-name" value="" /><br>
                        <label>Prénom : </label>
                        <input type="text" class="field-name" value="" /><br>
                        <label>Email : </label>
                        <input type="text" class="field-name" value="" /><br>
                        <label>Date de naissance : </label>
                        <input type="text" class="field-name" value="" /><br>
                        <label>Réseau social : </label>
                        <input type="text" class="field-name" value="" /><br>
                        <label>Présentation : </label>
                        <input type="text" class="field-name" value="" /><br>
                        <label>Durée : </label>
                        <input type="text" class="field-name" value="" /><br>
                    </form>

                    <form class="formulaire3">
                        <h3 class="titre_encadrer1">COMMENTAIRES</h3>
                        <div class="align-label-input">
                            <label for="commentaire"></label>
                            <input type="commentaire" id="commentaire" name="commentaire" required>
                        </div>
                    </form>
                </div>

                <div class="top-right">
                    <h2 style="color: rgba(197, 214, 6, 0.479)">MES SAVOIRS ETRE </h2>

                    <form class="formulaire2">
                        <h3 class="titre_encadrer">Je suis*</h3>
                        <label1 for="confiance">
                            <input class="check" type="checkbox" id="confiance" name="savoir" value="1"> Confiance
                        </label1><br>
                        <label1 for="bienveillance">
                            <input class="check" type="checkbox" id="bienveillance" name="savoir" value="2"> Bienveillance
                        </label1><br>
                        <label1 for="respect">
                            <input class="check" type="checkbox" id="respect" name="savoir" value="3"> Respect
                        </label1><br>
                        <label1 for="honnêteté">
                            <input class="check" type="checkbox" id="honnêteté" name="savoir" value="4"> Honnêteté
                        </label1><br>
                        <label1 for="tolerance">
                            <input class="check" type="checkbox" id="tolerance" name="savoir" value="5"> Tolérance
                        </label1><br>
                        <label1 for="bienveillance">
                            <input class="check" type="checkbox" id="bienveillance" name="savoir" value="6"> bienveillance
                        </label1><br>
                        <label1 for="Respect">
                            <input class="check" type="checkbox" id="Respect" name="savoir" value="7"> Respect
                        </label1><br>
                        <label1 for="Juste">
                            <input class="check" type="checkbox" id="Juste" name="savoir" value="8">Juste
                        </label1><br>
                        <label1 for="Impartial">
                            <input class="check" type="checkbox" id="Impartial" name="savoir" value="9">Impartial
                        </label1><br>
                        <label1 for="Travail">
                            <input class="check" type="checkbox" id="Travail" name="savoir" value="10"> Travail
                        </label1></br>
                    </form>

                    <button class="validateForms">Valider</button>
                </div>
            </div>
            <div class="bottom-container">

            </div>
        </div>
    </div>

</body>

</html>