<?php
declare(strict_types=1);
namespace sql\action;
class Stat_ChercheurAction extends Action {
    public function execute() {
        print("<p style='color: #228CFD';>Donnez le sigle d'un laboratoire afin d'obtenir les statistiques de chaque chercheurs y travaillant ↓</p>");

        // on vérifie qu'une variable d'url existe
        if ($this->http_method === 'GET'){
            // on affiche le formulaire nécessaire
            echo <<<FIN
                <!doctype html>
                <html lang='fr'>
                <head>
                    <title> Article Min SQL</title>
                </head>

                <body>
                    <form method="POST" id="form1" action="?action=Stat_Chercheur">
                        <input type="text"
                            name="Nom_labo"
                            placeholder="Sigle du laboratoire">
                        <button type="submit" > Envoyer </button>
                        
                FIN;
        print("<br>");
        }
        else {
            // on récupère la variable POST du formulaire
            $SigleL =$_POST[ 'Nom_labo' ] ; 
            // on instancie un objet RepositorySQL
            $rep = new RepositorySQL();
            // on appelle la méthode de l'objet RepositorySQL adéquate
            $rep->Stat_labo($SigleL);
        
        }
    }
}