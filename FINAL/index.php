<?php
    session_start();
    if(!isset($_SESSION['connexion'])){
        $_SESSION['connexion']='visiteur';
    }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Page d'accueil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css" type="text/css">
</head>

<body>
    <div style="margin-bottom: 10%;">

        <r><center>Pour faire de l'engagement</center><br></r>
        <r><center>une valeur !</center></r>
        <img src="logo2.png" alt="logo.jpg">
        <p>...l'expression d'un potentiel,<br>
            la promesse d'une richesse !
        </p>
        <div id="my-div">
            <a href="page2.php" class="fill-div">ENTRER</a>
        </div>
    </div>
</body>
<footer style="bottom:0;position: fixed;">
    <small>JEUNES 6.4 est un dispositif de valorisation de l’engagement des jeunes en Pyrénées-<br>
        Atlantiques soutenu par l’Etat, le Conseil général, le conseil régional, les CAF Béarn-Soule et<br>
        Pays Basque, la MSA, l’université de Pau et des pays de l’Adour, la CPAM.</small>
</footer>

</html>
