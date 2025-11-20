<?php
declare(strict_types=1);
// on définit la classe ArtAuteur dans le namespace action 
namespace sql\action;
class ArtAuteurAction extends Action {
    function execute() {
        print("Liste d'article écrit par un Auteur <br>");
        
        print("<p style='color: #228CFD';>Donnez le nom d'un Chercheur afin d'obtenir la liste des articles qu'il a réalisé ↓</p>");
        // on vérifie qu'une variable d'url existe
       if ($this->http_method === 'GET'){
            echo <<<FIN
                <!doctype html>
                <html lang='fr'>
                <head>
                    <title> Article Auteur SQL</title>
                </head>

                <body>
                    <form method="POST" id="form1" action="?action=ArtAuteur">
                        <input type="text"
                            name="Nom_Chercheur"
                            placeholder="Nom du Chercheur">
                        <button type="submit" > Envoyer </button>
                        
                FIN;
       }
        else {
            // Récupération de la variable en POST
            $nomChercheur =$_POST[ 'Nom_Chercheur' ] ; 
            // création de l'objet RepositorySQL
            $rep = new RepositorySQL();
            // appel de la méthode ArticleAuteur
            $rep->ArticleAuteur($nomChercheur);
        }
    }
}