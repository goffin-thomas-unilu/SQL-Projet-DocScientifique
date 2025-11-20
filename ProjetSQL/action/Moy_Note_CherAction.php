<?php
declare(strict_types=1);
namespace sql\action;
class Moy_Note_CherAction extends Action {
    public function execute() {
        print("<p style='color: #228CFD';>Donnez le nom d'un chercheur afin d'obtenir sa moyenne de note ↓</p>");

        // on vérifie qu'une variable d'url existe
        if ($this->http_method === 'GET'){
            echo <<<FIN
                <!doctype html>
                <html lang='fr'>
                <head>
                    <title> Article Min SQL</title>
                </head>

                <body>
                    <form method="POST" id="form1" action="?action=Moy_Note_Cher">
                        <input type="text"
                            name="Nom_chercheur"
                            placeholder="Nom chercheur">
                        <button type="submit" > Envoyer </button>
                        
                FIN;
        print("<br>");
        }
        else {
            // récupération de la variable en POST
            $nomC =$_POST[ 'Nom_chercheur' ] ; 
            // création d'un nouvel objet RepositorySQL
            $rep = new RepositorySQL();
            // appel de la méthode MoyNoteCher de l'objet $rep
            $rep->MoyNoteCher($nomC);
        
        }  
    }
}