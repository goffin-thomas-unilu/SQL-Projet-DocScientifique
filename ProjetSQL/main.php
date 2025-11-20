<?php

// on importe l'autoload ainsi que le dispatcher
require_once 'vendor/autoload.php';
require_once 'Dispatcher.php';
use sql\action;


// affichage du menu
echo <<<TEXT
    <h1>-- Menu -- </h1>
    <ul>

        <li><a href="?action=ArtAuteur"> Lister les articles d'un auteur\n</a></li>

        <li><a href="?action=CoAuteur"> Afficher les co-auteurs d'un chercheur</a></li>

        <li><a href="?action=ListLaboCher"> Afficher les laboratoires des chercheurs</a></li>
        
        <br>

        <li><a href="?action=ListCherAnnoterMin">Chercheurs ayant annoté un minimum d'articles</a></li>
        
        <li><a href="?action=Moy_Note_Cher"> Calculer la moyenne des notes d'un chercheur. </a></li> 
        
        <li><a href="?action=Stat_Chercheur"> Statistiques des chercheurs par laboratoire </a></li>
        
        <li><a href="?action=Verif_NoteMax_Labo"> Vérifier la note maximale d'un article.</a></li>

    </ul>
    <hr>
    TEXT;

// Création du Dispatcher et détermine l'action à réalisé si une variable d'url nommé action existe
if (isset($_GET['action'])){
    $action = (isset($_GET['action']))? $_GET['action'] : '';
    echo "Action choisie : ".$action ."<br>";
    $app = new Dispatcher($action);
    $app->run();

}
else{
    echo"Veuillez choisir une action à réaliser";
}


// deconnexion de la base de donnée
$connexion=null;