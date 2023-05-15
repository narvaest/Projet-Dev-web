<?php
   $dest="test_project@aol.com";
   $objet="Rendez-vous";
   $message="
      <font face='arial'>
      Bonjourn
      Prière de se retrouver sur Skype à <b>18h</b> aujourd'hui.n
      Merci et bonne journée.
      </font>
   ";
   $entetes="From: test_project@myyahoo.com";
   $entetes.="Content-Type: text/html; charset=iso-8859-1";
   
   if(mail($dest,$objet,$message,$entetes))
      echo "Mail envoyé avec succès.";
   else
      echo "Un problème est survenu.";
   exit;
?> 