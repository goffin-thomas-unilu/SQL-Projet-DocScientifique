<?php
declare(strict_types=1);
namespace sql\action;

class ListCherAnnoterMinAction extends Action {
    function execute() {
        
        print("<p style='color: #228CFD';>Donnez le nombre d'article minimum pour obtenir une liste de chercheur ayant annoté au moins ce nombre donné ↓</p>");

        // on vérifie qu'une variable d'url existe
        if ($this->http_method === 'GET'){
            
            echo <<<FIN
                <!doctype html>
                <html lang='fr'>
                <head>
                    <title> Article Min SQL</title>
                </head>

                <body>
                    <form method="POST" id="form1" action="?action=ListCherAnnoterMin">
                        <input type="number"
                            name="Nombre_Article"
                            placeholder="Minimum article">
                        <button type="submit" > Envoyer </button>
                        
                FIN;
        print("<br>");
        }
        else {
            // récupération de la variable en POST
            $nb =$_POST[ 'Nombre_Article' ] ; 
            // Instanciation d'un objet RepositorySQL
            $rep = new RepositorySQL();
            // appel de la m"thode ListCherAnnoterMin en convertissant le paramètre en integer
            $rep->ListCherAnnoterMin(intval($nb));
        
        }        
    }
}