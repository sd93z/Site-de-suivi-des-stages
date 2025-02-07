<?php
session_start(); 
include '_conf.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Stages</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<?php

//si il y a une variable de formulaire POST 'envoi' (c'est le nom du bouton submit de la page d'index')
if (isset($_POST['envoi'])) 
{
   
    //je récupère mes variable login et mdp envoyé par le formulaire POST de l'index
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    //on prépare la connexion avec les variables mis dans le fichier conf
    $connexion = mysqli_connect($serveurBDD,$userBDD,$mdpBDD,$nomBDD);

     //*************************
    //****** selection de tous les champs de la table UTILISATEUR en faisant une restriction sur le login et mot de passe(md5)
    //*************************
    $requete="Select * from utilisateur WHERE login = '$login' AND motdepasse= '$mdp'"; //on initialise la requête
    $resultat = mysqli_query($connexion, $requete); // on exécute la requête dans la variable resultat
    $trouve=0; //initialisation d'une variable trouve à 0 qui servira pour voir si on a trouvé une ligne dans la requête
    while($donnees = mysqli_fetch_assoc($resultat)) // pour chaque ligne dans la requête je stock ça dans un tableau $donnees avec comme colonne le nom des champs de la requête SQL
      {
        $trouve=1; //si on rentre dans la boucle c'est qu'on a trouvé !
        $type=$donnees['type'];
        $login=$donnees['login'];
        $id=$donnees['num'];
        // je créé mes sessions = variable qui reste d'une page à l'autre
        $_SESSION["id"]=$id; 
        $_SESSION["login"]=$login;
        $_SESSION["type"]=$type;
      }
    //**** fin SQL

    if($trouve==0)
    {
        echo "erreur de connexion : login/mdp non présent dans la BDD <br>";
        echo "<a href='index.php'>Retourner à l'index";
    }
}



//*************************
//****** si il y a une valeur de session Login cela signifie que la connexion est présente
//*************************
if (isset($_SESSION["login"]))
 
    {
        if($_SESSION["type"]==0) //si c'est un élève donc que type==0
        {
            include '_menuEleve.php';
      
            echo "bienvenue sur le compte élève <br> <br>";
            echo "Vous êtes connecté en tant que ".$_SESSION["login"]."<br> <br>";
         
        }
        else
        {
            include '_menuProf.php';

            echo "vous êtes un prof<br>";
           
        }
    }


?>
</body>
</html>
