<?php
declare(strict_types=1);
namespace sql\action;
class CoAuteurAction extends Action {
    public function execute() {
        print("<br>Affichage de la liste des co-auteurs ayant travaillé avec un chercheur donné <br>");
        
        print("<p style='color: #228CFD';>Donnez le nom d'un Chercheur afin d'obtenir la liste des co-auteurs ayant travaillé avec lui ↓</p>");
        
        // on vérifie qu'une variable d'url existe
       if ($this->http_method === 'GET'){
            echo <<<FIN
                <!doctype html>
                <html lang='fr'>
                <head>
                    <title> Co-Auteur SQL</title>
                </head>

                <body>
                    <form method="POST" id="form1" action="?action=CoAuteur">
                        <input type="text"
                            name="Nom_Chercheur_co"
                            placeholder="Nom du Chercheur">
                        <button type="submit" > Envoyer </button>
                        
                FIN;
       }
        else {
            // récupération de la variable POST
            $nomChercheur_co =$_POST[ 'Nom_Chercheur_co' ] ; 
            // instanciation de l'objet RepositorySQL
            $rep = new RepositorySQL();
            // appel de la méthode CoAuteur de l'objet $rep
            $rep->CoAuteur($nomChercheur_co);
        }
    }
}